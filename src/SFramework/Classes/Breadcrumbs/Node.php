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

    /** @var bool */
    private $isPseudoParent;

    public function __construct($name, $path = '', $isPseudoParent = false) {
        $this->name = $name;
        $this->path = $path;
        $this->isPseudoParent = $isPseudoParent;
    }

    public function getName() {
        return $this->name;
    }

    public function getPath() {
        return $this->path;
    }

    public function isPseudo() {
        return $this->isPseudoParent;
    }

    public function getRealPath() {
        $node = $this;
        $pathParts = [];
        while (!is_null($node)) {
            $pathParts[] = $node->getPath();
            $node = $node->getRealParentNode();
        }

        return '/' . implode('/', array_reverse($pathParts));
    }

    public function getChildNodes() {
        return $this->childNodes;
    }

    public function getRealParentNode() {
        $parent = $this->getParentNode();
        while (!is_null($parent) && $parent->isPseudo()) {
            $parent = $parent->getParentNode();
        }

        return $parent;
    }

    public function getParentNode() {
        return $this->parentNode;
    }

    public function setParentNode(Node $parentNode) {
        $this->parentNode = $parentNode;
        return $this;
    }

    public function addChildNode($name, $path, $isPseudoParent = false) {
        if (is_null($this->findChildNodeByPath($path))) {
            $childNode = new Node($name, $path, $isPseudoParent);
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

        if (is_null($node)) {
            foreach ($this->getChildNodes() as $childNode) {
                if ($childNode->isPseudo()) {
                    $node = $childNode->findChildNodeByPath($path);
                    if (!is_null($node)) {
                        break;
                    }
                }
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