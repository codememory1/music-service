<?php

namespace App\DTO;

use App\DTO\Interceptors\AsArrayInterceptor;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Playlist;
use App\Enum\PlaylistStatusEnum;
use App\Enum\RequestTypeEnum;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PlaylistDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<Playlist>
 *
 * @author  Codememory
 */
class PlaylistDTO extends AbstractDTO
{
    protected EntityInterface|string|null $entity = Playlist::class;

    #[Assert\NotBlank(message: 'playlist@titleIsRequired')]
    #[Assert\Length(max: 50, maxMessage: 'playlist@titleMaxLength')]
    public ?string $title = null;

    #[Assert\NotBlank(message: 'playlist@imageIsRequired')]
    #[Assert\File(
        maxSize: '5M',
        mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
        maxSizeMessage: 'multimedia@maxSizePreview',
        mimeTypesMessage: 'multimedia@uploadFileIsNotPreview'
    )]
    public ?UploadedFile $image = null;
    public array $multimedia = [];

    #[AppAssert\Condition('callbackStatus', [
        new AppAssert\Enum(PlaylistStatusEnum::class, message: 'common@invalidStatus')
    ])]
    public ?PlaylistStatusEnum $status = null;

    protected function wrapper(): void
    {
        $this->addExpectKey('title');
        $this->addExpectKey('multimedia');
        $this->addExpectKey('status');

        $this->callSetterToEntityWhenRequest('^admin$', 'status');

        $this->image = $this->request?->request->files->get('image');

        $this->addInterceptor('multimedia', new AsArrayInterceptor());
    }

    final public function callbackStatus(): bool
    {
        return $this->requestType === RequestTypeEnum::ADMIN->value;
    }
}