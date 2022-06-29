<?php

namespace App\Enum;

/**
 * Enum FrontendRouteEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum FrontendRouteEnum: string
{
    case ARTIST_ALBUM = '/artist/{artist_id}/album/{album_id}';

    /**
     * @param FrontendRouteEnum $route
     * @param array             $parameters
     *
     * @return null|string
     */
    public static function getRoute(FrontendRouteEnum $route, array $parameters = []): ?string
    {
        $parameterKeys = array_map(static fn(string $key) => sprintf('{%s}', $key), array_keys($parameters));

        return str_replace($parameterKeys, $parameters, $route->value);
    }
}