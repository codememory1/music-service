<?php

namespace App\Orm\Repositories;

use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use ReflectionException;

/**
 * Class AccessRightNameRepository
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
class AccessRightNameRepository extends AbstractEntityRepository
{

    public const AUTH_TO_AP = 'authorization_to_admin_panel';
    public const ADD_MUSIC_FROM_AP = 'add_music_from_admin_panel';
    public const REMOVE_MUSIC_FROM_AP = 'remove_music_from_admin_panel';
    public const CHANGE_MUSIC_FROM_AP = 'change_music_data_from_admin_panel';
    public const VIEW_USERS = 'view_users_to_admin_panel';
    public const EDIT_USER_DATA = 'edit_user_data';
    public const VIEW_STATISTICS = 'view_statistics';
    public const ADD_MUSIC_AS_EXECUTOR = 'add_music_as_executor';
    public const REMOVE_MUSIC_AS_EXECUTOR = 'remove_music_as_executor';
    public const CHANGE_MUSIC_AS_EXECUTOR = 'change_music_as_executor';
    public const CREATE_SUBSCRIPTION = 'create-subscription';
    public const UPDATE_SUBSCRIPTION = 'update-subscription';
    public const DELETE_SUBSCRIPTION = 'remove-subscription';
    public const ADD_MUSIC = 'add-music';
    public const EDIT_MUSIC = 'edit-music';
    public const DELETE_MUSIC = 'delete-music';
    public const UPDATE_TRANSLATION_CACHE = 'update-translation-cache';
    public const CREATE_LANG = 'create-lang';
    public const ADD_TRANSLATION = 'add-translation';

    /**
     * @param string $name
     *
     * @return bool|int
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function getIdByName(string $name): bool|int
    {

        $result = $this->customFindBy(['name' => $name])->array()->first();

        if (false !== $result) {
            return $result['id'];
        }

        return false;

    }

}