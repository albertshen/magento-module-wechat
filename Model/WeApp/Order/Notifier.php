<?php

namespace AlbertMage\WeChat\Model\WeApp\Order;

use Magento\Framework\Event\ManagerInterface as EventManagerInterface;
use Magento\Sales\Api\Data\OrderInterface;
use AlbertMage\WeChat\Model\Config;
use AlbertMage\WeChat\Model\WeApp\SenderFactory;
use AlbertMage\WeChat\Model\WeApp\MessageFactory;
use AlbertMage\Notification\Model\Order\NotifierInterface;
use AlbertMage\Notification\Api\Data\NotificationInterface;
use AlbertMage\Customer\Api\Data\SocialAccountInterfaceFactory;
use AlbertMage\WeChat\Model\SubscribeMessageManagementFactory;

class Notifier implements NotifierInterface
{

    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var SenderFactory
     */
    protected $senderFactory;

    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    /**
     * @var SocialAccountInterfaceFactory
     */
    protected $socialAccountInterfaceFactory;

    /**
     * @var SubscribeMessageManagementFactory
     */
    protected $subscribeMessageManagementFactory;

    /**
     * @param EventManagerInterface $eventManager
     * @param Config $config
     * @param SenderFactory $senderFactory
     * @param MessageFactory $messageFactory
     * @param SocialAccountInterfaceFactory $socialAccountInterfaceFactory
     * @param SubscribeMessageManagementFactory $subscribeMessageManagementFactory
     */
    public function __construct(
        EventManagerInterface $eventManager,
        Config $config,
        SenderFactory $senderFactory,
        MessageFactory $messageFactory,
        SocialAccountInterfaceFactory $socialAccountInterfaceFactory,
        SubscribeMessageManagementFactory $subscribeMessageManagementFactory
    ) {
        $this->eventManager = $eventManager;
        $this->config = $config;
        $this->senderFactory = $senderFactory;
        $this->messageFactory = $messageFactory;
        $this->socialAccountInterfaceFactory = $socialAccountInterfaceFactory;
        $this->subscribeMessageManagementFactory = $subscribeMessageManagementFactory;
    }

    /**
     * @param OrderInterface $order
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return \AlbertMage\Notification\Api\Data\NotificationInterface
     */
    public function notify(OrderInterface $order, string $event, NotificationInterface $notification)
    {

        if (!$this->config->isSubscribeMessageEnabled($order->getStore()->getId())) {
            return $notification;
        }

        $weappUser = $this->socialAccountInterfaceFactory->create()->load($order->getCustomerId(), 'customer_id');

        $message = $this->messageFactory->create();

        $message->setToUser($weappUser->getOpenId());

        //prepare template data
        $this->eventManager->dispatch(
            Config::GATEWAY_TYPE . '_' . $event . '_set_message_before',
            ['order' => $order, 'message' => $message]
        );

        $subscribeMessageManagement = $this->subscribeMessageManagementFactory->create();
        
        if (!$subscribeMessageManagement->hasSubscribe($weappUser->getOpenId(), $message->getTemplateId())) {
            return $notification;
        }

        $response = $this->senderFactory->create()->send($message);

        $subscribeMessageManagement->reduceSubscribe($weappUser->getOpenId(), $message->getTemplateId());
        
        $notification
            ->setTouser($message->getToUser())
            ->setStoreId($order->getStore()->getId())
            ->setType(Config::GATEWAY_TYPE)
            ->setEvent($event)
            ->setTemplateId($message->getTemplateId())
            ->setMessageData(json_encode($message->getMessageData()))
            ->setGateway(Config::GATEWAY)
            ->setCustomerId($order->getCustomerId())
            ->setIncrementId($order->getIncrementId())
            ->setStatus($response->getStatus())
            ->setSid($response->getSid())
            ->setResponse($response->getBody());

        return $notification;
    }

}