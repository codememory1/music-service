<?php

namespace App\Enum;

use App\Annotation\Auth;
use App\Annotation\UserRole;
use App\Annotation\UserRolePermission;
use App\AnnotationListener\AuthAnnotationListener;
use App\AnnotationListener\UserRoleAnnotationListener;
use App\AnnotationListener\UserRolePermissionAnnotationListener;

/**
 * Enum AnnotationListenerEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum AnnotationListenerEnum: string
{
    public const LISTENERS = [
        Auth::class => AuthAnnotationListener::class,
        UserRole::class => UserRoleAnnotationListener::class,
        UserRolePermission::class => UserRolePermissionAnnotationListener::class
    ];
}