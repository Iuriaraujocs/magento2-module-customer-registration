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

namespace Iuriaraujocs\Customer\Test\Unit\Model\Config;

use PHPUnit\Framework\MockObject\MockObject;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Iuriaraujocs\Customer\Model\Config\Data as Model;

class DataTest extends TestCase
{
    /**
     * @var MockObject | ScopeConfigInterface
     */
    private $scopeConfig;

    /** @var Model */
    private $instance;

    /**
     * Setup method
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->getMocks();
        $this->setInstance();
    }

    /**
     * @dataProvider dataProvider
     * @return void
     */
    public function testIsModuleActiveShouldReturnTrue($value): void
    {
        $this->scopeConfig->expects($this->once())
            ->method('getValue')
            ->willReturn($value);

        $this->assertIsBool($this->instance->isModuleEnable());
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            'scenario 1 - config enable' => [
                'value' => 1
            ],
            'scenario 2 - config disable' => [
                'value' => 0
            ],
            'scenario 3 - null config value' => [
                'value' => null
            ]
        ];
    }

    /**
     * @return void
     */
    private function getMocks(): void
    {
        $this->scopeConfig = $this->createMock(ScopeConfigInterface::class);
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
                'scopeConfig' => $this->scopeConfig
            ]
        );
    }
}
