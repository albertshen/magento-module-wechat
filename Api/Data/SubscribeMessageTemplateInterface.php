<?php
/**
 *
 * Copyright © PHP Digital, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AlbertMage\WeChat\Api\Data;

/**
 * Interface for subscribe message templates.
 * 
 * @author Albert Shen <albertshen1206@gmail.com>
 */
interface SubscribeMessageTemplateInterface
{

    const SENARIO = 'senario';

    const TEMPLATE_IDS = 'template_ids';

    /**
     * Get senario.
     * 
     * @return string
     */
    public function getSenario();

    /**
     * Set senario.
     * 
     * @param string $senario
     * @return $this
     */
    public function setSenario($senario);

    /**
     * Get template ids.
     *
     * @return string[]
     */
    public function getTemplateIds();

    /**
     * Set template ids.
     * 
     * @param string[] $templateIds
     * @return $this
     */
    public function setTemplateIds($templateIds);

}