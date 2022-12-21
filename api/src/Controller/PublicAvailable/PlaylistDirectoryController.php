<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\PlaylistDirectoryTransformer;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaPlaylistDirectory;
use App\Entity\Playlist;
use App\Entity\PlaylistDirectory;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Exception\Http\LimitException;
use App\ResponseData\General\Playlist\Directory\PlaylistDirectoryMultimediaResponseData;
use App\ResponseData\General\Playlist\PlaylistMultimediaResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\Service\Subscription\Permission\AllowedSubscriptionPermission;
use App\UseCase\MediaLibrary\Multimedia\AddMultimediaMediaLibraryToPlaylistDirectory;
use App\UseCase\Playlist\Directory\CreatePlaylistDirectory;
use App\UseCase\Playlist\Directory\DeletePlaylistDirectory;
use App\UseCase\Playlist\Directory\Multimedia\DeleteMultimediaFromPlaylistDirectory;
use App\UseCase\Playlist\Directory\UpdatePlaylistDirectory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/media-library/playlist')]
#[Authorization]
class PlaylistDirectoryController extends AbstractRestController
{
    #[Route('/{playlist_id<\d+>}/directory/create', methods: Request::METHOD_POST)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CREATE_DIRECTORY_TO_PLAYLIST)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistDirectoryTransformer $transformer,
        CreatePlaylistDirectory $createPlaylistDirectory,
        AllowedSubscriptionPermission $allowedSubscriptionPermission,
        PlaylistDirectoryMultimediaResponseData $responseData
    ): HttpResponseCollectorInterface {
        if (!$this->getAuthorizedUser()->isPlaylistBelongs($playlist)) {
            throw EntityNotFoundException::playlist();
        }

        if ($allowedSubscriptionPermission->isMaxDirectoriesInPlaylists($playlist)) {
            throw LimitException::playlistDirectoryLimitExceeded();
        }

        return $this->responseData(
            $responseData,
            $createPlaylistDirectory->process($transformer->transformFromRequest(), $playlist),
            PlatformCodeEnum::CREATED
        );
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/edit', methods: Request::METHOD_PUT)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        PlaylistDirectoryTransformer $transformer,
        UpdatePlaylistDirectory $updatePlaylistDirectory,
        PlaylistDirectoryMultimediaResponseData $responseData
    ): HttpResponseCollectorInterface {
        $this->throwIfPlaylistDirectoryNotBelongsAuthorizedUser($playlistDirectory);

        return $this->responseData(
            $responseData,
            $updatePlaylistDirectory->process($transformer->transformFromRequest($playlistDirectory)),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_DIRECTORY_TO_PLAYLIST)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        DeletePlaylistDirectory $deletePlaylistDirectory,
        PlaylistDirectoryMultimediaResponseData $responseData
    ): HttpResponseCollectorInterface {
        $this->throwIfPlaylistDirectoryNotBelongsAuthorizedUser($playlistDirectory);

        return $this->responseData($responseData, $deletePlaylistDirectory->process($playlistDirectory), PlatformCodeEnum::DELETED);
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/multimedia/{multimediaMediaLibrary_id<\d+>}/add', methods: Request::METHOD_POST)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST)]
    public function addMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        AddMultimediaMediaLibraryToPlaylistDirectory $addMultimediaMediaLibraryToPlaylistDirectory,
        PlaylistMultimediaResponseData $responseData
    ): HttpResponseCollectorInterface {
        $this->throwIfPlaylistDirectoryNotBelongsAuthorizedUser($playlistDirectory);

        if (!$this->getAuthorizedUser()->isMultimediaMediaLibraryBelongs($multimediaMediaLibrary)) {
            throw EntityNotFoundException::multimedia();
        }

        return $this->responseData(
            $responseData,
            $addMultimediaMediaLibraryToPlaylistDirectory->process($multimediaMediaLibrary, $playlistDirectory),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/directory/multimedia/{multimediaPlaylistDirectory_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST)]
    public function deleteMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaPlaylistDirectory $multimediaPlaylistDirectory,
        DeleteMultimediaFromPlaylistDirectory $deleteMultimediaFromPlaylistDirectory,
        PlaylistMultimediaResponseData $responseData
    ): HttpResponseCollectorInterface {
        if (!$this->getAuthorizedUser()->isMultimediaPlaylistDirectoryBelongs($multimediaPlaylistDirectory)) {
            throw EntityNotFoundException::multimedia();
        }

        return $this->responseData(
            $responseData,
            $deleteMultimediaFromPlaylistDirectory->process($multimediaPlaylistDirectory),
            PlatformCodeEnum::DELETED
        );
    }

    private function throwIfPlaylistDirectoryNotBelongsAuthorizedUser(PlaylistDirectory $playlistDirectory): void
    {
        if (!$this->getAuthorizedUser()->isPlaylistDirectoryBelongs($playlistDirectory)) {
            throw EntityNotFoundException::playlistDirectory();
        }
    }
}