<?php
namespace SFramework;
use GuzzleHttp\Psr7\Request;


/**
 * Class ValidatorAbstract
 * @package SFramework
 */
abstract class ValidatorAbstract implements ValidatorInterface
{

    /** @var Request */
    protected $request = null;

    /**
     * Set parameters for validation
     *
     * @param Request $request
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

}