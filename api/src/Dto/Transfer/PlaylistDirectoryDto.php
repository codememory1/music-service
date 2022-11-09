<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\PlaylistDirectory;
use App\Infrastructure\Dto\AbstractDataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends AbstractDataTransfer<PlaylistDirectory>
 */
final class PlaylistDirectoryDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'playlistDirectory@titleIsRequired')]
    #[Assert\Length(max: 50, maxMessage: 'playlistDirectory@titleMaxLength')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $title = null;
}