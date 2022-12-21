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

namespace Iuriaraujocs\Customer\Api;

use Magento\Customer\Api\Data\CustomerInterface;

interface AttributeRuleInterface
{

    /**
     * Execute attribute rule
     *
     * @param CustomerInterface $customerData
     * @return void
     */
    public function execute(CustomerInterface $customerData);
}
