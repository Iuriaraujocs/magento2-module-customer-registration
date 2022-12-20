<?php

declare(strict_types=1);

namespace Iuriaraujocs\Customer\Api;

use Magento\Customer\Api\Data\CustomerInterface;

interface AttributeRulesCommandInterface
{

    /**
     * Apply attribute rules command
     *
     * @param CustomerInterface $customerData
     * @return mixed
     */
    public function execute(CustomerInterface $customerData);
}
