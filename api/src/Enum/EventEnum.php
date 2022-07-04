<?php

namespace App\Enum;

/**
 * Enum EventEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum EventEnum: string
{
    case REGISTER = 'app.registration';
    case IDENTIFICATION_IN_AUTH = 'app.auth.identification';
    case AUTHENTICATION_IN_AUTH = 'app.auth.authentication';
    case AUTHORIZATION = 'app.auth';
    case REQUEST_RESTORATION_PASSWORD = 'app.password-reset.request';
    case ACCOUNT_ACTIVATION = 'app.account-activation';
    case BEFORE_SAVE_MULTIMEDIA = 'app.multimedia.before-save';
    case AFTER_SAVE_MULTIMEDIA = 'app.multimedia.after-save';
    case MULTIMEDIA_STATUS_CHANGE = 'app.multimedia.status-change';
    case SAVE_ALBUM = 'app.album.save';
    case SET_RATING_MULTIMEDIA = 'app.multimedia.set-rating';
    case ALBUM_STATUS_CHANGE = 'app.album.status-change';
    case CREATE_MEDIA_LIBRARY = 'app.media-library.create';
    case UPDATE_MULTIMEDIA_MEDIA_LIBRARY = 'app.media-library.multimedia.update';
}