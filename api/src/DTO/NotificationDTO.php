<?php

namespace App\DTO;

use App\DTO\Interceptors\AsArrayInterceptor;
use App\DTO\Interceptors\AsDateTimeInterceptor;
use App\DTO\Interceptors\AsEnumInterceptor;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Notification;
use App\Enum\NotificationTypeEnum;
use App\Enum\UserStatusEnum;
use App\Repository\UserRepository;
use App\Validator\Constraints as AppAssert;
use DateTimeImmutable;
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
    /**
     * @inheritDoc
     */
    protected EntityInterface|string|null $entity = Notification::class;

    #[Assert\NotBlank(message: 'notification@typeIsRequired')]
    public ?NotificationTypeEnum $type = null;

    #[Assert\NotBlank(message: 'notification@toIsRequired')]
    public ?string $toUser = null;
    public ?DateTimeImmutable $departureDate = null;

    #[Assert\NotBlank(message: 'notification@titleIsRequired')]
    #[Assert\Length(max: 50, maxMessage: 'notification@maxLengthTitle')]
    public ?string $title = null;

    #[Assert\NotBlank(message: 'notification@messageIsRequired')]
    #[Assert\Length(max: 255, maxMessage: 'notification@maxLengthMessage')]
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
        $this->addExpectKey('to_user', 'toUser');
        $this->addExpectKey('departure_date', 'departureDate');
        $this->addExpectKey('title');
        $this->addExpectKey('message');
        $this->addExpectKey('action');

        $this->addInterceptor('type', new AsEnumInterceptor(NotificationTypeEnum::class));
        $this->addInterceptor('departureDate', new AsDateTimeInterceptor());
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