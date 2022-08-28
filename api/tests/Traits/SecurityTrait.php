<?php

namespace App\Tests\Traits;

use App\Entity\Subscription;
use App\Entity\User;
use App\Enum\SubscriptionEnum;

trait SecurityTrait
{
    private function register(?string $email = null): string
    {
        $email ??= 'test-user@gmail.com';

        $this->createRequest('/api/ru/public/user/register', 'POST', [
            'pseudonym' => 'Codememory',
            'email' => $email,
            'password' => 'test_user_password',
            'password_confirm' => 'test_user_password'
        ]);

        return $email;
    }

    private function createArtistAccount(): User
    {
        $userRepository = $this->em()->getRepository(User::class);
        $subscriptionRepository = $this->em()->getRepository(Subscription::class);
        $emailRegisteredUser = $this->register('test-artist@gmail.com');

        $this->createRequest('/api/ru/public/user/account-activation', 'POST', [
            'email' => $emailRegisteredUser,
            'code' => $userRepository->findByEmail($emailRegisteredUser)->getAccountActivationCode()->last()->getCode()
        ]);

        $this->em()->clear();

        $registeredUser = $userRepository->findByEmail($emailRegisteredUser);

        $registeredUser->setSubscription($subscriptionRepository->findByName(SubscriptionEnum::ARTIST));

        $this->em()->flush();

        return $registeredUser;
    }
}