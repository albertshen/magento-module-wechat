<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AlbertMage\WeChat\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Config
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class Config
{

    /**
     * Configuration paths
     */
    const XML_PATH_PREFIX = 'wechat/weapp';

    /**
     * store
     *
     * @var int
     */
    protected $store;

    /**
     * Core store config
     *
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Set store
     *
     * @return void
     */
    public function setStore($store)
    {
        $this->store = $store;
    }

    /**
     * Get store
     *
     * @return int
     */
    public function getStore()
    {
        return $this->store;
    }


    /**
     * Check is enabled template
     * 
     * @param int $store
     * @return bool
     */
    public function isEnabled($store = null)
    {

    }

    /**
     * Return store configuration value
     *
     * @param string $path
     * @param int $store
     * @return mixed
     */
    public function getConfigValue($path, $store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_PREFIX . '/' . $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store ?? $this->store
        );
    }

}
