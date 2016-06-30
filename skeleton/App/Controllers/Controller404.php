<?php
namespace App\Controllers;


use App\Views\View404;
use GuzzleHttp\Psr7\Request;
use SFramework\FrameSet;

class Controller404 extends FrontControllerAbstract
{

    /**
     * Controller index action
     *
     * @param Request $request
     */
    public function actionIndex(Request $request)
    {
        header('HTTP/1.1 404 Not Found');
        $view404 = new View404();
        FrameSet::f()->bindView('content', $view404);
    }

}