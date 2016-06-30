<?php
namespace App\Controllers\Admin;

use GuzzleHttp\Psr7\Request;
use SBreadcrumbs\Breadcrumbs;
use SFramework\FrameSet;

class ControllerIndex extends BackControllerAbstract
{

    /**
     * Controller index action
     *
     * @param Request $request
     */
    public function actionIndex(Request $request)
    {
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addBreadcrumb('Index page of admin area');

        FrameSet::f()
            ->bindContent('breadcrumbs', $breadcrumbs->get())
            ->bindContent('content', 'This is a content of index page admin area.');
    }

    public function actionIndex2(Request $request)
    {
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->addBreadcrumb('Index2 page of admin area');

        FrameSet::f()
            ->bindContent('breadcrumbs', $breadcrumbs->get())
            ->bindContent('content', 'This is a content of index2 page admin area.');
    }

}