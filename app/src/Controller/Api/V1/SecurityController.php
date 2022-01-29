<?php

namespace App\Controller\Api\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Faker\Factory;
use Faker\Generator;

/**
 * Class SecurityController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
class SecurityController extends AbstractController
{

    #[Route('/test', methods: ['GET'])]
    public function test()
    {

        $faker = Factory::create('en');

//        dd($faker->text(255));
//dd($faker->text(256));
    }

}