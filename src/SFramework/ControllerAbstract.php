<?php
namespace SFramework;


use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

abstract class ControllerAbstract implements ControllerInterface
{

    /** @var Request */
    protected $request;
    /** @var Response */
    protected $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

}