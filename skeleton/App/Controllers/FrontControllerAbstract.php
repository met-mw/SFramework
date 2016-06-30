<?php
namespace App\Controllers;


use Exception;
use GuzzleHttp\Psr7\Request;
use SFramework\ControllerInterface;
use SFramework\FrameSet;
use SFramework\ValidatorInterface;

abstract class FrontControllerAbstract implements ControllerInterface
{

    /** @var ValidatorInterface */
    private $validator;

    /**
     * Operations after calling action
     *
     * @param Request $request
     * @return void
     */
    public function afterAction(Request $request)
    {
        // TODO: Implement afterAction() method.
    }

    /**
     * Operations before calling action
     *
     * @param Request $request
     * @return void
     * @throws Exception
     */
    public function beforeAction(Request $request)
    {
        FrameSet::i()->setCurrent('front')
            ->getCurrent()
            ->load(SFW_APP_FRAMES_ROOT . 'front.html')
            ->addMeta(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0'])
            ->addMeta(['charset' => 'utf8']);

        if (!is_null($this->validator)) {
            $this->validator
                ->setRequest($request)
                ->validate();
        }
    }

    /**
     * Set controller parameters validator
     *
     * @param ValidatorInterface $validator
     * @return $this
     */
    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
        return $this;
    }

}