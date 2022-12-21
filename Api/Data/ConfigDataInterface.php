<?php
/**
 *
 * @author      Iuri Cardoso Araujo <iuriaraujoc.eng@gmail.com>
 * @copyright   Copyright (c) 2022, Iuri Cardoso Araujo
 * @link        https://github.com/iuriaraujocs
 * @package Iuriaraujocs_Customer
 *
 */
declare(strict_types=1);

namespace Iuriaraujocs\Customer\Api\Data;

interface ConfigDataInterface
{

    /**
     * @var string
     */
    const IS_MODULE_ENABLE = 'iuriaraujocs_customer/default/enable';

    /**
     * Verify if current module is active
     *
     * @return boolean
     */
    public function isModuleEnable(): bool;
}
