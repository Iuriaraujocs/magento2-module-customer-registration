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

namespace Iuriaraujocs\Customer\Model\AccountManagement\Registration\AttributeRules;

use Magento\Customer\Api\Data\CustomerInterface;

class FirstnameWithoutWhiteSpacesRule
{

    /**
     * Apply firstname without white spaces rule
     *
     * @param CustomerInterface $customerData
     * @return void
     */
    public function execute(CustomerInterface $customerData): void
    {
        $firstname = $customerData->getFirstname();
        $formattedFirstname = preg_replace('/\s+/', '', $firstname);
        $customerData->setFirstname($formattedFirstname);
    }
}
