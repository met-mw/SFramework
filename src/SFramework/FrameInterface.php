<?php
namespace SFramework;


interface FrameInterface
{

    const FAVICON_PNG = 'image/png';

    /**
     * Add meta tag
     *
     * @param <string, string>[] $parameters
     * @return $this
     */
    public function addMeta(array $parameters);

    /**
     * Include CSS file
     * 
     * @param string $uri
     * @return $this
     */
    public function includeCss($uri);

    /**
     * Include JavaScript file
     * 
     * @param string $uri
     * @return $this
     */
    public function includeJs($uri);

    /**
     * Check frame file is loaded
     *
     * @return bool
     */
    public function isLoaded();

    /**
     * Bind callback to labeled area
     *
     * @param string $label
     * @param callable $callback
     * @return $this
     */
    public function bindCallback($label, callable $callback);

    /**
     * Bind content to labeled area
     *
     * @param string $label
     * @param string $content
     * @return $this
     */
    public function bindContent($label, $content);

    /**
     * Bind view to labeled area
     *
     * @param string $label
     * @param ViewInterface $view
     * @return $this
     */
    public function bindView($label, ViewInterface $view);

    /**
     * Clear all added items, binds and includes
     *
     * @return $this
     */
    public function clear();

    /**
     * Get rendered frame as string
     *
     * @return string
     */
    public function get();

    /**
     * Get not rendered frame as string
     *
     * @return string
     */
    public function getOriginal();

    /**
     * Get frame file path
     *
     * @return string
     */
    public function getPath();

    /**
     * Get frame title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Load frame by file path
     *
     * @param string $path
     * @return $this
     */
    public function load($path);

    /**
     * Render frame
     *
     * @return $this
     */
    public function render();

    /**
     * Set favicon
     *
     * @param string $path
     * @param bool $isPNG
     * @return $this
     */
    public function setFavicon($path, $isPNG = false);

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

}