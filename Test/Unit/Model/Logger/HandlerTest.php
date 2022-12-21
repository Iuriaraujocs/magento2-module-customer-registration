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

namespace Iuriaraujocs\Customer\Test\Unit\Model\Logger;

use PHPUnit\Framework\MockObject\MockObject;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Iuriaraujocs\Customer\Model\Logger\Handler as Model;

class HandlerTest extends TestCase
{

    /** @var Model */
    private $instance;

    /**
     * Setup method
     *
     * @return void
     */
    protected function setUp(): void
    {
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
    private function setInstance(): void
    {
        $objectManager = new ObjectManager($this);
        $this->instance = $objectManager->getObject(
            Model::class
        );
    }
}
