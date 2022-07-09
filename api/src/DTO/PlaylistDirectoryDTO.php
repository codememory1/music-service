<?php

namespace App\DTO;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\PlaylistDirectory;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PlaylistDirectoryDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<PlaylistDirectory>
 *
 * @author  Codememory
 */
class PlaylistDirectoryDTO extends AbstractDTO
{
    protected EntityInterface|string|null $entity = PlaylistDirectory::class;

    #[Assert\NotBlank(message: 'playlistDirectory@titleIsRequired')]
    #[Assert\Length(max: 50, maxMessage: 'playlistDirectory@titleMaxLength')]
    public ?string $title = null;

    protected function wrapper(): void
    {
        $this->addExpectKey('title');
    }
}