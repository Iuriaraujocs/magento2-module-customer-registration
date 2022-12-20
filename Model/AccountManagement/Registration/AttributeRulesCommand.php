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

namespace Iuriaraujocs\Customer\Model\AccountManagement\Registration;

use Iuriaraujocs\Customer\Api\AttributeRulesCommandInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Psr\Log\LoggerInterface;

class AttributeRulesCommand implements AttributeRulesCommandInterface
{
    /**
     * @var array
     */
    private $attributeRulesProvider;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Construct method
     *
     * @param array $attributeRulesProvider
     * @param LoggerInterface $logger
     */
    public function __construct(
        array $attributeRulesProvider,
        LoggerInterface $logger
    ) {
        $this->attributeRulesProvider = $attributeRulesProvider;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function execute(CustomerInterface $customerData)
    {
        try {
            foreach ($this->attributeRulesProvider as $attributeRule) {
                $attributeRule->execute($customerData);
            }

        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}
