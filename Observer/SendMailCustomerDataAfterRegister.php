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
use Iuriaraujocs\Customer\Model\Mail\EmailSenderCommand;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Magento\Customer\Api\Data\CustomerInterface;

class SendMailCustomerDataAfterRegister implements ObserverInterface
{

    /**
     * @var ConfigDataInterface
     */
    private $config;

    /**
     * @var EmailSenderCommand
     */
    private $emailSenderCommand;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Construct method
     *
     * @param ConfigDataInterface $config
     * @param EmailSenderCommand $emailSenderCommand
     */
    public function __construct(
        ConfigDataInterface $config,
        EmailSenderCommand $emailSenderCommand,
        LoggerInterface $logger
    ) {
        $this->config = $config;
        $this->emailSenderCommand = $emailSenderCommand;
        $this->logger = $logger;
    }

    /**
     * Execute email command
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
            $this->emailSenderCommand
                ->execute($customer);
        } catch (\Exception $e) {
            $this->logger
                ->critical($e->getMessage());
        }
    }
}
