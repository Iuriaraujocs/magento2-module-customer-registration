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

namespace Iuriaraujocs\Customer\Observer;

use Iuriaraujocs\Customer\Api\Data\ConfigDataInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Magento\Customer\Api\Data\CustomerInterface;

class LogCustomerDataAfterRegister implements ObserverInterface
{

    /**
     * @var ConfigDataInterface
     */
    private $config;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Construct method
     *
     * @param ConfigDataInterface $config
     * @param LoggerInterface $logger
     */
    public function __construct(
        ConfigDataInterface $config,
        LoggerInterface $logger
    ) {
        $this->config = $config;
        $this->logger = $logger;
    }

    /**
     * Custom logger after customer registration
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            if (!$this->config->isModuleEnable()) {
                return;
            }
            $customer = $observer
                ->getEvent()
                ->getCustomer();
            $this->logger
                ->info($this->getSuccessResponse($customer));
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * Get formatted response
     *
     * @param CustomerInterface $customer
     * @return string
     */
    private function getSuccessResponse(CustomerInterface $customer): string
    {
        $data = [
            'status' => 'ok',
            'customer data' => [
                'registration date' => $customer->getCreatedAt(),
                'firstname' => $customer->getFirstname(),
                'lastname' => $customer->getLastname(),
                'email' => $customer->getEmail()
            ]
        ];
        return json_encode($data);
    }
}
