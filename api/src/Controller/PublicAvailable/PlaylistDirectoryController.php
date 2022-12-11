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
use App\ResponseData\General\Playlist\Directory\PlaylistDirectoryMultimediaResponseData;
use App\ResponseData\General\Playlist\PlaylistMultimediaResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\MediaLibrary\Multimedia\AddMultimediaMediaLibraryToPlaylistDirectory;
use App\UseCase\Playlist\Directory\CreatePlaylistDirectory;
use App\UseCase\Playlist\Directory\DeletePlaylistDirectory;
use App\UseCase\Playlist\Directory\Multimedia\DeleteMultimediaFromPlaylistDirectory;
use App\UseCase\Playlist\Directory\UpdatePlaylistDirectory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/media-library/playlist')]
#[Authorization]
class PlaylistDirectoryController extends AbstractRestController
{
    #[Route('/{playlist_id<\d+>}/directory/create', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::CREATE_DIRECTORY_TO_PLAYLIST)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'playlist')] Playlist $playlist,
        PlaylistDirectoryTransformer $transformer,
        CreatePlaylistDirectory $createPlaylistDirectory,
        PlaylistDirectoryMultimediaResponseData $responseData
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isPlaylistBelongs($playlist)) {
            throw EntityNotFoundException::playlist();
        }

        $responseData->setEntities($createPlaylistDirectory->process(
            $transformer->transformFromRequest(),
            $playlist
        ));

        return $this->responseData($responseData, PlatformCodeEnum::CREATED);
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/edit', methods: 'PUT')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        PlaylistDirectoryTransformer $transformer,
        UpdatePlaylistDirectory $updatePlaylistDirectory,
        PlaylistDirectoryMultimediaResponseData $responseData
    ): JsonResponse {
        $this->throwIfPlaylistDirectoryNotBelongsAuthorizedUser($playlistDirectory);

        $responseData->setEntities($updatePlaylistDirectory->process($transformer->transformFromRequest($playlistDirectory)));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/delete', methods: 'DELETE')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_DIRECTORY_TO_PLAYLIST)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        DeletePlaylistDirectory $deletePlaylistDirectory,
        PlaylistDirectoryMultimediaResponseData $responseData
    ): JsonResponse {
        $this->throwIfPlaylistDirectoryNotBelongsAuthorizedUser($playlistDirectory);

        $responseData->setEntities($deletePlaylistDirectory->process($playlistDirectory));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }

    #[Route('/directory/{playlistDirectory_id<\d+>}/multimedia/{multimediaMediaLibrary_id<\d+>}/add', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST)]
    public function addMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'playlistDirectory')] PlaylistDirectory $playlistDirectory,
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        AddMultimediaMediaLibraryToPlaylistDirectory $addMultimediaMediaLibraryToPlaylistDirectory,
        PlaylistMultimediaResponseData $responseData
    ): JsonResponse {
        $this->throwIfPlaylistDirectoryNotBelongsAuthorizedUser($playlistDirectory);

        if (false === $this->getAuthorizedUser()->isMultimediaMediaLibraryBelongs($multimediaMediaLibrary)) {
            throw EntityNotFoundException::multimedia();
        }

        $responseData->setEntities($addMultimediaMediaLibraryToPlaylistDirectory->process(
            $multimediaMediaLibrary,
            $playlistDirectory
        ));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/directory/multimedia/{multimediaPlaylistDirectory_id<\d+>}/delete', methods: 'DELETE')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_DIRECTORY_TO_PLAYLIST)]
    public function deleteMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaPlaylistDirectory $multimediaPlaylistDirectory,
        DeleteMultimediaFromPlaylistDirectory $deleteMultimediaFromPlaylistDirectory,
        PlaylistMultimediaResponseData $responseData
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isMultimediaPlaylistDirectoryBelongs($multimediaPlaylistDirectory)) {
            throw EntityNotFoundException::multimedia();
        }

        $responseData->setEntities($deleteMultimediaFromPlaylistDirectory->process($multimediaPlaylistDirectory));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }

    private function throwIfPlaylistDirectoryNotBelongsAuthorizedUser(PlaylistDirectory $playlistDirectory): void
    {
        if (false === $this->getAuthorizedUser()->isPlaylistDirectoryBelongs($playlistDirectory)) {
            throw EntityNotFoundException::playlistDirectory();
        }
    }
}