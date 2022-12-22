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

namespace Iuriaraujocs\Customer\Test\Unit\Observer;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iuriaraujocs\Customer\Observer\LogCustomerDataAfterRegister;
use Magento\Customer\Api\Data\CustomerInterface;
use Iuriaraujocs\Customer\Api\Data\ConfigDataInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event;

class LogCustomerDataAfterRegisterTest extends TestCase
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
     * @var ConfigDataInterface|MockObject
     */
    private $configMock;

    /**
     * @var Observer|MockObject
     */
    private $observerMock;

    /**
     * @var Event|MockObject
     */
    private $eventMock;

    /**
     * @var LogCustomerDataAfterRegister|MockObject
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
    public function testConstruct(): void
    {
        $this->assertInstanceOf(LogCustomerDataAfterRegister::class, $this->instance);
    }

    /**
     * @return void
     */
    public function testShouldntProceedWhenModuleIsNotEnable(): void
    {
        $this->configMock
            ->expects($this->exactly(1))
            ->method('isModuleEnable')
            ->willReturn(false);

        $result = $this->instance->execute($this->observerMock);
        $this->assertNull($result);
    }

    /**
     * @return void
     */
    public function testShouldProceedUntilApplyLog(): void
    {
        $this->configMock
            ->expects($this->exactly(1))
            ->method('isModuleEnable')
            ->willReturn(true);
        $this->observerMock
            ->expects($this->exactly(1))
            ->method('getEvent')
            ->willReturn($this->eventMock);
        $this->eventMock
            ->expects($this->exactly(1))
            ->method('getCustomer')
            ->willReturn($this->customerDataMock);
        $this->customerDataMock
            ->expects($this->exactly(1))
            ->method('getCreatedAt')
            ->willReturn('some date');
        $this->customerDataMock
            ->expects($this->exactly(1))
            ->method('getFirstname')
            ->willReturn('some firstname');
        $this->customerDataMock
            ->expects($this->exactly(1))
            ->method('getLastname')
            ->willReturn('some lastname');
        $this->customerDataMock
            ->expects($this->exactly(1))
            ->method('getEmail')
            ->willReturn('some email');
        $this->loggerMock
            ->expects($this->exactly(1))
            ->method('info')
            ->willReturnSelf();
        $result = $this->instance->execute($this->observerMock);
        $this->assertNull($result);
    }

    /**
     * @return void
     */
    public function testShouldApplyCriticalLogOnException(): void
    {
        $this->configMock
            ->expects($this->exactly(1))
            ->method('isModuleEnable')
            ->willReturn(true);
        $this->observerMock
            ->expects($this->exactly(1))
            ->method('getEvent')
            ->willReturn($this->eventMock);
        $this->eventMock
            ->expects($this->exactly(1))
            ->method('getCustomer')
            ->willThrowException(
                new \Exception('some exception')
            );
        $this->loggerMock
            ->expects($this->exactly(1))
            ->method('critical')
            ->willReturnSelf();
        $result = $this->instance->execute($this->observerMock);
        $this->assertNull($result);
    }

    /**
     * @return void
     */
    private function setMocks(): void
    {
        $this->customerDataMock = $this->createMock(CustomerInterface::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->configMock = $this->createMock(ConfigDataInterface::class);
        $this->observerMock = $this->createMock(Observer::class);
        $this->eventMock = $this->getMockBuilder(Event::class)
            ->addMethods(['getCustomer'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return void
     */
    private function setInstance(): void
    {
        $objectManager = new ObjectManager($this);
        $this->instance = $objectManager->getObject(
            LogCustomerDataAfterRegister::class,
            [
                'config' => $this->configMock,
                'logger' => $this->loggerMock
            ]
        );
    }
}
