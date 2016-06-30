<?php
namespace SFramework;


/**
 * Interface FrameSetInterface
 * @package SFramework
 */
interface FrameSetInterface
{

    /**
     * Get FrameSet instance
     *
     * @return $this
     */
    static public function i();

    /**
     * Get current frame
     *
     * @return FrameInterface
     */
    static public function f();

    /**
     * Add frame
     *
     * @param string $frameKey
     * @param FrameInterface $frame
     * @param bool $isCurrent
     * @return $this
     */
    public function addFrame($frameKey, FrameInterface $frame, $isCurrent = false);

    /**
     * Check current frame exists or sets
     *
     * @return bool
     */
    public function hasCurrent();

    /**
     * Check frame exists by key
     *
     * @param string $frameKey
     * @return bool
     */
    public function hasFrame($frameKey);

    /**
     * Get current frame
     *
     * @return FrameInterface
     */
    public function getCurrent();

    /**
     * Get frame by key
     *
     * @param string $frameKey
     * @return FrameInterface
     */
    public function getFrame($frameKey);

    /**
     * Set current frame
     *
     * @param string $frameKey
     * @return $this
     */
    public function setCurrent($frameKey);

}