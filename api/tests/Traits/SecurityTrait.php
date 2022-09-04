<?php

namespace App\Tests\Traits;

use App\Entity\Subscription;
use App\Entity\User;
use App\Enum\SubscriptionEnum;
use Symfony\Component\HttpFoundation\Request;

trait SecurityTrait
{
    private function register(?string $email = null): string
    {
        $email ??= 'test-user@gmail.com';

        $this->browser->createRequest('/api/ru/public/user/register');
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->addRequestData('pseudonym', 'Codememory');
        $this->browser->addRequestData('email', $email);
        $this->browser->addRequestData('password', 'test_user_password');
        $this->browser->addRequestData('password_confirm', 'test_user_password');
        $this->browser->sendRequest();

        return $email;
    }

    private function createUser(?string $email = null): string
    {
        $email = $this->register($email);

        $userRepository = $this->em()->getRepository(User::class);
        $accountActivationCode = $userRepository->findByEmail($email)->getLastAccountActivationCode();

        $this->browser->createRequest('/api/ru/public/user/account-activation');
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->addRequestData('email', $email);
        $this->browser->addRequestData('code', $accountActivationCode);
        $this->browser->sendRequest();

        return $email;
    }

    private function createArtistAccount(?string $email = null): User
    {
        $email = $this->register($email ?: 'test-artist@gmail.com');

        $userRepository = $this->em()->getRepository(User::class);
        $subscriptionRepository = $this->em()->getRepository(Subscription::class);
        $accountActivationCode = $userRepository->findByEmail($email)->getLastAccountActivationCode();

        $this->browser->createRequest('/api/ru/public/user/account-activation');
        $this->browser->setMethod(Request::METHOD_POST);
        $this->browser->addRequestData('email', $email);
        $this->browser->addRequestData('code', $accountActivationCode);
        $this->browser->sendRequest();

        $this->em()->clear();

        $registeredUser = $userRepository->findByEmail($email);

        $registeredUser->setSubscription($subscriptionRepository->findByName(SubscriptionEnum::ARTIST));

        $this->em()->flush();

        return $registeredUser;
    }
}