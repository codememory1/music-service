<?php

namespace App\Service;

use App\Entity\AccountActivationCode;
use App\Entity\PasswordReset;
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
    private MailerInterface $mailer;
    private Environment $environment;
    private TranslationService $translationService;

    public function __construct(MailerInterface $mailer, Environment $environment, TranslationService $translationService)
    {
        $this->mailer = $mailer;
        $this->environment = $environment;
        $this->translationService = $translationService;
    }

    /**
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
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
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     */
    public function sendRequestRestorationPassword(PasswordReset $passwordReset): void
    {
        $email = new Email();

        $email->from('kostynd1@gmail.com');
        $email->to($passwordReset->getUser()->getEmail());
        $email->subject($this->translationService->get('passwordReset@requestRestoration'));
        $email->html($this->getTemplate('request-restoration-password', ['passwordReset' => $passwordReset]));

        $this->mailer->send($email);
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
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