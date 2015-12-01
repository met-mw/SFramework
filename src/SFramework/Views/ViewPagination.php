<?php
namespace SFramework\Views;


use SFramework\Classes\View;

class ViewPagination extends View {

    /** @var int */
    public $pagesCount;
    /** @var int */
    public $currentPage;
    /** @var string */
    public $currentURL;
    /** @var string */
    public $parameterName;

    public function __construct() {
        $this->optional[] = 'currentPage';
    }

    public function currentRender() {
        $isFirst = (int)$this->currentPage <= 1;

        $previousUrl = '#';
        if (!$isFirst) {
            $previousUrl = $this->currentURL . (strpos($this->currentURL, '?') === false ? '?' : '&') . "{$this->parameterName}=" . ($this->currentPage - 1);
        }

        $isLast = (int)$this->currentPage >= $this->pagesCount;
        $nextUrl = '#';
        if (!$isLast) {
            $nextUrl = $this->currentURL . (strpos($this->currentURL, '?') === false ? '?' : '&') . "{$this->parameterName}=" . ($this->currentPage + 1);
        }

        ?>
        <ul>
            <li>
                <a href="<?= $previousUrl ?>">
                    <span>&laquo;</span>
                </a>
            </li>
            <? for ($i = 1; $i < $this->pagesCount; $i++): ?>
                <li>
                    <? if ($i == $this->currentPage): ?>
                        <span><?= $this->currentPage ?></span>
                    <? else: ?>
                        <a href="<?= $this->currentURL ?>&<?= $this->parameterName ?>=<?= $i ?>"><?= $i ?></a>
                    <? endif; ?>
                </li>
            <? endfor; ?>
            <li>
                <a href="<?= $nextUrl ?>">
                    <span>&raquo;</span>
                </a>
            </li>
        </ul>
        <?
    }
}