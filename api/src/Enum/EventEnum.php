<?php

namespace App\Enum;

enum EventEnum: string
{
    case REGISTER = 'app.registration';
    case IDENTIFICATION_IN_AUTH = 'app.auth.identification';
    case AUTHENTICATION_IN_AUTH = 'app.auth.authentication';
    case AUTHORIZATION = 'app.auth';
    case REQUEST_RESTORATION_PASSWORD = 'app.password-reset.request';
    case AFTER_REQUEST_RESTORATION_PASSWORD = 'app.after-password-reset.request';
    case ACCOUNT_ACTIVATION = 'app.account-activation';
    case AFTER_SAVE_MULTIMEDIA = 'app.multimedia.after-save';
    case MULTIMEDIA_STATUS_CHANGE = 'app.multimedia.status-change';
    case SET_RATING_MULTIMEDIA = 'app.multimedia.set-rating';
    case ALBUM_STATUS_CHANGE = 'app.album.status-change';
    case CREATE_MEDIA_LIBRARY = 'app.media-library.create';
}