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

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Magento\Setup\Exception;

class LogCustomerDataAfterRegister implements ObserverInterface
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Construct method
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
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
            $customer = $observer
                ->getEvent()
                ->getCustomer();

            $this->logger->info('Its work!');
        } catch (Exception $e) {
            $this->logger->critical('An error happens');
        }
    }
}
