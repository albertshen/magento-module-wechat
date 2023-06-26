<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Model\WeApp;

use AlbertMage\WeChat\Model\WeChat;
use AlbertMage\WeChat\Api\WeAppUserManagementInterface;
use AlbertMage\Customer\Api\Data\SocialAccountInterfaceFactory;
use AlbertMage\Customer\Api\AccountManagementInterface;
use AlbertMage\Customer\Api\CustomerTokenServiceInterface;


/**
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class UserManagement implements WeAppUserManagementInterface
{

    const APPLICATION = 'Miniprogram';

    const PLATFORM = 'WeChat';

    /**
     * @var WeChat
     */
    protected $wechat;

    /**
     * @var SocialAccountInterfaceFactory
     */
    protected $socialAccountInterfaceFactory;

    /**
     * @var CustomerTokenServiceInterface
     */
    protected $customerTokenService;

    /**
     * @var AccountManagementInterface
     */
    protected $accountManagement;
    

    /**
     * Initialize service
     *
     * @param WeChat $wechat
     * @param SocialAccountInterfaceFactory $socialAccountInterfaceFactory
     * @param CustomerTokenServiceInterface $customerTokenService 
     * @param AccountManagementInterface $accountManagement
     */
    public function __construct(
        WeChat $wechat,
        SocialAccountInterfaceFactory $socialAccountInterfaceFactory,
        CustomerTokenServiceInterface $customerTokenService,
        AccountManagementInterface $accountManagement
    ) {
        $this->wechat = $wechat;
        $this->socialAccountInterfaceFactory = $socialAccountInterfaceFactory;
        $this->customerTokenService = $customerTokenService;
        $this->accountManagement = $accountManagement;
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

    /**
     * @inheritdoc
     */
    public function register($guestToken, $code)
    {
        if (!$code) {
            throw new \Magento\Framework\Exception\LocalizedException(__("code is incorrect"), null, 4001);
        }

        $app = $this->wechat->getWeApp();

        $api = $app->getClient();

        $response = $api->post('/wxa/business/getuserphonenumber', [
            'json' => [
                    "code" => $code
                ]
            ]
        );

        $phoneInfo = $response->toArray();

        // $phoneInfo = [
        //     "errcode" => 0,
        //     "errmsg" => "ok",
        //     "phone_info" => [
        //         "phoneNumber" => "13524703158",
        //         "purePhoneNumber" => "xxxxxx",
        //         "countryCode" => 86,
        //         "watermark" => [
        //             "timestamp"=> 1637744274,
        //             "appid"=> "xxxx"
        //         ]
        //     ]
        // ];

        try {
            
            $customer = $this->accountManagement->getAccount($phoneInfo['phone_info']['phoneNumber']);

            $socialAccount = $this->socialAccountInterfaceFactory->create()->load($guestToken, 'unique_hash');

            $this->accountManagement->bindSocialAccount($customer->getId(), $socialAccount->getId());

            return $this->customerTokenService->getCustomerToken($customer);

        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\LocalizedException(__("binding failed"), null, 5001);
        }

    }

}
