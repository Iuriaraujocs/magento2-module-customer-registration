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

namespace Iuriaraujocs\Customer\Model\Mail\Sender\Data;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;

class EmailData
{
    /**
     * @var string
     */
    const GENERAL_NAME = 'trans_email/ident_general/name';

    /**
     * @var string
     */
    const GENERAL_EMAIL = 'trans_email/ident_general/email';

    /**
     * @var string
     */
    const SUPPORT_EMAIL = 'trans_email/ident_support/email';

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Construct method
     *
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get email template options
     *
     * @return array
     */
    public function getTemplateOptions(): array
    {
        $storeId = $this->storeManager
            ->getStore()
            ->getId();
        return [
            'area' => Area::AREA_FRONTEND,
            'store' => $storeId
        ];
    }

    /**
     * Get email from data
     *
     * @return array
     */
    public function getFromData(): array
    {
        $fromEmail = $this->scopeConfig->getValue(self::GENERAL_EMAIL, ScopeInterface::SCOPE_STORE);
        $fromName = $this->scopeConfig->getValue(self::GENERAL_NAME, ScopeInterface::SCOPE_STORE);
        return ['email' => $fromEmail, 'name' => $fromName];
    }

    /**
     * Get email template vars
     *
     * @param CustomerInterface $customer
     * @return array
     */
    public function getTemplateVars(CustomerInterface $customer): array
    {
        $templateVars = [
            'firstname' => $customer->getFirstname(),
            'lastname' => $customer->getLastname(),
            'email' => $customer->getEmail()
        ];
        return $templateVars;
    }

    /**
     * Get to email
     *
     * @return string
     */
    public function getToEmail(): string
    {
        return $this->scopeConfig
            ->getValue(self::SUPPORT_EMAIL, ScopeInterface::SCOPE_STORE);
    }
}
