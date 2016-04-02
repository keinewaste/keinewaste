<?php


namespace Instela\Tests\Services;

use Aws\Ses\SesClient;
use KeineWaste\Services\MailingService;
use KeineWaste\Dto\User;

class MailingServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testSendMail()
    {
        $user = new User(
            'Greifswalder Str 212',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent a elit eget augue rhoncus dapibus vitae sed massa. Nunc eget convallis leo. Sed vel varius odio. Duis vitae sem ligula. Nullam fermentum dapibus lacus, a efficitur turpis aliquet et. In congue nisi ex, ut mollis risus imperdiet dapibus. Ut scelerisque quis arcu non bibendum. Nullam ultricies enim eget lacus suscipit, ut mollis felis viverra. Mauris sed lorem maximus, porttitor dui ac, tempus justo. Phasellus vulputate ipsum a tellus porta accumsan. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse nec ex consectetur, malesuada ipsum at, pharetra diam. Proin euismod augue ut massa finibus, non congue odio gravida. Nullam porta leo ligula, non scelerisque nisi laoreet sed. Ut sit amet sapien et tellus sollicitudin sodales a at ante.',
            'FeedingFeeding',
            'no@email.com',
            'Mark Sugarmountain',
            'food_bank',
            'http://tasteforlife.com/sites/default/files/styles/desktop/public/field/image/HungryQuiz.jpg?itok=C-4TGxzh',
            [],
            new \DateTime('2016-04-02 12:58:29')
        );
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