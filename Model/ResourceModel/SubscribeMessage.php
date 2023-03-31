<?php
/**
 * SubscribeMessage resource model
 *
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class SubscribeMessage extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('wechat_subscribe_message', 'id');
    }
}
