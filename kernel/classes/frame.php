<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 07.10.15
 */

namespace kernel\classes;


use Exception;
use kernel\interfaces\Interface_View;

/**
 * Class Frame
 * @package kernel\classes
 *
 * Основной макет страницы
 */
class Frame {

    static protected $instance = null;

    private $systemLabels = ['title', 'css', 'js', 'meta'];

    private $root = '';
    protected $currentFrame = '';
    protected $frameContent = '';

    /** @var Interface_View[]|mixed */
    protected $binds = [];

    private function __construct() {
        $this->root = 'application' . DIRECTORY_SEPARATOR . 'frames'. DIRECTORY_SEPARATOR;
    }

    static public function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setFrame($framePath) {
        if (file_exists("{$this->root}{$framePath}.html")) {
            $this->clear();
            $this->currentFrame = $framePath;
        } else {
            throw new Exception("Фрейм \"{$framePath}\" не существует.");
        }
    }

    public function getFrame() {
        return $this->currentFrame;
    }

    public function getFramePath() {
        return "{$this->root}{$this->currentFrame}.html";
    }

    public function install() {
        $this->frameContent = file_get_contents($this->getFramePath());
    }

    public function clear() {
        $this->currentFrame = '';
        $this->frameContent = '';
    }

    public function addCss($cssPath) {
        $this->binds['css'][] = $cssPath;
    }

    public function addJs($jsPath) {
        $this->binds['js'][] = $jsPath;
    }

    public function bindView($label, Interface_View $view) {
        if (in_array($label, $this->systemLabels)) {
            throw new Exception("Метка \"{$label}\" является системной, её нельзя использовать. Системные метки: " . implode(',', $this->systemLabels));
        }
        $this->binds[$label] = $view;
    }

    public function bindData($label, $data) {
        if (in_array($label, $this->systemLabels)) {
            throw new Exception("Метка \"{$label}\" является системной, её нельзя использовать. Системные метки: " . implode(',', $this->systemLabels));
        }
        $this->binds[$label] = $data;
    }

    public function title($title) {
        $this->binds['title'] = $title;
    }

    public function render() {
        if ($this->currentFrame == '') {
            return;
        }
        $this->install();
        foreach ($this->systemLabels as $systemLabel) {
            if (!isset($this->binds[$systemLabel])) {
                $this->clearLabel($systemLabel);
            }
        }

        foreach (array_keys($this->binds) as $label) {
            $this->applyBind($label);
        }

        echo $this->frameContent;
    }

    protected function clearLabel($label) {
        $this->frameContent = str_replace('{' . $label . '}', '', $this->frameContent);
    }

    protected function applyBind($label) {
        $targetLabel = '{' . $label . '}';

        if ($label == 'css') {
            $css = [];
            foreach ($this->binds[$label] as $cssPath) {
                $css[] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$cssPath}\">";
            }
            $this->frameContent = str_replace($targetLabel, implode("\n", $css), $this->frameContent);
        } elseif ($label == 'js') {
            $js = [];
            foreach ($this->binds[$label] as $jsPath) {
                $js[] = "<script type=\"text/javascript\" async=\"\" src=\"{$jsPath}\"></script>";
            }
            $this->frameContent = str_replace($targetLabel, implode("\n", $js), $this->frameContent);
        } elseif ($label == 'title') {
            $this->frameContent = str_replace($targetLabel, $this->binds[$label], $this->frameContent);
        } elseif (in_array('kernel\interfaces\Interface_View', class_implements($this->binds[$label]))) {
            ob_start();
            $this->binds[$label]->render();
            $content = ob_get_contents();
            ob_end_clean();
            $this->frameContent = str_replace($targetLabel, $content, $this->frameContent);
        } else {
            $this->frameContent = str_replace($targetLabel, $this->binds[$label], $this->frameContent);
        }

    }

} 