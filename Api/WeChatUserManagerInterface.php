<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Api;

/**
 * Interface for managing wechat accounts.
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface WeChatUserManagerInterface
{
    /**
     * Create customer access token.
     *
     * @param string $code
     * @return \AlbertMage\Customer\Api\Data\CustomerTokenInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function login($code);
}