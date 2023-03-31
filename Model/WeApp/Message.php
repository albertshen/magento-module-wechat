<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Model\WeApp;

use Magento\Framework\DataObject;
use AlbertMage\WeChat\Api\Data\MessageInterface;

/**
 *  Subscribe message.
 * 
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class Message extends DataObject implements MessageInterface
{

    /**
     * Get to user.
     * 
     * @return string
     */
    public function getToUser()
    {
        return $this->getData(self::TO_USER);
    }

    /**
     * Set to user.
     * 
     * @param string $toUser
     * @return $this
     */
    public function setToUser($toUser)
    {
        return $this->setData(self::TO_USER, $toUser);
    }

    /**
     * Get template id.
     *
     * @return string
     */
    public function getTemplateId()
    {
        return $this->getData(self::TEMPLATE_ID);
    }

    /**
     * Set template id.
     * 
     * @param string $templateId
     * @return $this
     */
    public function setTemplateId(string $templateId)
    {
        return $this->setData(self::TEMPLATE_ID, $templateId);
    }

    /**
     * Get page.
     *
     * @return string
     */
    public function getPage()
    {
        return $this->getData(self::PAGE);
    }

    /**
     * Set page.
     * 
     * @param string $page
     * @return $this
     */
    public function setPage(string $page)
    {
        return $this->setData(self::PAGE, $page);
    }

    /**
     * Get message data.
     * 
     * @return array
     */
    public function getMessageData()
    {
        return $this->getData(self::MESSAGE_DATA);
    }

    /**
     * Set message data.
     * 
     * @param array $messageData
     * @return $this
     */
    public function setMessageData(array $messageData)
    {
        return $this->setData(self::MESSAGE_DATA, $messageData);
    }
}