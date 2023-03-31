<?php
/**
 *
 * Copyright © PHP Digital, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AlbertMage\WeChat\Api\Data;

/**
 * Interface for subscribe message.
 * 
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface MessageInterface
{

    const TO_USER = 'to_user';

    const TEMPLATE_ID = 'template_id';

    const PAGE = 'page';

    const MESSAGE_DATA = 'message_data';

    /**
     * Get to user.
     * 
     * @return string
     */
    public function getToUser();

    /**
     * Set to user.
     * 
     * @param string $toUser
     * @return $this
     */
    public function setToUser($toUser);

    /**
     * Get template id.
     *
     * @return string
     */
    public function getTemplateId();

    /**
     * Set template id.
     * 
     * @param string $templateId
     * @return $this
     */
    public function setTemplateId(string $templateId);

    /**
     * Get page.
     *
     * @return string
     */
    public function getPage();

    /**
     * Set page.
     * 
     * @param string $page
     * @return $this
     */
    public function setPage(string $page);

    /**
     * Get message data.
     * 
     * @return array
     */
    public function getMessageData();

    /**
     * Set message data.
     * 
     * @param array $messageData
     * @return $this
     */
    public function setMessageData(array $messageData);
}