<?php
namespace SFramework\Classes;


use Exception;
use SFramework\Interfaces\InterfaceView;


/**
 * Class Frame
 *
 * Основной макет страницы
 */
class Frame {

    private $systemLabels = ['title', 'css', 'js', 'meta', 'favicon'];

    private $root = '';
    protected $currentFrame = '';
    protected $frameContent = '';

    /** @var InterfaceView[]|mixed */
    protected $binds = [];

    public function __construct($framesRoot) {
        $this->root = $framesRoot;
    }

    public function setFrame($framePath) {
        if (file_exists("{$this->root}{$framePath}.html")) {
            $this->clear();
            $this->currentFrame = $framePath;
        } else {
            throw new Exception("Фрейм \"{$framePath}\" не существует.");
        }

        return $this;
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
        return $this;
    }

    public function addJs($jsPath) {
        $this->binds['js'][] = $jsPath;
        return $this;
    }

    public function setFavicon(array $faviconData = ['href' => '/favicon.ico', 'type' => 'image/x-icon']) {
        if (!isset($faviconData['href']) || !($faviconData['type'])) {
            throw new Exception('Неверные парметры иконки сайта.');
        }

        $this->binds['favicon'] = $faviconData;
        return $this;
    }

    public function addMeta(array $metaParams) {
        $this->binds['meta'][] = $metaParams;
        return $this;
    }

    public function bindView($label, InterfaceView $view) {
        if (in_array($label, $this->systemLabels)) {
            throw new Exception("Метка \"{$label}\" является системной, её нельзя использовать. Системные метки: " . implode(',', $this->systemLabels));
        }
        $this->binds[$label] = $view;

        return $this;
    }

    public function bindData($label, $data) {
        if (in_array($label, $this->systemLabels)) {
            throw new Exception("Метка \"{$label}\" является системной, её нельзя использовать. Системные метки: " . implode(',', $this->systemLabels));
        }
        $this->binds[$label] = $data;

        return $this;
    }

    public function setTitle($title) {
        $this->binds['title'] = $title;
        return $this;
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
        $this->frameContent = str_replace("<!--label[{$label}]-->", '', $this->frameContent);
    }

    protected function applyBind($label) {
        $targetLabel = "<!--label[{$label}]-->";

        if ($label == 'favicon') {
            $content = "<link rel=\"shortcut icon\" href=\"{$this->binds[$label]['href']}\" type=\"{$this->binds[$label]['type']}\">";
        } elseif ($label == 'css') {
            $css = [];
            foreach ($this->binds[$label] as $cssPath) {
                $css[] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$cssPath}\">";
            }
            $content = implode("\n", $css);
        } elseif ($label == 'js') {
            $js = [];
            foreach ($this->binds[$label] as $jsPath) {
                $js[] = "<script type=\"text/javascript\" src=\"{$jsPath}\"></script>";
            }
            $content = implode("\n", $js);
        } elseif ($label == 'meta') {
            $meta = [];
            foreach ($this->binds[$label] as $metaData) {
                foreach ($metaData as $key => $value) {
                    $meta[] = "{$key}=\"{$value}\"";
                }
            }
            $content = '<meta ' . implode(' ', $meta) . ' />';
        } elseif ($this->binds[$label] instanceof InterfaceView) {
            ob_start();
            $this->binds[$label]->render();
            $content = ob_get_contents();
            ob_end_clean();
        } else {
            $content = $this->binds[$label];
        }

        $this->frameContent = str_replace($targetLabel, $content, $this->frameContent);
    }

} 