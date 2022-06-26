<?php

namespace App\Repository;

use App\Entity\Multimedia;
use App\Entity\MultimediaRating;
use App\Entity\User;

/**
 * Class MultimediaRatingRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<MultimediaRating>
 *
 * @author  Codememory
 */
class MultimediaRatingRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = MultimediaRating::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'mr';

    /**
     * @param Multimedia $multimedia
     * @param User       $fromUser
     *
     * @return null|MultimediaRating
     */
    public function getRating(Multimedia $multimedia, User $fromUser): ?MultimediaRating
    {
        return $this->findOneBy([
            'multimedia' => $multimedia,
            'user' => $fromUser
        ]);
    }
}
