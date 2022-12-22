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

namespace Iuriaraujocs\Customer\Test\Unit\Model\AccountManagement;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iuriaraujocs\Customer\Model\AccountManagement\Registration\AttributeRulesCommand as Model;
use Magento\Customer\Api\Data\CustomerInterface;
use Psr\Log\LoggerInterface;
use Iuriaraujocs\Customer\Model\AccountManagement\Registration\AttributeRules\FirstnameWithoutWhiteSpacesRule;

class AttributeRulesCommandTest extends TestCase
{

    /**
     * @var FirstnameWithoutWhiteSpacesRule|MockObject
     */
    private $firstnameWithoutWhiteSpacesRuleMock;

    /**
     * @var CustomerInterface|MockObject
     */
    private $customerDataMock;

    /**
     * @var LoggerInterface|MockObject
     */
    private $loggerMock;

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
    public function testConstruct(): void
    {
        $this->assertInstanceOf(Model::class, $this->instance);
    }

    /**
     * @return void
     */
    public function testExecuteMethodShouldExecuteWithoutErrors(): void
    {
        $this->firstnameWithoutWhiteSpacesRuleMock
            ->expects($this->exactly(1))
            ->method('execute');
        $this->loggerMock
            ->expects($this->never())
            ->method('error');
        $this->instance->execute($this->customerDataMock);
    }

    /**
     * @return void
     */
    public function testWhenThrowExceptionShouldLog(): void
    {
        $this->firstnameWithoutWhiteSpacesRuleMock
            ->expects($this->exactly(1))
            ->method('execute')
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
    private function setMocks(): void
    {
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->firstnameWithoutWhiteSpacesRuleMock = $this->createMock(FirstnameWithoutWhiteSpacesRule::class);
        $this->customerDataMock = $this->createMock(CustomerInterface::class);
    }

    /**
     * @return void
     */
    private function setInstance(): void
    {
        $objectManager = new ObjectManager($this);
        $this->instance = $objectManager->getObject(
            Model::class,
            [
                'attributeRulesProvider' => [
                    $this->firstnameWithoutWhiteSpacesRuleMock
                ],
                'logger' => $this->loggerMock
            ]
        );
    }
}
