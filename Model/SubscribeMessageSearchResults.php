<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
declare(strict_types=1);

namespace AlbertMage\WeChat\Model;

use AlbertMage\WeChat\Api\Data\SubscribeMessageSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with subscribe message search results.
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class SubscribeMessageSearchResults extends SearchResults implements SubscribeMessageSearchResultsInterface
{
}
