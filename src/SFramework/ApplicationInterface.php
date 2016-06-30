<?php
namespace SFramework;


use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

interface ApplicationInterface
{

    /**
     * Get application response
     *
     * @return Response
     */
    public function getResponse();

    /**
     * Get application request
     *
     * @return Request
     */
    public function getRequest();

    /**
     * General settings
     *
     * @param array $settings
     * @return $this
     */
    public function settings(array $settings = []);

    /**
     * Run application
     *
     * @return Response
     */
    public function run();

}