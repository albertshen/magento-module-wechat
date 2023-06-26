<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Api;

/**
 * Interface for managing weapp accounts.
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface WeAppUserManagementInterface extends WeChatUserManagementInterface
{
    /**
     * Register with use phone number
     *
     * @param string $guestToken
     * @param string $code
     * @return \AlbertMage\Customer\Api\Data\CustomerTokenInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function register($guestToken, $code);
}