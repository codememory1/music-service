<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\PlaylistDirectory;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PlaylistDirectoryDto.
 *
 * @package App\Dto\Transfer
 * @template-extends AbstractDataTransfer<PlaylistDirectory>
 *
 * @author  Codememory
 */
final class PlaylistDirectoryDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'playlistDirectory@titleIsRequired')]
    #[Assert\Length(max: 50, maxMessage: 'playlistDirectory@titleMaxLength')]
    #[DtoConstraints\ToTypeConstraint]
    public ?string $title = null;
}