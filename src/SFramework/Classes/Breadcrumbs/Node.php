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
    /** @var bool */
    private $hidden;
    /** @var bool */
    private $isParam = false;

    public function __construct($name, $path = '', $isPseudoParent = false, $hidden = false, $isParam = false) {
        $this->name = $name;
        $this->path = $path;
        $this->isPseudoParent = $isPseudoParent;
        $this->hidden = $hidden;
        $this->isParam = $isParam;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    public function isPseudo() {
        return $this->isPseudoParent;
    }

    public function isParam() {
        return $this->isParam;
    }

    public function getRealPath() {
        $node = $this;
        $pathParts = [];
        $params = [];
        while (!is_null($node)) {
            if ($node->isParam()) {
                $params[] = $node->getPath();
            } else {
                $pathParts[] = $node->getPath();
            }
            $node = $node->getRealParentNode();
        }

        $result = '/' . implode('/', array_reverse($pathParts));
        if (!empty($params)) {
            $result .= '?' . implode('&', array_reverse($params));
        }

        return $result;
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

    public function getPseudoParentsChain() {
        $node = $this;
        $nodes = [];
        while ($node->isPseudo()) {
            if (!$node->isHidden()) {
                $nodes[] = $node;
            }
            $node = $node->getParentNode();
        }

        return array_reverse($nodes);
    }

    public function getParentNode() {
        return $this->parentNode;
    }

    public function setParentNode(Node $parentNode) {
        $this->parentNode = $parentNode;
        return $this;
    }

    public function addChildNode($name, $path, $isPseudoParent = false, $hidden = false, $isParam = false) {
        if (is_null($this->findChildNodeByPath($path))) {
            $childNode = new Node($name, $path, $isPseudoParent, $hidden, $isParam);
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

    public function hide() {
        $this->hidden = true;
    }

    public function show() {
        $this->hidden = false;
    }

    public function isHidden() {
        return $this->hidden;
    }

    public function build(array $urlParts, array $filteredParams) {
        if (!empty($urlParts)) {
            $path = array_shift($urlParts);
        } else {
            $path = array_shift($filteredParams);
        }

        $nodes = [];
        $node = $this->findChildNodeByPath($path);
        if ($node->isPseudo()) {
            $nodes = $node->getPseudoParentsChain();
        } else {
            if (!$node->isHidden()) {
                $nodes[] = $node;
            }
        }
        if (!empty($urlParts) || !empty($filteredParams)) {
            $nodes = array_merge($nodes, $node->build($urlParts, $filteredParams));
        }

        return $nodes;
    }

} 