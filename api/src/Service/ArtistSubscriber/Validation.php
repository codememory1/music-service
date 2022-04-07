<?php

namespace App\Service\ArtistSubscriber;

use App\Entity\ArtistSubscriber;
use App\Rest\Http\Response;
use App\Rest\Validator\Validator;

/**
 * Class Validation
 *
 * @package App\Service\ArtistSubscriber
 *
 * @author  Codememory
 */
class Validation
{
    /**
     * @var Validator
     */
    private Validator $validator;

    /**
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param ArtistSubscriber $artistSubscriber
     *
     * @return Response|bool
     */
    public function validate(ArtistSubscriber $artistSubscriber): Response|bool
    {
        $this->validator->validate($artistSubscriber);

        return $this->validator->isValidate() ? true : $this->validator->getResponse();
    }
}