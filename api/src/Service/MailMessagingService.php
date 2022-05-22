<?php

namespace App\Service;

use App\Entity\AccountActivationCode;
use App\Entity\User;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class MailMessagingService.
 *
 * @package App\Service
 *
 * @author  Codememory
 */
class MailMessagingService
{
    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;

    /**
     * @var Environment
     */
    private Environment $environment;

    /**
     * @var TranslationService
     */
    private TranslationService $translationService;

    /**
     * @param MailerInterface    $mailer
     * @param Environment        $environment
     * @param TranslationService $translationService
     */
    public function __construct(MailerInterface $mailer, Environment $environment, TranslationService $translationService)
    {
        $this->mailer = $mailer;
        $this->environment = $environment;
        $this->translationService = $translationService;
    }

    /**
     * @param User $registeredUser
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     *
     * @return void
     */
    public function sendAccountActivationCode(AccountActivationCode $accountActivationCode): void
    {
        $email = new Email();

        $email->from('kostynd1@gmail.com');
        $email->to($accountActivationCode->getUser()->getEmail());
        $email->subject($this->translationService->get('registration@registration'));
        $email->html($this->getTemplate('register', ['accountActivationCode' => $accountActivationCode]));

        $this->mailer->send($email);
    }

    /**
     * @param string $name
     * @param array  $params
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     *
     * @return string
     */
    private function getTemplate(string $name, array $params = []): string
    {
        $params['translationService'] = $this->translationService;

        return $this->environment->render(
            sprintf('mail/output/%s.html', $name),
            $params
        );
    }
}