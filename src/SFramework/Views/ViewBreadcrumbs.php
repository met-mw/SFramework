<?php
namespace SFramework\Views;


use SFramework\Classes\Breadcrumbs;
use SFramework\Classes\Breadcrumbs\Node;
use SFramework\Classes\View;

abstract class ViewBreadcrumbs extends View {

    /** @var Node[] */
    public $breadcrumbs;

}