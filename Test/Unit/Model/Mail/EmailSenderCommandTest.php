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

namespace Iuriaraujocs\Customer\Test\Unit\Model\Mail;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iuriaraujocs\Customer\Model\Mail\EmailSenderCommand as Model;
use Iuriaraujocs\Customer\Model\Mail\Sender\EmailSender;
use Magento\Customer\Api\Data\CustomerInterface;
use Psr\Log\LoggerInterface;

class EmailSenderCommandTest extends TestCase
{

    /**
     * @var CustomerInterface|MockObject
     */
    private $customerDataMock;

    /**
     * @var LoggerInterface|MockObject
     */
    private $loggerMock;

    /**
     * @var EmailSender|MockObject
     */
    private $emailSenderMock;

    /**
     * @var Model|MockObject
     */
    private $instance;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->setMocks();
        $this->setInstance();
    }

    /**
     * @return void
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(Model::class, $this->instance);
    }

    /**
     * @return void
     */
    public function testExecuteMethodShouldExecuteWithoutErrors()
    {
        $this->emailSenderMock
            ->expects($this->exactly(1))
            ->method('sendEmail');
        $this->loggerMock
            ->expects($this->never())
            ->method('error');
        $this->instance->execute($this->customerDataMock);
    }

    /**
     * @return void
     */
    public function testWhenThrowExceptionShouldLog()
    {
        $this->emailSenderMock
            ->expects($this->exactly(1))
            ->method('sendEmail')
            ->willThrowException(
                new \Exception('some exception')
            );
        $this->loggerMock
            ->expects($this->exactly(1))
            ->method('error');
        $this->instance->execute($this->customerDataMock);
    }

    /**
     * @return void
     */
    private function setMocks()
    {
        $this->customerDataMock = $this->createMock(CustomerInterface::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->emailSenderMock = $this->createMock(EmailSender::class);
    }

    /**
     * @return void
     */
    private function setInstance()
    {
        $objectManager = new ObjectManager($this);
        $this->instance = $objectManager->getObject(
            Model::class,
            [
                'emailSender' => $this->emailSenderMock,
                'logger' => $this->loggerMock
            ]
        );
    }
}
