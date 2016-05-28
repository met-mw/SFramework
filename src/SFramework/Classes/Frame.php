<?php
namespace SFramework\Classes;


use Exception;
use SFramework\Interfaces\InterfaceView;
use SFramework\Views\ViewErrors;


/**
 * Class Frame
 *
 * Основной макет страницы
 */
class Frame
{

    private $systemLabels = ['title', 'css', 'js', 'meta', 'favicon'];

    private $framesRoot = '';
    protected $currentFrameName = '';
    protected $frameContent = '';

    /** @var InterfaceView[]|mixed */
    protected $binds = [];

    public function __construct($framesRoot)
    {
        $this->framesRoot = $framesRoot;
    }

    public function setFrame($framePath)
    {
        if (file_exists("{$this->framesRoot}{$framePath}.html")) {
            $this->clear();
            $this->currentFrameName = $framePath;
        } else {
            throw new Exception("Фрейм \"{$framePath}\" не существует.");
        }

        return $this;
    }

    public function getFrame()
    {
        return $this->currentFrameName;
    }

    public function getFramePath()
    {
        return "{$this->framesRoot}{$this->currentFrameName}.html";
    }

    public function install()
    {
        $this->frameContent = file_get_contents($this->getFramePath());
    }

    public function clear()
    {
        $this->currentFrameName = '';
        $this->frameContent = '';
    }

    public function addCss($cssPath)
    {
        $this->binds['css'][] = $cssPath;
        return $this;
    }

    public function addJs($jsPath, $dataAttributes = [])
    {
        $this->binds['js'][] = ['path' => $jsPath, 'data' => $dataAttributes];
        return $this;
    }

    public function setFavicon(array $faviconData = ['href' => '/favicon.ico', 'type' => 'image/x-icon'])
    {
        if (!isset($faviconData['href']) || !($faviconData['type'])) {
            throw new Exception('Неверные парметры иконки сайта.');
        }

        $this->binds['favicon'] = $faviconData;
        return $this;
    }

    public function addMeta(array $metaParams)
    {
        $this->binds['meta'][] = $metaParams;
        return $this;
    }

    public function bindView($label, InterfaceView $view)
    {
        if (in_array($label, $this->systemLabels)) {
            throw new Exception("Метка \"{$label}\" является системной, её нельзя использовать. Системные метки: " . implode(',', $this->systemLabels));
        }
        $this->binds[$label] = $view;

        return $this;
    }

    public function bindData($label, $data)
    {
        if (in_array($label, $this->systemLabels)) {
            throw new Exception("Метка \"{$label}\" является системной, её нельзя использовать. Системные метки: " . implode(',', $this->systemLabels));
        }
        $this->binds[$label] = $data;

        return $this;
    }

    public function setTitle($title)
    {
        $this->binds['title'] = $title;
        return $this;
    }

    public function unbind($label)
    {
        unset($this->binds[$label]);
    }

    public function render()
    {
        if (NotificationLog::instance()->hasProblems()) {
            $nLog = NotificationLog::instance();
            $errorsView = new ViewErrors();
            $errorsView->messages = $nLog->getErrors() + $nLog->getNotices() + $nLog->getWarnings();
            $this->bindView('content', $errorsView);
        }

        if ($this->currentFrameName == '') {
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

    protected function clearLabel($label)
    {
        $this->frameContent = str_replace("<!--label[{$label}]-->", '', $this->frameContent);
    }

    protected function applyBind($label)
    {
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
            foreach ($this->binds[$label] as $jsData) {
                $data = [];
                foreach ($jsData['data'] as $name => $value) {
                    $data[] = "{$name}=\"{$value}\"";
                }
                $js[] = "<script" . (!empty($data) ? ' ' . implode(' ', $data) : '') . " type=\"text/javascript\" src=\"{$jsData['path']}\"></script>";
            }
            $content = implode("\n", $js);
        } elseif ($label == 'meta') {
            $meta = [];
            foreach ($this->binds[$label] as $metaData) {
                $metaItem = [];
                foreach ($metaData as $key => $value) {
                    $metaItem[] = "{$key}=\"{$value}\"";
                }
                $meta[] = '<meta ' . implode(' ', $metaItem) . " />\n";
            }
            $content = implode("\n", $meta);
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