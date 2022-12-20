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
    #[DtoConstraints\ToTypeConstraint]
    #[DtoConstraints\ValidationConstraint([
        new Assert\NotBlank(message: 'playlistDirectory@titleIsRequired'),
        new Assert\Length(max: 50, maxMessage: 'playlistDirectory@titleMaxLength')
    ])]
    public ?string $title = null;
}