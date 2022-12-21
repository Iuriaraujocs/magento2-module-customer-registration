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

use Iuriaraujocs\Customer\Api\Data\ConfigDataInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Helper class to get backoffice configuration of module
 */
class Data implements ConfigDataInterface
{

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Construct method
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritDoc
     */
    public function isModuleEnable(): bool
    {
        return (bool) $this->scopeConfig->getValue(self::IS_MODULE_ENABLE);
    }
}
