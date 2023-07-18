<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Model;

use Magento\Framework\DataObject;
use AlbertMage\WeChat\Api\Data\SubscribeMessageTemplateInterface;

/**
 * Class SubscribeMessageTemplate
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class SubscribeMessageTemplate extends DataObject implements SubscribeMessageTemplateInterface
{

    /**
     * Get senario.
     * 
     * @return string
     */
    public function getSenario()
    {
        return $this->getData(self::SENARIO);
    }

    /**
     * Set senario.
     * 
     * @param string $senario
     * @return $this
     */
    public function setSenario($senario)
    {
        return $this->setData(self::SENARIO, $senario);
    }

    /**
     * Get template ids.
     *
     * @return string[]
     */
    public function getTemplateIds()
    {
        return $this->getData(self::TEMPLATE_IDS);
    }

    /**
     * Set template ids.
     * 
     * @param string[] $templateIds
     * @return $this
     */
    public function setTemplateIds($templateIds)
    {
        return $this->setData(self::TEMPLATE_IDS, $templateIds);
    }

}
