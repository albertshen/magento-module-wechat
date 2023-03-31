<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Model;

use Magento\Framework\Model\AbstractModel;
use AlbertMage\WeChat\Api\Data\SubscribeMessageInterface;

/**
 * Class SubscribeMessage
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class SubscribeMessage extends AbstractModel implements SubscribeMessageInterface
{
    
    /**
     * Initialize subscribe message model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\AlbertMage\WeChat\Model\ResourceModel\SubscribeMessage::class);
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId($id)
    {
        $this->setData(self::ID, $id);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getOpenId()
    {
        return $this->getData(self::OPENID);
    }

    /**
     * @inheritDoc
     */
    public function setOpenId($openId)
    {
        $this->setData(self::OPENID, $openId);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTemplateId()
    {
        return $this->getData(self::TEMPLATE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setTemplateId($templateId)
    {
        $this->setData(self::TEMPLATE_ID, $templateId);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSubscribeTimes()
    {
        return $this->getData(self::SUBSCRIBE_TIMES);
    }

    /**
     * @inheritDoc
     */
    public function setSubscribeTimes($subscribeTimes)
    {
        $this->setData(self::SUBSCRIBE_TIMES, $subscribeTimes);
        return $this;
    }

}
