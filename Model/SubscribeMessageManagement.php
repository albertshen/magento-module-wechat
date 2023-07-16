<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Model;

use AlbertMage\WeChat\Model\SubscribeMessageRepository;
use AlbertMage\WeChat\Model\SubscribeMessageFactory;
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
     * Initialize service
     *
     * @param SubscribeMessageRepository $subscribeMessageRepository
     * @param SubscribeMessageFactory $subscribeMessageFactory
     * @param SocialAccountRepository $socialAccountRepository
     */
    public function __construct(
        SubscribeMessageRepository $subscribeMessageRepository,
        SubscribeMessageFactory $subscribeMessageFactory,
        SocialAccountRepository $socialAccountRepository
    ) {
        $this->subscribeMessageRepository = $subscribeMessageRepository;
        $this->subscribeMessageFactory = $subscribeMessageFactory;
        $this->socialAccountRepository = $socialAccountRepository;
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
