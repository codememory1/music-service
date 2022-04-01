<?php

namespace App\Enum;

/**
 * Enum EventNameDTOEnum
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum EventNameDTOEnum: string
{

	case BEFORE_INIT_REQUEST_VALUES = 'before_init_request_values';
	case AFTER_INIT_REQUEST_VALUES = 'after_init_request_values';
	case AFTER_SETTER = 'after_setter';
	case BEFORE_BUILD_ENTITY = 'before_build_entity';
	case AFTER_BUILD_ENTITY = 'after_build_entity';

}