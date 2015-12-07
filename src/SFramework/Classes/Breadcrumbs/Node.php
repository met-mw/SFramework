<?php
namespace SFramework\Classes\Breadcrumbs;


use SFramework\Classes\NotificationLog;

class Node {

    private $name;
    private $path;
    /** @var Node */
    private $parentNode;
    /** @var Node[] */
    private $childNodes = [];

    public function __construct($name, $path = 'main') {
        $this->name = $name;
        $this->path = $path;
    }

    public function getName() {
        return $this->name;
    }

    public function getPath() {
        return $this->path;
    }

    /**
     * @param string $startingPath
     *
     * @return string
     */
    public function getRealPath($startingPath = '') {
        $node = $this;
        $pathParts = [];
        while (!is_null($node)) {
            $pathParts[] = $node->getPath();
            $node = $node->getParentNode();
        }

        return ($startingPath != '' ? "/{$startingPath}/" : '/') . implode('/', array_reverse($pathParts));
    }

    public function getChildNodes() {
        return $this->childNodes;
    }

    public function getParentNode() {
        return $this->parentNode;
    }

    public function setParentNode(Node $parentNode) {
        $this->parentNode = $parentNode;
        return $this;
    }

    public function addChildNode($name, $path) {
        if (is_null($this->findChildNodeByPath($path))) {
            $childNode = new Node($name, $path);
            $childNode->setParentNode($this);
            $this->childNodes[] = $childNode;
        } else {
            NotificationLog::instance()->pushError("Узел с путём \"{$path}\" уже существует в контексте \"{$this->getPath()}\".");
        }

        return $this;
    }

    public function findChildNodesByName($name) {
        $nodes = [];
        foreach ($this->getChildNodes() as $childNode) {
            if ($childNode->getName() == $name) {
                $nodes[] = $childNode;
            }
        }

        return $nodes;
    }

    public function findChildNodeByPath($path) {
        $node = null;
        foreach ($this->getChildNodes() as $childNode) {
            if ($childNode->getPath() == $path) {
                $node = $childNode;
                break;
            }
        }

        return $node;
    }

    public function build(array $urlParts) {
        $path = array_shift($urlParts);

        $nodes = [];
        $node = $this->findChildNodeByPath($path);
        $nodes[] = $node;
        if (!empty($urlParts)) {
            $nodes = array_merge($nodes, $node->build($urlParts));
        }

        return $nodes;
    }

} 