<?php

namespace App\DTO;

use App\DTO\Interceptors\AsArrayInterceptor;
use App\DTO\Interceptors\AsEnumInterceptor;
use App\Entity\Notification;
use App\Enum\NotificationTypeEnum;
use App\Enum\UserStatusEnum;
use App\Repository\UserRepository;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class NotificationDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<Notification>
 *
 * @author  Codememory
 */
class NotificationDTO extends AbstractDTO
{
    #[Assert\NotBlank(message: 'notification@typeIsRequired')]
    public ?NotificationTypeEnum $type = null;

    #[Assert\NotBlank(message: 'notification@toIsRequired')]
    public ?string $to = null;

    #[Assert\NotBlank(message: 'notification@titleIsRequired')]
    public ?string $title = null;

    #[Assert\NotBlank(message: 'notification@messageIsRequired')]
    public ?string $message = null;

    #[AppAssert\JsonSchema('notification_actions', message: 'notification@invalidAction')]
    public ?array $action = [];

    #[Required]
    public ?UserRepository $userRepository = null;

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
        $this->addExpectKey('type');
        $this->addExpectKey('to');
        $this->addExpectKey('title');
        $this->addExpectKey('message');
        $this->addExpectKey('action');

        $this->addInterceptor('type', new AsEnumInterceptor(NotificationTypeEnum::class));
        $this->addInterceptor('to', function(string $key, mixed $value) {
            if ('all' !== $value) {
                return $this->userRepository->findOneBy([
                    'status' => UserStatusEnum::ACTIVE->name,
                    'email' => $value
                ])?->getEmail();
            }

            return 'all';
        });
        $this->addInterceptor('action', new AsArrayInterceptor());
    }
}