<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Api;

/**
 * Interface for managing wechat subscribe message.
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface SubscribeMessageManagementInterface
{
    /**
     * Customer subscribe message.
     *
     * @param int $customerId
     * @param string[] $templateIds
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function customerSubscribe($customerId, $templateIds);

    /**
     * Retrieve subscribe message templates.
     *
     * @return \AlbertMage\WeChat\Api\Data\SubscribeMessageTemplateInterface[]
     */
    public function getTemplateIds();
}