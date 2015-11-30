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
        ?>
        <ul>
            <li>
                <a href="<?= $this->currentURL ?>&<?= $this->parameterName ?>=<?= ((int)$this->currentPage <= 1 ? 1 : $this->currentPage - 1) ?>">
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
                <a href="<?= $this->currentURL ?>&<?= $this->parameterName ?>=<?= ((int)$this->currentPage >= $this->pagesCount ? $this->pagesCount : $this->currentPage + 1) ?>">
                    <span>&raquo;</span>
                </a>
            </li>
        </ul>
        <?
    }
}