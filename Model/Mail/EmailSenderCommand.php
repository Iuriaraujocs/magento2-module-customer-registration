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

namespace Iuriaraujocs\Customer\Model\Mail;

use Iuriaraujocs\Customer\Api\EmailSenderCommandInterface;
use Iuriaraujocs\Customer\Model\Mail\Sender\EmailSender;
use Magento\Customer\Api\Data\CustomerInterface;
use Psr\Log\LoggerInterface;

class EmailSenderCommand implements EmailSenderCommandInterface
{

    /**
     * @var EmailSender
     */
    private $emailSender;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Construct method
     *
     * @param EmailSender $emailSender
     * @param LoggerInterface $logger
     */
    public function __construct(
        EmailSender $emailSender,
        LoggerInterface $logger
    ) {
        $this->emailSender = $emailSender;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function execute(CustomerInterface $customerData)
    {
        try {
            $this->emailSender->sendEmail($customerData);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}
