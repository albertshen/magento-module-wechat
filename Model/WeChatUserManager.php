<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Model;

use AlbertMage\WeChat\Api\WeChatUserManagerInterface;
use AlbertMage\Customer\Api\Data\SocialAccountInterfaceFactory;

/**
 * Interface SocialUserManagerInterface
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class WeChatUserManager extends WeChatUserManagerInterface
{

    const APPLICATION = 'Miniprogram';

    const PLATFORM = 'WeChat';

    /**
     * @var SocialAccountInterfaceFactory
     */
    private $socialAccountInterfaceFactory;

    /**
     * Initialize service
     *
     * @param SocialAccountInterfaceFactory $socialAccountInterfaceFactory
     */
    public function __construct(
        SocialAccountInterfaceFactory $socialAccountInterfaceFactory
    ) {
        $this->socialAccountInterfaceFactory = $socialAccountInterfaceFactory;
    }
    /**
     * @inheritdoc
     */
    public function createCustomerAccessToken($code)
    {
        if (!$code) {
            throw new \Magento\Framework\Exception\LocalizedException(__("code is incorrect"), null, 4001);
        }
        //get user info
        $this->socialAccountInterfaceFactory->create();
        $openId = 'd4d6-6sfdddsaddf';
        $unionId = 'uuasfd-d6334fsssdaffsadsfdsadasdfffsddsaf';
        $this->socialUser->setOpenId($openId);
        $this->socialUser->setUnionId($unionId);
        //do somethings
        return $this->socialUser;
    }

}
