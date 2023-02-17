<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Model\WeApp;

use AlbertMage\WeChat\Model\WeChat;
use AlbertMage\WeChat\Api\WeAppUserManagerInterface;
use AlbertMage\Customer\Api\Data\SocialAccountInterfaceFactory;
use AlbertMage\Customer\Api\CustomerTokenServiceInterface;

/**
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class UserManager implements WeAppUserManagerInterface
{

    const APPLICATION = 'Miniprogram';

    const PLATFORM = 'WeChat';

    /**
     * @var WeChat
     */
    private $wechat;

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
     * @param WeChat $wechat
     * @param SocialAccountInterfaceFactory $socialAccountInterfaceFactory
     * @param CustomerTokenServiceInterface $customerTokenService 
     */
    public function __construct(
        WeChat $wechat,
        SocialAccountInterfaceFactory $socialAccountInterfaceFactory,
        CustomerTokenServiceInterface $customerTokenService
    ) {
        $this->wechat = $wechat;
        $this->socialAccountInterfaceFactory = $socialAccountInterfaceFactory;
        $this->customerTokenService = $customerTokenService;
    }

    /**
     * @inheritdoc
     */
    public function login($code)
    {
        if (!$code) {
            throw new \Magento\Framework\Exception\LocalizedException(__("code is incorrect"), null, 4001);
        }

        $app = $this->wechat->getWeApp();

        $api = $app->getClient();

        $response = $api->get('/sns/jscode2session', [
            'query' => [
                    "appid" => $app->getConfig()['app_id'],
                    "secret" => $app->getConfig()['secret'],
                    "js_code" => $code,
                    "grant_type" => "authorization_code"
                ]
            ]
        );

        $userinfo = $response->toArray();

        //get user info
        $socialUser = $this->socialAccountInterfaceFactory->create();
        $socialUser->setOpenId($userinfo['openid']);
        $socialUser->setUnionId($userinfo['unionid'] ?? '');
        $socialUser->setApplication(self::APPLICATION);
        $socialUser->setPlatform(self::PLATFORM);

        return $this->customerTokenService->createCustomerAccessToken($socialUser);
    }

}
