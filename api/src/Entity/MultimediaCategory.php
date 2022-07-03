<?php

namespace App\Entity;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\Traits\IdentifierTrait;
use App\Entity\Traits\TimestampTrait;
use App\Repository\MultimediaCategoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class MultimediaCategory.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MultimediaCategoryRepository::class)]
#[ORM\Table('multimedia_categories')]
#[ORM\HasLifecycleCallbacks]
class MultimediaCategory implements EntityInterface
{
    use IdentifierTrait;

    use TimestampTrait;

    #[ORM\Column(type: Types::STRING, length: 255, options: [
        'comment' => 'Category name as a translation key'
    ])]
    private ?string $titleTranslationKey = null;

    public function getTitle(): ?string
    {
        return $this->titleTranslationKey;
    }

    public function setTitle(string $titleTranslationKey): self
    {
        $this->titleTranslationKey = $titleTranslationKey;

        return $this;
    }
}
