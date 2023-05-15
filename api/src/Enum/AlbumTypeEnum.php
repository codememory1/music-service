<?php

namespace App\Enum;

enum AlbumTypeEnum: string
{
    case REMIX = 'album.type.remix';
    case DOUBLE = 'album.type.double';
    case CONCERT = 'album.type.concert';
    case MAGNETIC = 'album.type.magnetic';
    case MINION = 'album.type.minion';
    case COMPILATION = 'album.type.compilation';
    case BEST_COMPILATION = 'album.type.best_compilation';
    case SINGLE = 'album.type.single';
}