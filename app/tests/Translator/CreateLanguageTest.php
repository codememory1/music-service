<?php

namespace App\Tests\Translator;

use App\Tests\AbstractApiTestCase;

/**
 * Class CreateLanguageTest
 *
 * @package App\Tests\Translator
 *
 * @author  Codememory
 */
class CreateLanguageTest extends AbstractApiTestCase
{

    /**
     * @inheritdoc
     */
    protected ?string $apiPath = '/translator/language/create';

    /**
     * Code validation for minimum length
     *
     * @return void
     */
    public function testCodeMinLength(): void
    {

        $this->clearBase();

        // Min length 2
        $this->createRequest(['code' => '']);

        $this->apiResponseAssertsGroup(
            'error',
            400,
            'input_validation',
            'code_length'
        );

    }

    /**
     * Code validation for maximum length
     *
     * @return void
     */
    public function testCodeMaxLength(): void
    {

        $this->clearBase();

        // Max length 3
        $this->createRequest(['code' => 'english']);

        $this->apiResponseAssertsGroup(
            'error',
            400,
            'input_validation',
            'code_length'
        );

    }

    /**
     * Validation of the language name for mandatory completion
     *
     * @return void
     */
    public function testTitleIsRequired(): void
    {

        $this->clearBase();

        $this->createRequest(['code' => 'en', 'title' => '']);

        $this->apiResponseAssertsGroup(
            'error',
            400,
            'input_validation',
            'title_is_required'
        );

    }

    /**
     * Language name validation for maximum length
     *
     * @return void
     */
    public function testTitleMaxLength(): void
    {

        $title = $this->faker->text(100);
        $this->clearBase();

        // Title max length 50
        $this->createRequest(['code' => 'en', 'title' => $title]);

        $this->apiResponseAssertsGroup(
            'error',
            400,
            'input_validation',
            'title_length'
        );

    }

    /**
     * Checking for Code Existence
     *
     * @return void
     */
    public function testCodeExist(): void
    {

        $this->clearBase();

        $this->createRequest(['code' => 'en', 'title' => 'English']);
        self::ensureKernelShutdown();
        $this->createRequest(['code' => 'en', 'title' => 'English']);

        $this->apiResponseAssertsGroup(
            'error',
            400,
            'input_validation',
            'code_exist'
        );

    }

    /**
     * Successful Language Creation Test
     *
     * @return void
     */
    public function testSuccessCreate(): void
    {

        $this->clearBase();
        $this->createRequest(['code' => 'en', 'title' => 'English']);

        $this->apiResponseAssertsGroup(
            'success',
            200,
            'create',
            'success_create'
        );

    }

}
