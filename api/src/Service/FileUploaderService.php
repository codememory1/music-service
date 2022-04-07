<?php

namespace App\Service;

use App\Rest\Http\Request;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * Class FileUploaderService.
 *
 * @package App\Service
 *
 * @author  Codememory
 */
class FileUploaderService
{
    /**
     * @var FileBag
     */
    private FileBag $fileBag;

    /**
     * @var ParameterBagInterface
     */
    private ParameterBagInterface $parameters;

    /**
     * @param Request               $request
     * @param ParameterBagInterface $parameters
     */
    public function __construct(Request $request, ParameterBagInterface $parameters)
    {
        $this->fileBag = $request->request->files;
        $this->parameters = $parameters;
    }
}