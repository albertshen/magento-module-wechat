<?php

namespace AlbertMage\WeChat\Model\WeApp\Order;

use Magento\Framework\Event\ManagerInterface as EventManagerInterface;
use Magento\Sales\Api\Data\OrderInterface;
use AlbertMage\WeChat\Model\Config;
use AlbertMage\WeChat\Model\WeApp\SenderFactory;
use AlbertMage\WeChat\Model\WeApp\MessageFactory;
use AlbertMage\Notification\Model\Order\NotifierInterface;
use AlbertMage\Notification\Api\Data\NotificationInterface;
use AlbertMage\Customer\Model\ResourceModel\SocialAccountRepository;
use AlbertMage\WeChat\Model\SubscribeMessageManagementFactory;
use AlbertMage\Core\Model\TokenFactory;

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
     * @var SocialAccountRepository
     */
    protected $socialAccountRepository;

    /**
     * @var SubscribeMessageManagementFactory
     */
    protected $subscribeMessageManagementFactory;
    
    /**
     * @var TokenFactory
     */
    protected $tokenFactory;

    /**
     * @param EventManagerInterface $eventManager
     * @param Config $config
     * @param SenderFactory $senderFactory
     * @param MessageFactory $messageFactory
     * @param SocialAccountRepository $socialAccountRepository
     * @param SubscribeMessageManagementFactory $subscribeMessageManagementFactory
     * @param TokenFactory $tokenFactory
     */
    public function __construct(
        EventManagerInterface $eventManager,
        Config $config,
        SenderFactory $senderFactory,
        MessageFactory $messageFactory,
        SocialAccountRepository $socialAccountRepository,
        SubscribeMessageManagementFactory $subscribeMessageManagementFactory,
        TokenFactory $tokenFactory
    ) {
        $this->eventManager = $eventManager;
        $this->config = $config;
        $this->senderFactory = $senderFactory;
        $this->messageFactory = $messageFactory;
        $this->socialAccountRepository = $socialAccountRepository;
        $this->subscribeMessageManagementFactory = $subscribeMessageManagementFactory;
        $this->tokenFactory = $tokenFactory;
    }

    /**
     * @param OrderInterface $order
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return \AlbertMage\Notification\Api\Data\NotificationInterface
     */
    public function notify(OrderInterface $order, string $event, NotificationInterface $notification)
    {

        if (!$this->config->isSubscribeMessageEnabled($order->getStore()->getId()) && $this->config->getConfigValue('subcribe_message/active')) {
            return $notification;
        }

        if (!$this->config->getConfigValue('subcribe_message/order/'.$event.'_enabled')) {
            return $notification;
        }

        $weappUser = $this->socialAccountRepository->getWeChatMiniprogramAccount($order->getCustomerId());

        $templateId = $this->config->getConfigValue('subcribe_message/order/'.$event.'_template');

        $subscribeMessageManagement = $this->subscribeMessageManagementFactory->create();
        
        if (!$subscribeMessageManagement->hasSubscribe($weappUser->getOpenId(), $templateId)) {
            return $notification;
        }

        //prepare template data
        $token = $this->tokenFactory->create();
        $token->setOrder($order);
        $token->setSocialAccount($weappUser);
        $templateData = $token->parse($this->config->getConfigValue('subcribe_message/order/'.$event.'_template_preivew'));

        //prepare message
        $message = $this->messageFactory->create();
        $message->setToUser($weappUser->getOpenId());
        $message->setTemplateId($templateId);
        $message->setPage($templateData['page']);
        $message->setMessageData($templateData['data']);

        //process template data
        $this->eventManager->dispatch(
            Config::GATEWAY_TYPE . '_' . $event . '_set_message_before',
            ['order' => $order, 'message' => $message]
        );

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