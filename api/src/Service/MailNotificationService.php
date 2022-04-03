<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserActivationToken;
use App\Rest\Translator;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class MailNotificationService.
 *
 * @package App\Service
 *
 * @author  Codememory
 */
class MailNotificationService
{
    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;

    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * @var Translator
     */
    private Translator $translator;

    /**
     * @param MailerInterface $mailer
     * @param Environment     $twig
     * @param Translator      $translator
     */
    public function __construct(MailerInterface $mailer, Environment $twig, Translator $translator)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->translator = $translator;
    }

    /**
     * @param User                $user
     * @param UserActivationToken $userActivationToken
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     *
     * @return void
     */
    public function registerNotification(User $user, UserActivationToken $userActivationToken): void
    {
        $email = new Email();
        $email
            ->from('kostynd1@gmail.com')
            ->to($user->getEmail())
            ->subject('Подтверждение регистрации')
            ->html($this->render('confirm-registration', [
                'token' => $userActivationToken->getToken()
            ]));

        $this->mailer->send($email);
    }

    /**
     * @param string $to
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     *
     * @return void
     */
    public function passwordRecoveryRequest(string $to): void
    {
        $email = new Email();
        $email
            ->from('kostynd1@gmail.com')
            ->to($to)
            ->subject('Запрос на восстановление пароля')
            ->html($this->render('password-recovery-request'));

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
    private function render(string $name, array $params = []): string
    {
        return $this->twig->render(
            sprintf('mail/output/%s.html', $name),
            $params
        );
    }
}