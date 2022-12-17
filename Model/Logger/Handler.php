<?php

declare(strict_types=1);

namespace Iuriaraujocs\Customer\Model\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class Handler extends Base
{
    /** @var int  */
    protected $loggerType = Logger::INFO;

    /** @var string  */
    protected $fileName = '/var/log/custom-customer-registration.log';
}
