<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 */
namespace AlbertMage\WeChat\Api;

/**
 * WeChat Interface.
 * @api
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface WeChatInterface
{
    /**
     * Get miniprogram instance.
     *
     * @return \EasyWeChat\MiniApp\Application
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getWeApp();
}