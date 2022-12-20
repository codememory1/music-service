<?php

namespace App\Enum;

/**
 * 6054 - SM (Sumron Music).
 */
enum PlatformCodeEnum: int
{
    case CREATED = 6054;
    case UPDATED = 6055;
    case DELETED = 6056;
    case PENDING = 6057;
    case TEXT_ENTRY_VALIDATION_ERROR = 6058;
    case MIME_TYPE_ERROR = 6059;
    case FILE_EXTENSION_ERROR = 6060;
    case FILE_SIZE_ERROR = 6061;
    case AUTHORIZATION_REQUIRED = 6062;
    case AUTHORIZATION_NOT_REQUIRED = 6063;
    case ENTITY_NOT_FOUND = 6064;
    case ENTITY_FOUND = 6065;
    case DO_NOT_HAVE_PERMISSION = 6066;
    case UNEXPECTED_ERROR = 6067; // Например: Если что-то уже существует или данное действие уже было выполнено ранее
    case DATA_DOES_NOT_MATCH = 6068;
    case NOT_ENOUGH_DATA = 6069;
    case INVALID_DATA_FORMAT_IN_FILE = 6070;
    case INVALID_META_DATA_IN_FILE = 6071;
    case OUTPUT = 6072;
    case CREATED_PENDING = 6073; // Создан и ожидает дальнейших действий для полной работоспособности созданного действия
    case INPUT_ERROR = 6074; // Ошибка входных данных
    case INACCESSIBLE_DATA = 6075; // Недоступные данные
    case LIMIT = 6076;
    case NOT_ALLOWED = 6077;
}