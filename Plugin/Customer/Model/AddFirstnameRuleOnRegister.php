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

namespace Iuriaraujocs\Customer\Plugin\Customer\Model;

use Iuriaraujocs\Customer\Api\AttributeRulesCommandInterface;
use Iuriaraujocs\Customer\Api\Data\ConfigDataInterface;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\Data\CustomerInterface;

class AddFirstnameRuleOnRegister
{

    /**
     * @var ConfigDataInterface
     */
    private $config;

    /**
     * @var AttributeRulesCommandInterface
     */
    private $attributeRulesCommand;

    /**
     * Construct method
     *
     * @param ConfigDataInterface $config
     * @param AttributeRulesCommandInterface $attributeRulesCommand
     */
    public function __construct(
        ConfigDataInterface $config,
        AttributeRulesCommandInterface $attributeRulesCommand
    ) {
        $this->config = $config;
        $this->attributeRulesCommand = $attributeRulesCommand;
    }

    /**
     * Apply custom attribute rules to customer data
     *
     * @param AccountManagementInterface $subject
     * @param CustomerInterface $customerData
     * @param mixed $password
     * @param mixed $redirectUrl
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeCreateAccount(
        AccountManagementInterface $subject,
        CustomerInterface $customerData,
        $password = null,
        $redirectUrl = ''
    ) {
        if ($this->config->isModuleEnable()) {
            $this->attributeRulesCommand
                ->execute($customerData);
        }

        return [$customerData, $password, $redirectUrl];
    }
}
