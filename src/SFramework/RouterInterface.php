<?php
namespace SFramework;


use GuzzleHttp\Psr7\Uri;

interface RouterInterface
{

    /**
     * Find controller
     *
     * @param string[] $pathParts
     * @return ControllerInterface
     */
    public function findController(array &$pathParts);

    /**
     * Find action
     *
     * @param ControllerInterface $controller
     * @param string|null $pathPart
     * @return string
     */
    public function findAction(ControllerInterface $controller, $pathPart = null);

    /**
     * Check root exists or sets
     *
     * @return bool
     */
    public function hasRoot();

    /**
     * Check uri sets
     *
     * @return bool
     */
    public function hasURI();

    /**
     * Set controllers root
     *
     * @param string $root
     * @return $this
     */
    public function setRoot($root);

    /**
     * Set URI
     *
     * @param Uri $uri
     * @return $this
     */
    public function setURI(Uri $uri);

    /**
     * Start route
     *
     * @return callback
     */
    public function route();

}