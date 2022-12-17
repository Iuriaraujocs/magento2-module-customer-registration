<?php

declare(strict_types=1);

namespace Iuriaraujocs\Customer\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Setup\Exception;

class LogCustomerDataAfterRegister implements ObserverInterface
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        try {
            $customer = $observer
                ->getEvent()
                ->getCustomer();

            $this->logger->info('Its work!');
        } catch (Exception $e) {
            $this->logger->critical('An error happens');
        }
    }
}
