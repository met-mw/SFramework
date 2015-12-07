<?php
namespace SFramework\Classes;


use SFramework\Classes\Breadcrumbs\Node;

class Breadcrumbs {

    /** @var Node */
    protected $root;
    /** @var string */
    protected $url;

    public function __construct($url, $rootName, $rootPath = 'main') {
        $this->root = new Node($rootName, $rootPath);
        $this->url = $url;
    }

    public function getRoot() {
        return $this->root;
    }

    public function build() {
        $nodes = [];

        $urlParts = explode('/', $this->url);
        if (count($urlParts) > 1) {
            $urlParts = array_diff($urlParts, ['']);
            if (reset($urlParts) == 'main') {
                array_shift($urlParts);
            }
        }

        $nodes[] = $this->getRoot();
        if (!empty($urlParts)) {
            $nodes = array_merge($nodes, $this->getRoot()->build($urlParts));
        }
        return $nodes;
    }

} 