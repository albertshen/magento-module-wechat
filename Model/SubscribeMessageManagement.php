<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Model;

use AlbertMage\WeChat\Model\SubscribeMessageRepository;
use AlbertMage\WeChat\Model\SubscribeMessageFactory;

/**
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class SubscribeMessageManagement
{

    /**
     * @var SubscribeMessageRepository
     */
    private $subscribeMessageRepository;

    /**
     * @var SubscribeMessageFactory
     */
    private $subscribeMessageFactory;

    /**
     * Initialize service
     *
     * @param SubscribeMessageRepository $subscribeMessageRepository
     * @param SubscribeMessageFactory $subscribeMessageFactory
     */
    public function __construct(
        SubscribeMessageRepository $subscribeMessageRepository,
        SubscribeMessageFactory $subscribeMessageFactory
    ) {
        $this->subscribeMessageRepository = $subscribeMessageRepository;
        $this->subscribeMessageFactory = $subscribeMessageFactory;
    }

    /**
     * Retrieve bound customer.
     *
     * @param string $openId
     * @param string $templateId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function hasSubscribe($openid, $templateId)
    {
        if ($message = $this->subscribeMessageRepository->getOneByOpenIdAndTemplateId($openid, $templateId)) {
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
    public function subscribe($openid, $templateId)
    {
        if ($message = $this->subscribeMessageRepository->getOneByOpenIdAndTemplateId($openid, $templateId)) {
            $message->setSetSubscribeTimes($message->getSubscribeTimes() + 1);
        } else {
            $message = $this->subscribeMessageFactory->create();
            $message->setSetSubscribeTimes(1);
        }
        $this->subscribeMessageRepository->save($message);
    }

    /**
     * Retrieve bound customer.
     *
     * @param string $openId
     * @param string $templateId
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function reduceSubscribe($openid, $templateId)
    {
        $message = $this->subscribeMessageRepository->getOneByOpenIdAndTemplateId($openid, $templateId);
        if ($message->getSubscribeTimes() > 0) {
            $message->setSubscribeTimes($message->getSubscribeTimes() - 1);
            $this->subscribeMessageRepository->save($message);
        }
    }
}
