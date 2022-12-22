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

namespace Iuriaraujocs\Customer\Test\Unit\Plugin\Customer\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iuriaraujocs\Customer\Plugin\Customer\Model\AddFirstnameRuleOnRegister as Plugin;
use Magento\Customer\Api\Data\CustomerInterface;
use Iuriaraujocs\Customer\Api\AttributeRulesCommandInterface;
use Iuriaraujocs\Customer\Api\Data\ConfigDataInterface;
use Magento\Customer\Api\AccountManagementInterface;

class AddFirstnameRuleOnRegisterTest extends TestCase
{

    /**
     * @var AccountManagementInterface\|MockObject
     */
    private $accountManagementMock;

    /**
     * @var CustomerInterface|MockObject
     */
    private $customerDataMock;

    /**
     * @var ConfigDataInterface|MockObject
     */
    private $configMock;

    /**
     * @var AttributeRulesCommandInterface|MockObject
     */
    private $attributeRulesCommandMock;

    /**
     * @var Plugin|MockObject
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
        $this->assertInstanceOf(Plugin::class, $this->instance);
    }

    /**
     * @return void
     */
    public function testShouldntRunCommandWhenModuleIsNotEnable(): void
    {
        $this->configMock
            ->expects($this->exactly(1))
            ->method('isModuleEnable')
            ->willReturn(false);
        $this->attributeRulesCommandMock
            ->expects($this->never())
            ->method('execute');
        $result = $this->instance->beforeCreateAccount(
            $this->accountManagementMock,
            $this->customerDataMock,
            null,
            ''
        );
        $this->assertIsArray($result);
    }

    /**
     * @return void
     */
    public function testShouldRunCommandWhenModuleIsEnable(): void
    {
        $this->configMock
            ->expects($this->exactly(1))
            ->method('isModuleEnable')
            ->willReturn(true);
        $this->attributeRulesCommandMock
            ->expects($this->exactly(1))
            ->method('execute');
        $result = $this->instance->beforeCreateAccount(
            $this->accountManagementMock,
            $this->customerDataMock,
            null,
            ''
        );
        $this->assertIsArray($result);
    }

    /**
     * @return void
     */
    private function setMocks(): void
    {
        $this->customerDataMock = $this->createMock(CustomerInterface::class);
        $this->attributeRulesCommandMock = $this->createMock(AttributeRulesCommandInterface::class);
        $this->configMock = $this->createMock(ConfigDataInterface::class);
        $this->accountManagementMock = $this->createMock(AccountManagementInterface::class);
    }

    /**
     * @return void
     */
    private function setInstance(): void
    {
        $objectManager = new ObjectManager($this);
        $this->instance = $objectManager->getObject(
            Plugin::class,
            [
                'config' => $this->configMock,
                'attributeRulesCommand' => $this->attributeRulesCommandMock
            ]
        );
    }
}
