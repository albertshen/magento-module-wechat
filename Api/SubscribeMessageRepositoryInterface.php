<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Api;

/**
 * SubscribeMessage CRUD interface.
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface SubscribeMessageRepositoryInterface
{
    /**
     * Save subscribeMessage.
     *
     * @param \AlbertMage\WeChat\Api\Data\SubscribeMessageInterface $subscribeMessage
     * @return \AlbertMage\WeChat\Api\Data\SubscribeMessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\AlbertMage\WeChat\Api\Data\SubscribeMessageInterface $subscribeMessage);

    /**
     * Delete subscribeMessage.
     *
     * @param \AlbertMage\WeChat\Api\Data\SubscribeMessageInterface $subscribeMessage
     * @return \AlbertMage\WeChat\Api\Data\SubscribeMessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\AlbertMage\WeChat\Api\Data\SubscribeMessageInterface $subscribeMessage);

    /**
     * Retrieve subscribeMessage.
     *
     * @param int $subscribeMessageId
     * @return \AlbertMage\WeChat\Api\Data\SubscribeMessageInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($subscribeMessageId);

    /**
     * Retrieve subscribeMessage matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \AlbertMage\WeChat\Api\Data\SubscribeMessageSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
