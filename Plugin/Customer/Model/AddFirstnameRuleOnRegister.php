<?php

declare(strict_types=1);

namespace Iuriaraujocs\Customer\Plugin\Customer\Model;

use Iuriaraujocs\Customer\Api\AttributeRulesCommandInterface;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\Data\CustomerInterface;

class AddFirstnameRuleOnRegister
{

    /**
     * @var AttributeRulesCommandInterface
     */
    private $attributeRulesCommand;

    /**
     * Construct method
     *
     * @param AttributeRulesCommandInterface $attributeRulesCommand
     */
    public function __construct(
        AttributeRulesCommandInterface $attributeRulesCommand
    ) {
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
        $this->attributeRulesCommand
            ->execute($customerData);

        return [$customerData, $password, $redirectUrl];
    }
}
