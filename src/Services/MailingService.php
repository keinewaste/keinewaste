<?php


namespace KeineWaste\Services;

use Aws\Ses\SesClient;
use Psr\Log\LoggerAwareTrait;
use KeineWaste\Dto\User;

class MailingService
{
    use LoggerAwareTrait;

    /**
     * @var SesClient $sesClient
     */
    protected $sesClient;

    /**
     * @var string $from
     */
    protected $from;


    public function __construct(SesClient $sesClient, $from)
    {
        $this->sesClient = $sesClient;
        $this->from      = $from;
    }

    public function sendNotificationmessage(User $user, $subject, $body)
    {
        // @codeCoverageIgnoreStart
        if ($this->logger) {
            $this->logger->debug("Sending e-mail notification to " . $user->getEmail());
        }
        // @codeCoverageIgnoreEnd


        //TODO Add users' realname to to Realname <email@address.com>
        return $this->sendHtmlMail($user->getEmail(), $subject, $body);
    }

    /**
     * @param string $to      E-Mail to send mail
     * @param string $subject Subject
     * @param string $body    Body
     *
     * @return bool
     */
    public function sendHtmlMail($to, $subject, $body)
    {

        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../templates');
        $twig   = new \Twig_Environment($loader);

        $html = $twig->render(
            'mail.html', [
                'body' => $body,
            ]
        );

        // @codeCoverageIgnoreStart
        if ($this->logger) {
            $this->logger->debug("Sending mail to " . $to);
        }
        // @codeCoverageIgnoreEnd

        try {
            $this->sesClient->sendEmail(
                [
                    'Source'      => $this->from,
                    'Destination' => [
                        'ToAddresses' => [
                            $to
                        ],
                    ],
                    'Message'     => [
                        'Subject' => [
                            'Data' => $subject,
                        ],
                        'Body'    => [
                            'Text' => [
                                'Data' => strip_tags($body),
                            ],
                            'Html' => [
                                'Data' => $html,
                            ],
                        ],
                    ]
                ]
            );

            // @codeCoverageIgnoreStart
            if ($this->logger) {
                $this->logger->debug("Message sent to " . $to);
            }
            // @codeCoverageIgnoreEnd

            return true;
        } catch (\Exception $e) {
            // @codeCoverageIgnoreStart
            if (null !== $this->logger) {
                $this->logger->error("Error at sending e-mail to  " . $to . ": " . $e->getMessage());
            }
            // @codeCoverageIgnoreEnd
            return false;
        }

    }
}