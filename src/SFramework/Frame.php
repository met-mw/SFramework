<?php
namespace SFramework;


use Exception;
use InvalidArgumentException;

class Frame implements FrameInterface
{

    /** @var string */
    private $path = null;
    /** @var string */
    private $original = null;

    /** @var string */
    protected $title = 'Title';

    protected $favicon = [
        'path' => '/favicon.ico',
        'isPNG' => false
    ];

    protected $cssIncludes = [];
    protected $jsIncludes = [];
    protected $metaData = [];
    protected $binds = [];

    /**
     * Add meta tag
     *
     * @param <string, string>[] $parameters
     * @return $this
     */
    public function addMeta(array $parameters)
    {
        if (!is_array($parameters)) {
            throw new InvalidArgumentException('Meta tag parameters must be a assoc array (\'name\' => \'value\').');
        }

        array_filter($parameters, function($name, $value) {
            if (empty($name) || !is_string($name)) {
                throw new InvalidArgumentException('Meta tag parameters array key must be a string.');
            }

            if (!is_string($value)) {
                throw new InvalidArgumentException('Meta tag parameters array value must be a string.');
            }
        }, ARRAY_FILTER_USE_BOTH);

        $this->metaData[] = $parameters;
        return $this;
    }

    /**
     * Include CSS file
     *
     * @param string $uri
     * @return $this
     */
    public function includeCss($uri)
    {
        if (!is_string($uri)) {
            throw new InvalidArgumentException('CSS URI must be a string.');
        }

        if (!@fopen(ltrim($uri, '/'), "r")) {
            throw new InvalidArgumentException("CSS file not found.");
        }

        $this->cssIncludes[] = $uri;
        return $this;
    }

    /**
     * Include JavaScript file
     *
     * @param string $uri
     * @return $this
     */
    public function includeJs($uri)
    {
        if (!is_string($uri)) {
            throw new InvalidArgumentException('JavaScript URI must be a string.');
        }

        if (!@fopen(ltrim($uri, '/'), "r")) {
            throw new InvalidArgumentException("JavaScript file not found.");
        }

        $this->jsIncludes[] = $uri;
        return $this;
    }

    /**
     * Check frame file is loaded
     *
     * @return bool
     */
    public function isLoaded()
    {
        return !is_null($this->getPath());
    }

    /**
     * Bind callback to labeled area
     *
     * @param string $label
     * @param callable $callback
     * @return $this
     */
    public function bindCallback($label, callable $callback)
    {
        if (!is_string($label)) {
            throw new InvalidArgumentException('Label must be a string.');
        }

        $this->binds[$label][] = $callback;
        return $this;
    }

    /**
     * Bind content to labeled area
     *
     * @param string $label
     * @param string $content
     * @return $this
     */
    public function bindContent($label, $content)
    {
        if (!is_string($label)) {
            throw new InvalidArgumentException('Label must be a string.');
        }

        if (!is_string($content)) {
            throw new InvalidArgumentException('Content must be a string.');
        }

        $this->binds[$label][] = $content;
        return $this;
    }

    /**
     * Bind view to labeled area
     *
     * @param string $label
     * @param ViewInterface $view
     * @return $this
     */
    public function bindView($label, ViewInterface $view)
    {
        if (!is_string($label)) {
            throw new InvalidArgumentException('Label must be a string.');
        }

        $this->binds[$label][] = $view;
        return $this;
    }

    /**
     * Clear all added items, binds and includes
     *
     * @return $this
     */
    public function clear()
    {
        $this->cssIncludes = [];
        $this->jsIncludes = [];
        $this->metaData = [];
        $this->binds = [];

        return $this;
    }

    /**
     * Get rendered frame as string
     *
     * @return string
     */
    public function get()
    {
        ob_start();
        $this->render();
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * Get not rendered frame as string
     *
     * @return string
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * Get frame file path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
    * Get frame title
    *
    * @return string
    */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Load frame by file path
     *
     * @param string $path
     * @return $this
     */
    public function load($path)
    {
        if (!is_string($path)) {
            throw new InvalidArgumentException('Frame file path must be a string.');
        }

        if (!file_exists($path)) {
            throw new InvalidArgumentException('Frame file not found.');
        }

        if (!is_file($path)) {
            throw new InvalidArgumentException('Frame file path must be the path to the file.');
        }

        $this->path = $path;
        $this->original = file_get_contents($this->getPath());

        return $this;
    }

    /**
     * Render frame
     *
     * @return $this
     * @throws Exception
     */
    public function render()
    {
        if (!$this->isLoaded()) {
            throw new Exception('Frame is not loaded.');
        }

        $meta = [];
        foreach ($this->metaData as $metaAttributes) {
            $attributes = [];
            foreach ($metaAttributes as $name => $value) {
                $attributes[] = "{$name}=\"{$value}\"";
            }
            $meta[] = '<meta ' . implode(' ', $attributes) . '/>';
        }

        $css = [];
        foreach ($this->cssIncludes as $cssInclude) {
            $css[] = "<link rel=\"stylesheet\" type='text/css' href=\"{$cssInclude}\" />" . PHP_EOL;
        }

        $js = [];
        foreach ($this->jsIncludes as $jsInclude) {
            $js[] = "<script type=\"text/javascript\" src=\"{$jsInclude}\"></script>" . PHP_EOL;
        }

        $faviconType = $this->favicon['isPNG'] ? ' type="image/png"' : '';
        $favicon = "<link rel=\"icon\"{$faviconType} href=\"{$this->favicon['path']}\" />";

        $allContent = $this->getOriginal();
        foreach ($this->binds as $label => $binds) {
            $content = '';
            foreach ($binds as $bind) {
                if (is_string($bind)) {
                    $content .= $bind;
                } elseif ($bind instanceof ViewInterface) {
                    $content .= $bind->get();
                } elseif (is_callable($bind)) {
                    $content .= $bind();
                }
            }

            $allContent = str_replace("<!--label[{$label}]-->", $content, $allContent);
        }

        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title><? echo $this->getTitle() ?></title>
                <? echo implode(PHP_EOL, $meta) ?>
                <? echo $favicon ?>
                <? echo implode(PHP_EOL, $css) ?>
                <? echo implode(PHP_EOL, $js) ?>
            </head>
            <body>
                <? echo $allContent ?>
            </body>
        </html>
        <?
    }

    /**
     * Set favicon
     *
     * @param string $path
     * @param bool $isPNG
     * @return $this
     */
    public function setFavicon($path, $isPNG = false)
    {
        if (!is_string($path)) {
            throw new InvalidArgumentException('Favicon path must be a string.');
        }

        if (!is_bool($isPNG)) {
            throw new InvalidArgumentException('Favicon PHG flag must be a boolean.');
        }

        $this->favicon = ['path' => $path, 'isPNG' => $isPNG];
        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        if (!is_string($title)) {
            throw new InvalidArgumentException('Title must be a string.');
        }

        $this->title = $title;
        return $this;
    }

}