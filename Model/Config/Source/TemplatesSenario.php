<?php
/**
 * Copyright © PHP Digital, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AlbertMage\WeChat\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * @author Albert Shen <albertshen1206@gmail.com>
 */
class TemplatesSenario implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            ['value' => 'none', 'label' => __('None')],
            ['value' => 'after_order_place', 'label' => __('After Order Place')],
            ['value' => 'after_payment', 'label' => __('After Payment')]
        ];
        return $options;
    }
}
