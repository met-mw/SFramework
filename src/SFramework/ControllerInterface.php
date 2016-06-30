<?php
namespace SFramework;
use GuzzleHttp\Psr7\Request;

/**
 * Interface ControllerInterface
 * @package SFramework
 */
interface ControllerInterface
{

    /**
     * Controller index action
     *
     * @param Request $request
     */
    public function actionIndex(Request $request);

    /**
     * Operations after calling action
     *
     * @param Request $request
     * @return void
     */
    public function afterAction(Request $request);

    /**
     * Operations before calling action
     *
     * @param Request $request
     * @return void
     */
    public function beforeAction(Request $request);

    /**
     * Set controller parameters validator
     *
     * @param ValidatorInterface $validator
     * @return $this
     */
    public function setValidator(ValidatorInterface $validator);

}