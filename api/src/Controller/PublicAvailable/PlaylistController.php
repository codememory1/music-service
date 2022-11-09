<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\PlaylistTransformer;
use App\Entity\MultimediaPlaylist;
use App\Entity\Playlist;
use App\Entity\PlaylistDirectory;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\PlaylistRepository;
use App\ResponseData\General\Playlist\PlaylistResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\Playlist\CreatePlaylist;
use App\Service\Playlist\DeletePlaylist;
use App\Service\Playlist\MoveMultimediaToDirectory;
use App\Service\Playlist\UpdatePlaylist;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/media-library')]
#[Authorization]
class PlaylistController extends AbstractRestController
{
    #[Route('/playlist/all', methods: 'GET')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_PLAYLISTS)]
    public function all(PlaylistResponseData $responseData, PlaylistRepository $playlistRepository): JsonResponse
    {
        $responseData->setEntities($playlistRepository->findByUser($this->getAuthorizedUser()));

        return $this->responseData($responseData);
    }

    #[Route('/playlist/{playlist_id}/read', methods: 'GET')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_PLAYLISTS)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistResponseData $responseData
    ): JsonResponse {
        $this->throwIfPlaylistNotBelongsAuthorizedUser($playlist);

        $responseData->setEntities($playlist);

        return $this->responseData($responseData);
    }

    #[Route('/playlist/create', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CREATE_PLAYLIST)]
    public function create(PlaylistTransformer $transformer, CreatePlaylist $createPlaylist, PlaylistResponseData $responseData): JsonResponse
    {
        $responseData->setEntities($createPlaylist->create(
            $transformer->transformFromRequest(),
            $this->getAuthorizedUser()
        ));

        return $this->responseData($responseData, PlatformCodeEnum::CREATED);
    }

    #[Route('/playlist/{playlist_id<\d+>}/edit', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_PLAYLIST)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistTransformer $transformer,
        UpdatePlaylist $updatePlaylist,
        PlaylistResponseData $responseData
    ): JsonResponse {
        $this->throwIfPlaylistNotBelongsAuthorizedUser($playlist);

        $responseData->setEntities($updatePlaylist->update($transformer->transformFromRequest($playlist)));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/playlist/{playlist_id<\d+>}/delete', methods: 'DELETE')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_PLAYLIST)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        DeletePlaylist $deletePlaylist,
        PlaylistResponseData $responseData
    ): JsonResponse {
        $this->throwIfPlaylistNotBelongsAuthorizedUser($playlist);

        $responseData->setEntities($deletePlaylist->delete($playlist));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }

    #[Route('/playlist/multimedia/{multimediaPlaylist_id<\d+>}/move/directory/{playlistDirectory_id<\d+>}', methods: 'PUT')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST)]
    public function moveMultimediaToDirectory(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaPlaylist $multimediaPlaylist,
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        MoveMultimediaToDirectory $moveMultimediaToDirectory,
        PlaylistResponseData $responseData
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isMultimediaPlaylistBelongs($multimediaPlaylist)) {
            throw EntityNotFoundException::multimedia();
        }

        if (false === $this->getAuthorizedUser()->isPlaylistDirectoryBelongs($playlistDirectory)) {
            throw EntityNotFoundException::playlistDirectory();
        }

        $responseData->setEntities($moveMultimediaToDirectory->move($multimediaPlaylist, $playlistDirectory));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    private function throwIfPlaylistNotBelongsAuthorizedUser(Playlist $playlist): void
    {
        if (false === $this->getAuthorizedUser()->isPlaylistBelongs($playlist)) {
            throw EntityNotFoundException::multimedia();
        }
    }
}