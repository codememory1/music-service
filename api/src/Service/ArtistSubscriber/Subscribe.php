<?php

namespace App\Service\ArtistSubscriber;

use App\Entity\ArtistSubscriber;
use App\Entity\User;
use App\Enum\ArtistSubscriberStatusEnum;
use App\Repository\UserRepository;
use App\Rest\ApiService;
use App\Rest\Http\Response;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class Subscribe.
 *
 * @package App\Service\ArtistSubscriber
 *
 * @author  Codememory
 */
class Subscribe extends ApiService
{
    /**
     * @var UserRepository|null
     */
    private ?UserRepository $userRepository = null;

    /**
     * @var Validation|null
     */
    private ?Validation $validation = null;

    /**
     * @param UserRepository $userRepository
     *
     * @return $this
     */
    #[Required]
    public function setUserRepository(UserRepository $userRepository): self
    {
        $this->userRepository = $userRepository;

        return $this;
    }

    /**
     * @param Validation $validation
     *
     * @return $this
     */
    #[Required]
    public function setValidation(Validation $validation): self
    {
        $this->validation = $validation;

        return $this;
    }

    /**
     * @param User $artist
     * @param User $subscriber
     *
     * @return Response|User
     */
    public function subscribe(User $artist, User $subscriber): Response|User
    {
        $artistSubscriber = $this->collectedEntity($artist, $subscriber);

        if(true !== $resultValidation = $this->validation->validate($artistSubscriber)) {
            return $resultValidation;
        }

        $this->em->persist($artistSubscriber);
        $this->em->flush();

        return $artist;
    }

    /**
     * @param int $artistId
     *
     * @return Response|User
     */
    public function existArtist(int $artistId): Response|User
    {
        $finedArtist = $this->userRepository->getArtist($artistId);

        if(null === $finedArtist) {
            return $this->responseCollection->notExist('artist@notExist')->getResponse();
        }

        return $finedArtist;
    }

    /**
     * @return Response
     */
    public function successSubscribeResponse(): Response
    {
        return $this->responseCollection->successSubscribe('artist@successSubscribe')->getResponse();
    }

    /**
     * @param User $artist
     * @param User $subscriber
     *
     * @return ArtistSubscriber
     */
    private function collectedEntity(User $artist, User $subscriber): ArtistSubscriber
    {
        $artistSubscriber = new ArtistSubscriber();

        $artistSubscriber
            ->setArtist($artist)
            ->setSubscriber($subscriber)
            ->setStatus(ArtistSubscriberStatusEnum::SUBSCRIBED);

        return $artistSubscriber;
    }
}