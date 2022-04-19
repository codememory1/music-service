<?php

namespace App\Resolver;

use App\Interfaces\DTOInterface;
use App\Rest\Http\Request as RestRequest;
use App\Rest\Validator\Validator;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Class DTOResolver.
 *
 * @package App\Resolver
 *
 * @author  Codememory
 */
class DTOResolver implements ArgumentValueResolverInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var RestRequest
     */
    private RestRequest $request;

    /**
     * @var Validator
     */
    private Validator $validator;

    /**
     * @param EntityManagerInterface $entityManager
     * @param RestRequest            $request
     * @param Validator              $validator
     */
    public function __construct(EntityManagerInterface $entityManager, RestRequest $request, Validator $validator)
    {
        $this->em = $entityManager;
        $this->request = $request;
        $this->validator = $validator;
    }

    /**
     * @inheritDoc
     *
     * @throws ReflectionException
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $reflection = new ReflectionClass($argument->getType());

        return $reflection->implementsInterface(DTOInterface::class);
    }

    /**
     * @inheritDoc
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $DTO = new ($argument->getType())($this->request, $this->em);

        $this->validator->validate($DTO);

        if (false === $this->validator->isValidate()) {
            $this->validator->getResponse()->send();
        }

        yield $DTO;
    }
}