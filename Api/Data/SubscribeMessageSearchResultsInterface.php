<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Api\Data;

/**
 * Interface for node search results.
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface SubscribeMessageSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get node list.
     *
     * @return \AlbertMage\WeChat\Api\Data\SubscribeMessageInterface[]
     */
    public function getItems();

    /**
     * Set node list.
     *
     * @param \AlbertMage\WeChat\Api\Data\SubscribeMessageInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
