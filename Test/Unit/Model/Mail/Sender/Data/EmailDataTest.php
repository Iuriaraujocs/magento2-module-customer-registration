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

namespace Iuriaraujocs\Customer\Test\Unit\Model\Mail\Sender\Data;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Store\Api\Data\StoreInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iuriaraujocs\Customer\Model\Mail\Sender\Data\EmailData as Model;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;

class EmailDataTest extends TestCase
{

    /**
     * @var CustomerInterface|MockObject
     */
    private $customerDataMock;

    /**
     * @var StoreManagerInterface|MockObject
     */
    private $storeManagerMock;

    /**
     * @var StoreInterface|MockObject
     */
    private $storeMock;

    /**
     * @var ScopeConfigInterface\|MockObject
     */
    private $scopeConfigMock;

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
    public function testShouldReturnCorrectOptionsArray(): void
    {
        $this->storeManagerMock
            ->expects($this->exactly(1))
            ->method('getStore')
            ->willReturn($this->storeMock);
        $this->storeMock
            ->expects($this->exactly(1))
            ->method('getId')
            ->willReturn('5');
        $result = $this->instance->getTemplateOptions();
        $this->assertEquals(
            [
                'area' => 'frontend',
                'store' => '5'
            ],
            $result
        );
    }

    /**
     * @return void
     */
    public function testShouldReturnCorrectFromArray(): void
    {
        $this->scopeConfigMock
            ->expects($this->exactly(2))
            ->method('getValue')
            ->withConsecutive(
                ['trans_email/ident_general/email', 'store'],
                ['trans_email/ident_general/name', 'store']
            )
            ->willReturnOnConsecutiveCalls(
                'admin@email.com',
                'Teste admin'
            );
        $result = $this->instance->getFromData();
        $this->assertEquals(
            [
                'email' => 'admin@email.com',
                'name' => 'Teste admin'
            ],
            $result
        );
    }

    /**
     * @return void
     */
    public function testShouldReturnCorrectTemplateVarsArray(): void
    {
        $this->customerDataMock
            ->expects($this->exactly(1))
            ->method('getFirstname')
            ->willReturn("TestName");
        $this->customerDataMock
            ->expects($this->exactly(1))
            ->method('getLastname')
            ->willReturn("SomeLastname");
        $this->customerDataMock
            ->expects($this->exactly(1))
            ->method('getEmail')
            ->willReturn("newcustomer@test.com");
        $result = $this->instance->getTemplateVars($this->customerDataMock);
        $this->assertEquals(
            [
                'firstname' => 'TestName',
                'lastname' => 'SomeLastname',
                'email' => 'newcustomer@test.com'
            ],
            $result
        );
    }

    /**
     * @return void
     */
    public function testShouldReturnCorrectToEmailString(): void
    {
        $this->scopeConfigMock
            ->expects($this->exactly(1))
            ->method('getValue')
            ->willReturn("support@test.com");
        $result = $this->instance->getToEmail();
        $this->assertEquals("support@test.com", $result);
    }

    /**
     * @return void
     */
    private function setMocks(): void
    {
        $this->customerDataMock = $this->createMock(CustomerInterface::class);
        $this->storeManagerMock = $this->createMock(StoreManagerInterface::class);
        $this->storeMock = $this->createMock(StoreInterface::class);
        $this->scopeConfigMock = $this->createMock(ScopeConfigInterface::class);
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
                'storeManager' => $this->storeManagerMock,
                'scopeConfig' => $this->scopeConfigMock
            ]
        );
    }
}
