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

namespace Iuriaraujocs\Customer\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Helper class to get backoffice configuration of module
 */
class Data
{
    /**
     * @var string
     */
    const IS_MODULE_ENABLE = 'iuriaraujocs_customer/default/enable';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Data constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Verify if current module is active
     *
     * @return boolean
     */
    public function isModuleEnable(): bool
    {
        return (bool) $this->scopeConfig->getValue(self::IS_MODULE_ENABLE);
    }
}
