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

namespace Iuriaraujocs\Customer\Test\Unit\Model\AccountManagement\AttributeRules;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iuriaraujocs\Customer\Model\AccountManagement\Registration\AttributeRules\FirstnameWithoutWhiteSpacesRule as Model;
use Magento\Customer\Api\Data\CustomerInterface;
use Psr\Log\LoggerInterface;

class FirstnameWithoutWhiteSpacesRuleTest extends TestCase
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
     * @dataProvider dataProvider
     * @return void
     */
    public function testFirstnameShouldResultWithoutAnyWhiteSpaces($firstname)
    {
        $this->customerDataMock
            ->expects($this->exactly(1))
            ->method('getFirstname')
            ->willReturn($firstname);
        $this->customerDataMock
            ->expects($this->exactly(1))
            ->method('setFirstname')
            ->willReturnCallback(function ($firstnameFormatted) {
                $this->assertFirstnameIsWithoutWhiteSpaces($firstnameFormatted);
                return $this;
            });
        $this->instance->execute($this->customerDataMock);
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            'scenario 1' => [
                'firstname' => 'Iuri Araujo Test'
            ],
            'scenario 2' => [
                'firstname' => "Iuri\t        Araujo   Test"
            ],
            'scenario 3' => [
                'firstname' => "    Iuri Araujo\nTest"
            ],
            'scenario 4' => [
                'firstname' => '              Iuri               Araujo     Test'
            ],
            'scenario 5' => [
                'firstname' => "Iuri A r a u j o          T \te s t"
            ],
            'scenario 6' => [
                'firstname' => 'I u r i A r a u j o T e s t'
            ],
            'scenario 7' => [
                'firstname' => "\tI \tu r i A \nr a u j \no T e s t"
            ]
        ];
    }

    /**
     * @param $string
     * @return void
     */
    private function assertFirstnameIsWithoutWhiteSpaces($string): void
    {
        $output = 'IuriAraujoTest';
        $this->assertEquals($output , $string);
    }

    /**
     * @return void
     */
    private function setMocks()
    {
        $this->customerDataMock = $this->createMock(CustomerInterface::class);
    }

    /**
     * @return void
     */
    private function setInstance()
    {
        $objectManager = new ObjectManager($this);
        $this->instance = $objectManager->getObject(
            Model::class
        );
    }
}
