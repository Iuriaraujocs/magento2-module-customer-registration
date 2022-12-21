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

namespace Iuriaraujocs\Customer\Model\Mail\Sender;

use Magento\Customer\Api\Data\CustomerInterface;
use Iuriaraujocs\Customer\Model\Mail\Sender\Data\EmailData;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\ScopeInterface;

class EmailSender
{
    /**
     * @var string
     */
    const TEMPLATE_ID = 'custom_customer_data_registration';

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var StateInterface
     */
    private $inlineTranslation;

    /**
     * @var EmailData
     */
    private $emailData;

    /**
     * Construct method
     *
     * @param EmailData $emailData
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $state
     */
    public function __construct(
        EmailData $emailData,
        TransportBuilder $transportBuilder,
        StateInterface $state
    ) {
        $this->emailData = $emailData;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $state;
    }

    /**
     * Send custom customer registration email
     *
     * @param CustomerInterface $customer
     * @return void
     */
    public function sendEmail(CustomerInterface $customer)
    {
        $this->inlineTranslation->suspend();
        $transport = $this->transportBuilder
            ->setTemplateIdentifier(self::TEMPLATE_ID, ScopeInterface::SCOPE_STORE)
            ->setTemplateOptions($this->emailData->getTemplateOptions())
            ->setTemplateVars($this->emailData->getTemplateVars($customer))
            ->setFrom($this->emailData->getFromData())
            ->addTo($this->emailData->getToEmail())
            ->getTransport();
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }
}
