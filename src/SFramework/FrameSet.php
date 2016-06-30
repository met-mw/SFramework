<?php
namespace SFramework;


use Exception;
use InvalidArgumentException;

class FrameSet implements FrameSetInterface
{

    /** @var $this|null */
    static private $instance = null;

    /** @var FrameInterface[] */
    protected $frames = [];

    /** @var string|null */
    protected $currentFrameKey = null;

    /**
     * Get FrameSet instance
     *
     * @return $this
     */
    static public function i()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Get current frame
     *
     * @return FrameInterface
     * @throws Exception
     */
    static public function f()
    {
        return static::i()->getCurrent();
    }

    private function __construct() {}

    /**
     * Add frame
     *
     * @param string $frameKey
     * @param FrameInterface $frame
     * @param bool $isCurrent
     * @return $this
     */
    public function addFrame($frameKey, FrameInterface $frame, $isCurrent = false)
    {
        if (!is_string($frameKey)) {
            throw new InvalidArgumentException('Frame key must be a string.');
        }

        if (!is_bool($isCurrent)) {
            throw new InvalidArgumentException('Current flag must be a boolean.');
        }

        $this->frames[$frameKey] = $frame;
        if ($isCurrent) {
            $this->setCurrent($frameKey);
        }

        return $this;
    }

    /**
     * Check current frame exists or sets
     *
     * @return bool
     */
    public function hasCurrent()
    {
        return !is_null($this->currentFrameKey) && $this->hasFrame($this->currentFrameKey);
    }

    /**
     * Check frame exists by key
     *
     * @param string $frameKey
     * @return bool
     */
    public function hasFrame($frameKey)
    {
        if (!is_string($frameKey)) {
            throw new InvalidArgumentException('Frame key must be a string.');
        }

        return isset($this->frames[$frameKey]);
    }

    /**
     * Get current frame
     *
     * @return FrameInterface
     * @throws Exception
     */
    public function getCurrent()
    {
        if (!$this->hasCurrent()) {
            throw new Exception('Current frame not found.');
        }

        return $this->getFrame($this->currentFrameKey);
    }

    /**
     * Get frame by key
     *
     * @param string $frameKey
     * @return FrameInterface
     * @throws Exception
     */
    public function getFrame($frameKey)
    {
        if (!$this->hasFrame($frameKey)) {
            throw new Exception("Frame with name \"{$frameKey}\" not found.");
        }

        return $this->frames[$frameKey];
    }

    /**
     * Set current frame
     *
     * @param string $frameKey
     * @return $this
     * @throws Exception
     */
    public function setCurrent($frameKey)
    {
        if (!$this->hasFrame($frameKey)) {
            throw new Exception("Frame with name \"{$frameKey}\" not found.");
        }

        $this->currentFrameKey = $frameKey;
        return $this;
    }

}