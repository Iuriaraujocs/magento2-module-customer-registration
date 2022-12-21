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

namespace Iuriaraujocs\Customer\Test\Unit\Model\Mail\Sender;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Iuriaraujocs\Customer\Model\Mail\Sender\EmailSender as Model;
use Magento\Customer\Api\Data\CustomerInterface;
use Iuriaraujocs\Customer\Model\Mail\Sender\Data\EmailData;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Mail\TransportInterface;
use Magento\Framework\Translate\Inline\StateInterface;


class EmailSenderTest extends TestCase
{

    /**
     * @var CustomerInterface|MockObject
     */
    private $customerDataMock;

    /**
     * @var EmailData|MockObject
     */
    private $emailDataMock;

    /**
     * @var TransportBuilder|MockObject
     */
    private $transportBuilderMock;

    /**
     * @var TransportInterface|MockObject\
     */
    private $transportInterfaceMock;

    /**
     * @var StateInterface|MockObject
     */
    private $inlineTranslationMock;

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
    public function testShouldPassThroughtWithoutErrors()
    {
        $this->inlineTranslationMock
            ->expects($this->exactly(1))
            ->method('suspend');
        $this->transportBuilderMock
            ->expects($this->exactly(1))
            ->method('setTemplateIdentifier')
            ->willReturnSelf();
        $this->emailDataMock
            ->expects($this->exactly(1))
            ->method('getTemplateOptions')
            ->willReturn([]);
        $this->transportBuilderMock
            ->expects($this->exactly(1))
            ->method('setTemplateOptions')
            ->willReturnSelf();
        $this->emailDataMock
            ->expects($this->exactly(1))
            ->method('getTemplateVars')
            ->willReturn([]);
        $this->transportBuilderMock
            ->expects($this->exactly(1))
            ->method('setTemplateVars')
            ->willReturnSelf();
        $this->emailDataMock
            ->expects($this->exactly(1))
            ->method('getFromData')
            ->willReturn([]);
        $this->transportBuilderMock
            ->expects($this->exactly(1))
            ->method('setFrom')
            ->willReturnSelf();
        $this->emailDataMock
            ->expects($this->exactly(1))
            ->method('getToEmail')
            ->willReturn('');
        $this->transportBuilderMock
            ->expects($this->exactly(1))
            ->method('addTo')
            ->willReturnSelf();
        $this->transportBuilderMock
            ->expects($this->exactly(1))
            ->method('getTransport')
            ->willReturn($this->transportInterfaceMock);
        $this->transportInterfaceMock
            ->expects($this->exactly(1))
            ->method('sendMessage')
            ->willReturnSelf();
        $this->inlineTranslationMock
            ->expects($this->exactly(1))
            ->method('resume');
        $this->instance->sendEmail($this->customerDataMock);
    }

    /**
     * @return void
     */
    private function setMocks()
    {
        $this->customerDataMock = $this->createMock(CustomerInterface::class);
        $this->emailDataMock = $this->createMock(EmailData::class);
        $this->transportBuilderMock = $this->createMock(TransportBuilder::class);
        $this->transportInterfaceMock = $this->getMockBuilder(TransportInterface::class)
            ->onlyMethods(['sendMessage'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $this->inlineTranslationMock = $this->createMock(StateInterface::class);
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
                'emailData' => $this->emailDataMock,
                'transportBuilder' => $this->transportBuilderMock,
                'state' => $this->inlineTranslationMock
            ]
        );
    }
}
