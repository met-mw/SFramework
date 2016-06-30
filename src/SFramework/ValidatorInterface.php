<?php
namespace SFramework;
use GuzzleHttp\Psr7\Request;


/**
 * Interface ValidatorInterface
 * @package SFramework
 */
interface ValidatorInterface
{

    /**
     * Set parameters for validation
     *
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request);

    /**
     * Validate parameters
     *
     * @return $this
     */
    public function validate();

}