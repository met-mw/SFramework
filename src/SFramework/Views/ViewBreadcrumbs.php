<?php
namespace SFramework\Views;


use SFramework\Classes\Breadcrumb;
use SFramework\Classes\View;

abstract class ViewBreadcrumbs extends View {

    /** @var Breadcrumb[] */
    public $breadcrumbs;

}