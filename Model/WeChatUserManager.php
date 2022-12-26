<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Model;

use AlbertMage\WeChat\Api\WeChatUserManagerInterface;
use AlbertMage\Customer\Api\Data\SocialAccountInterfaceFactory;
use AlbertMage\Customer\Api\CustomerTokenServiceInterface;

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
     * @var CustomerTokenServiceInterface
     */
    private $customerTokenService;

    /**
     * Initialize service
     *
     * @param SocialAccountInterfaceFactory $socialAccountInterfaceFactory
     * @param CustomerTokenServiceInterface $customerTokenService 
     */
    public function __construct(
        SocialAccountInterfaceFactory $socialAccountInterfaceFactory,
        CustomerTokenServiceInterface $customerTokenService
    ) {
        $this->socialAccountInterfaceFactory = $socialAccountInterfaceFactory;
        $this->customerTokenService = $customerTokenService;
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
        $socialUser = $this->socialAccountInterfaceFactory->create();
        $openId = 'd4d6-6sfdddsaddf';
        $unionId = 'uuasfd-d6334fsssdaffsadsfdsadasdfffsddsaf';
        $socialUser->setOpenId($openId);
        $socialUser->setUnionId($unionId);
        $socialUser->setApplication(self::APPLICATION);
        $socialUser->setPlatform(self::PLATFORM);
        //do somethings
        return $this->customerTokenService->createCustomerAccessToken($socialUser);
    }

}
