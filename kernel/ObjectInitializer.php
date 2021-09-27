<?php

namespace Kernel;

use Codememory\FileSystem\File;
use Codememory\HttpFoundation\Client\Header\Header;
use Codememory\HttpFoundation\Request\Request;
use Codememory\HttpFoundation\Response\Response;

/**
 * Class ObjectInitializer
 *
 * @package Kernel
 *
 * @author  Codememory
 */
final class ObjectInitializer
{

    /**
     * @var File
     */
    public static File $filesystem;

    /**
     * @var Request
     */
    public static Request $request;

    /**
     * @var Header
     */
    public static Header $header;

    /**
     * @var Response
     */
    public static Response $response;

    /**
     * @var FrameworkConfiguration
     */
    public static FrameworkConfiguration $frameworkConfiguration;

    /**
     * ObjectInitializer Construct
     */
    public function __construct()
    {

        self::$filesystem = new File();
        self::$request = new Request();
        self::$header = new Header();
        self::$response = new Response(self::$header);
        self::$frameworkConfiguration = new FrameworkConfiguration();

    }

}