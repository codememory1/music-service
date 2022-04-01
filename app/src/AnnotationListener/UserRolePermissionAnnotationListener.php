<?php

namespace App\AnnotationListener;

use App\Enum\ApiResponseTypeEnum;
use App\Rest\ClassHelper\AttributeData;

/**
 * Class UserRolePermissionAnnotationListener
 *
 * @package App\AnnotationListener
 *
 * @author  Codememory
 */
class UserRolePermissionAnnotationListener extends AbstractAnnotationListener
{

	/**
	 * @inheritDoc
	 */
	public function listen(AttributeData $attributeData): void
	{

		$user = $this->authenticator->getUser();

		if (null === $user || $user->getRole()->getRolePermissions()->contains($attributeData->permission)) {
			$this->apiResponseSchema->setMessage(
				ApiResponseTypeEnum::CHECK_ROLE_PERMISSION,
				$this->getTranslation('common@accessDenied')
			);

			$this->response('error', 403);
		}

	}

}