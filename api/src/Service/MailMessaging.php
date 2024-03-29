<?php

namespace App\Service;

use App\Entity\AccountActivationCode;
use App\Entity\PasswordReset;
use App\Entity\User;
use App\Entity\UserSession;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class MailMessaging
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly Environment $environment,
        private readonly Translation $translation
    ) {
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
        $email->subject('Регистрация'); // TODO: translation - registration@registration
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
        $email->subject('Сброс пароля'); // TODO: translation - passwordReset@requestRestoration
        $email->html($this->getTemplate('request-restoration-password', ['passwordReset' => $passwordReset]));

        $this->mailer->send($email);
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     */
    public function sendAuthFromUnknownDevice(User $user, UserSession $userSession): void
    {
        $email = new Email();

        $email->from('kostynd1@gmail.com');
        $email->to($user->getEmail());
        $email->subject($this->translation->get('common@authFromUnknownDevice'));
        $email->html($this->getTemplate('auth-from-unknown-device', [
            'user' => $user,
            'userSession' => $userSession,
        ]));

        $this->mailer->send($email);
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    private function getTemplate(string $name, array $params = []): string
    {
        $params['translation'] = $this->translation;

        return $this->environment->render(
            sprintf('mail/output/%s.html', $name),
            $params
        );
    }
}