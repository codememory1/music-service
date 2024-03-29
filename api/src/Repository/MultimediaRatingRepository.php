<?php

namespace App\Repository;

use App\Entity\Multimedia;
use App\Entity\MultimediaRating;
use App\Entity\User;

/**
 * @template-extends AbstractRepository<MultimediaRating>
 */
final class MultimediaRatingRepository extends AbstractRepository
{
    protected ?string $entity = MultimediaRating::class;
    protected ?string $alias = 'mr';

    public function getRating(Multimedia $multimedia, User $fromUser): ?MultimediaRating
    {
        return $this->findOneBy([
            'multimedia' => $multimedia,
            'user' => $fromUser
        ]);
    }
}
