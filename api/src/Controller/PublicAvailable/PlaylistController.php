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
use App\Exception\Http\LimitException;
use App\Repository\PlaylistRepository;
use App\ResponseData\General\Playlist\PlaylistResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\Subscription\Permission\AllowedSubscriptionPermission;
use App\UseCase\Playlist\CreatePlaylist;
use App\UseCase\Playlist\DeletePlaylist;
use App\UseCase\Playlist\Multimedia\MoveMultimediaPlaylistToDirectory;
use App\UseCase\Playlist\UpdatePlaylist;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/media-library')]
#[Authorization]
class PlaylistController extends AbstractRestController
{
    #[Route('/playlist/all', methods: Request::METHOD_GET)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_PLAYLISTS)]
    public function all(PlaylistResponseData $responseData, PlaylistRepository $playlistRepository): JsonResponse
    {
        return $this->responseData($responseData, $playlistRepository->findByUser($this->getAuthorizedUser()));
    }

    #[Route('/playlist/{playlist_id}/read', methods: Request::METHOD_GET)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHOW_MY_PLAYLISTS)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistResponseData $responseData
    ): JsonResponse {
        $this->throwIfPlaylistNotBelongsAuthorizedUser($playlist);

        return $this->responseData($responseData, $playlist);
    }

    #[Route('/playlist/create', methods: Request::METHOD_POST)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CREATE_PLAYLIST)]
    public function create(
        PlaylistTransformer $transformer,
        CreatePlaylist $createPlaylist,
        AllowedSubscriptionPermission $allowedSubscriptionPermission,
        PlaylistResponseData $responseData
    ): JsonResponse {
        if ($allowedSubscriptionPermission->isMaxPlaylists($this->getAuthorizedUser())) {
            throw LimitException::playlistLimitExceeded();
        }

        return $this->responseData(
            $responseData,
            $createPlaylist->process($transformer->transformFromRequest(), $this->getAuthorizedUser()),
            PlatformCodeEnum::CREATED
        );
    }

    #[Route('/playlist/{playlist_id<\d+>}/edit', methods: Request::METHOD_POST)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_PLAYLIST)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistTransformer $transformer,
        UpdatePlaylist $updatePlaylist,
        PlaylistResponseData $responseData
    ): JsonResponse {
        $this->throwIfPlaylistNotBelongsAuthorizedUser($playlist);

        return $this->responseData(
            $responseData,
            $updatePlaylist->process($transformer->transformFromRequest($playlist)),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/playlist/{playlist_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_PLAYLIST)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        DeletePlaylist $deletePlaylist,
        PlaylistResponseData $responseData
    ): JsonResponse {
        $this->throwIfPlaylistNotBelongsAuthorizedUser($playlist);

        return $this->responseData($responseData, $deletePlaylist->process($playlist), PlatformCodeEnum::DELETED);
    }

    #[Route('/playlist/multimedia/{multimediaPlaylist_id<\d+>}/move/directory/{playlistDirectory_id<\d+>}', methods: Request::METHOD_PUT)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST)]
    public function moveMultimediaToDirectory(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaPlaylist $multimediaPlaylist,
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        MoveMultimediaPlaylistToDirectory $moveMultimediaPlaylistToDirectory,
        PlaylistResponseData $responseData
    ): JsonResponse {
        if (!$this->getAuthorizedUser()->isMultimediaPlaylistBelongs($multimediaPlaylist)) {
            throw EntityNotFoundException::multimedia();
        }

        if (!$this->getAuthorizedUser()->isPlaylistDirectoryBelongs($playlistDirectory)) {
            throw EntityNotFoundException::playlistDirectory();
        }

        return $this->responseData(
            $responseData,
            $moveMultimediaPlaylistToDirectory->process($multimediaPlaylist, $playlistDirectory),
            PlatformCodeEnum::UPDATED
        );
    }

    private function throwIfPlaylistNotBelongsAuthorizedUser(Playlist $playlist): void
    {
        if (!$this->getAuthorizedUser()->isPlaylistBelongs($playlist)) {
            throw EntityNotFoundException::multimedia();
        }
    }
}