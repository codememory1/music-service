<?php

namespace App\Entity;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\EntityInterface;
use App\Repository\MusicExecutorRepository;
use App\Traits\Entity\IdentifierTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class MusicExecutor.
 *
 * @package App\Entity
 *
 * @author  Codememory
 */
#[ORM\Entity(repositoryClass: MusicExecutorRepository::class)]
#[ORM\Table('music_executors')]
#[UniqueEntity(
    ['music', 'artist'],
    'musicExecutor@execurotForMusicExist',
    payload: ApiResponseTypeEnum::CHECK_EXIST
)]
class MusicExecutor implements EntityInterface
{
    use IdentifierTrait;

    /**
     * @var null|Music
     */
    #[ORM\ManyToOne(targetEntity: Music::class, inversedBy: 'musicExecutors')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Music $music = null;

    /**
     * @var null|User
     */
    #[ORM\OneToOne(targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $artist = null;

    /**
     * @return null|Music
     */
    public function getMusic(): ?Music
    {
        return $this->music;
    }

    /**
     * @param null|Music $music
     *
     * @return $this
     */
    public function setMusic(?Music $music): self
    {
        $this->music = $music;

        return $this;
    }

    /**
     * @return null|User
     */
    public function getArtist(): ?User
    {
        return $this->artist;
    }

    /**
     * @param null|User $artist
     *
     * @return $this
     */
    public function setArtist(?User $artist): self
    {
        $this->artist = $artist;

        return $this;
    }
}
