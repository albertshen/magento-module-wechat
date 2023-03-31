<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AlbertMage\WeChat\Model\WeApp;

use AlbertMage\WeChat\Api\Data\MessageInterface;
use AlbertMage\WeChat\Model\WeChat;
use AlbertMage\Notification\Api\Data\ResponseInterfaceFactory;
use Magento\Framework\Exception\LocalizedException;
use AlbertMage\Notification\Api\Data\ResponseInterface;

/**
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class Sender
{

    /**
     * @var WeChat
     */
    private $wechat;

    /**
     * @var ResponseInterfaceFactory
     */
    private $responseInterfaceFactory;

    /**
     * @param WeChat $wechat
     * @param ResponseInterfaceFactory $responseInterfaceFactory
     */
    public function __construct(
        WeChat $wechat,
        ResponseInterfaceFactory $responseInterfaceFactory
    )
    {
        $this->wechat = $wechat;
        $this->responseInterfaceFactory = $responseInterfaceFactory;
    }

    /**
     * Send message
     * 
     * @return \AlbertMage\Notification\Api\Data\ResponseInterface
     */
    public function send(MessageInterface $message)
    {
        $app = $this->wechat->getWeApp();

        $api = $app->getClient();

        $response = $this->responseInterfaceFactory->create();

        $res = $api->post('/cgi-bin/message/subscribe/send', [
            'json' => [
                "touser" => $message->getToUser(),
                "template_id" => $message->getTemplateId(),
                "page" => $message->getPage(),
                "data" => $message->getMessageData()
            ]
        ]);

        $resData = $res->toArray();

        if ($resData['errcode'] == 0) {
            $response->setSid((string) $resData['msgid']);
            $response->setStatus(ResponseInterface::STATUS_SUCCESS);
        } else {
            $response->setStatus(ResponseInterface::STATUS_FAILURE);
        }
        $response->setBody($res->getContent());

        return $response;

    }

}
