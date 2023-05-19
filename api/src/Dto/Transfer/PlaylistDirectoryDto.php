<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Entity\PlaylistDirectory;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @template-extends DataTransfer<PlaylistDirectory>
 */
final class PlaylistDirectoryDto extends DataTransfer
{
    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'playlistDirectory@titleIsRequired'),
        new Assert\Length(max: 50, maxMessage: 'playlistDirectory@titleMaxLength')
    ])]
    public ?string $title = null;
}