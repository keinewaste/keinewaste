<?php


namespace Instela\Tests\Services;

use Aws\Ses\SesClient;
use KeineWaste\Services\MailingService;
use KeineWaste\Dto\User;

class MailingServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testSendMail()
    {
        $user = new User(new \DateTime(), "cagatay", "fonturus@gmail.com");
        $user->setEmail("fonturus@gmail.com");

        /** @var SesClient|\PHPUnit_Framework_MockObject_MockObject $sesClient */
        $sesClient = $this->getMockBuilder(SesClient::class)->disableOriginalConstructor()->getMock();
        $sesClient->expects($this->any())
            ->method('sendEmail')
            ->willReturn(true);

        $service = new MailingService($sesClient, 'instela <info@instela.com>');
        $this->assertTrue($service->sendNotificationmessage($user, 'test', 'test mail'));
    }

}