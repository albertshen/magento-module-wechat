<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Model;

use AlbertMage\WeChat\Model\SubscribeMessageRepository;
use AlbertMage\WeChat\Model\SubscribeMessageFactory;
use AlbertMage\WeChat\Model\SubscribeMessageTemplateFactory;
use AlbertMage\Customer\Model\ResourceModel\SocialAccountRepository;

/**
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class SubscribeMessageManagement implements \AlbertMage\WeChat\Api\SubscribeMessageManagementInterface
{

    /**
     * @var SubscribeMessageRepository
     */
    protected $subscribeMessageRepository;

    /**
     * @var SubscribeMessageFactory
     */
    protected $subscribeMessageFactory;

    /**
     * @var SocialAccountRepository
     */
    protected $socialAccountRepository;

    /**
     * @var SubscribeMessageTemplateFactory
     */
    protected $subscribeMessageTemplateFactory;

    /**
     * Initialize service
     *
     * @param SubscribeMessageRepository $subscribeMessageRepository
     * @param SubscribeMessageFactory $subscribeMessageFactory
     * @param SocialAccountRepository $socialAccountRepository
     * @param SubscribeMessageTemplateFactory $subscribeMessageTemplateFactory
     */
    public function __construct(
        SubscribeMessageRepository $subscribeMessageRepository,
        SubscribeMessageFactory $subscribeMessageFactory,
        SocialAccountRepository $socialAccountRepository,
        SubscribeMessageTemplateFactory $subscribeMessageTemplateFactory
    ) {
        $this->subscribeMessageRepository = $subscribeMessageRepository;
        $this->subscribeMessageFactory = $subscribeMessageFactory;
        $this->socialAccountRepository = $socialAccountRepository;
        $this->subscribeMessageTemplateFactory = $subscribeMessageTemplateFactory;
    }

    /**
     * @inheritDoc
     */
    public function customerSubscribe($customerId, $templateIds)
    {
        $weappUser = $this->socialAccountRepository->getWeChatMiniprogramAccount($customerId);
        if ($weappUser) {
            foreach($templateIds as $templateId) {
                $this->subscribe($weappUser->getOpenId(), $templateId);
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function getTemplateIds()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $eventGroupMap = \AlbertMage\Notification\Model\ConfigInterface::EVENT_GROUP_MAP;

        $config = $objectManager->create(\AlbertMage\WeChat\Model\Config::class);


        $templatesTmp = [];

        foreach($eventGroupMap as $event => $type) {
            $enabled = $config->getConfigValue('subcribe_message/order/'.$event.'_enabled');
            $senario = $config->getConfigValue('subcribe_message/order/'.$event.'_senario');
            if ($enabled && $senario && $senario != 'none') {
                $templatesTmp[$senario][] = $config->getConfigValue('subcribe_message/order/'.$event.'_template');
            }
        }

        $templates = [];

        foreach ($templatesTmp as $senario => $ids) {
            $template = $this->subscribeMessageTemplateFactory->create();
            $template->setSenario($senario);
            $template->setTemplateIds($ids);
            $templates[] = $template;
        }

        return $templates;
    }

    /**
     * Retrieve bound customer.
     *
     * @param string $openId
     * @param string $templateId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function hasSubscribe($openId, $templateId)
    {
        if ($message = $this->subscribeMessageRepository->getOneByOpenIdAndTemplateId($openId, $templateId)) {
            if ($message->getSubscribeTimes() > 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Retrieve bound customer.
     *
     * @param string $openId
     * @param string $templateId
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function subscribe($openId, $templateId)
    {
        if ($message = $this->subscribeMessageRepository->getOneByOpenIdAndTemplateId($openId, $templateId)) {
            $message->setSubscribeTimes($message->getSubscribeTimes() + 1);
        } else {
            $message = $this->subscribeMessageFactory->create();
            $message->setOpenId($openId);
            $message->setTemplateId($templateId);
            $message->setSubscribeTimes(1);
        }
        $message->save();
    }

    /**
     * Retrieve bound customer.
     *
     * @param string $openId
     * @param string $templateId
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function reduceSubscribe($openId, $templateId)
    {
        $message = $this->subscribeMessageRepository->getOneByOpenIdAndTemplateId($openId, $templateId);
        if ($message->getSubscribeTimes() > 0) {
            $message->setSubscribeTimes($message->getSubscribeTimes() - 1);
            $this->subscribeMessageRepository->save($message);
        }
    }
}
