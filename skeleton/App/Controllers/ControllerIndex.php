<?php
namespace App\Controllers;


use App\Models\Any;
use App\Views\ViewIndex;
use GuzzleHttp\Psr7\Request;
use SBreadcrumbs\Breadcrumbs;
use SFramework\FrameSet;
use SORM\DataSource;

class ControllerIndex extends FrontControllerAbstract
{

    /**
     * Controller index action
     *
     * @param Request $request
     */
    public function actionIndex(Request $request)
    {
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addBreadcrumb('Index page');

        $viewIndex = new ViewIndex();
        $viewIndex->anyText = 'There any text.';



        FrameSet::f()
            ->bindContent('breadcrumbs', $breadcrumbs->get())
            ->bindView('content', $viewIndex)
            ->bindContent('content', '<hr/><a href="/create">Create new database record</a>');
    }

    /**
     * Controller index action
     *
     * @return void
     */
    public function actionIndex2(Request $request)
    {
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addBreadcrumb('Index2 page');

        FrameSet::f()
            ->bindContent('breadcrumbs', $breadcrumbs->get())
            ->bindContent('content', 'This is a content of index2 page.');
    }

}