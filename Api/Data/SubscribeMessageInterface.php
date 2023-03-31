<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Api\Data;

/**
 * SubscribeMessage Interface
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface SubscribeMessageInterface
{

    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = 'id';
    const OPENID = 'openid';
    const TEMPLATE_ID = 'template_id';
    const SUBSCRIBE_TIMES = 'subscribe_times';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get openId
     *
     * @return string
     */
    public function getOpenId();

    /**
     * Set openId
     *
     * @param string $openId
     * @return $this
     */
    public function setOpenId($openId);

    /**
     * Get templateId
     *
     * @return string
     */
    public function getTemplateId();

    /**
     * Set templateId
     *
     * @param string $templateId
     * @return $this
     */
    public function setTemplateId($templateId);

    /**
     * Get subscribe times
     *
     * @return int
     */
    public function getSubscribeTimes();

    /**
     * Set subscribe times
     *
     * @param int $subscribeTimes
     * @return $this
     */
    public function setSubscribeTimes($subscribeTimes);

}
