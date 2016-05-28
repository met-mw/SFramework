<?php
namespace SFramework\Views;


use SFramework\Classes\CoreFunctions;
use SFramework\Classes\DataGrid;
use SFramework\Classes\View;

class ViewDataGrid extends View
{

    /** @var DataGrid */
    public $DataGrid;

    public function currentRender() {
        ?>
        <form method="get">
            <table border="1">
                <caption><?= $this->DataGrid->getCaption() ?></caption>
                <thead>
                    <tr>
                        <? if ($this->DataGrid->hasGroupActions()): ?>
                            <th>
                                <input type="checkbox" />
                            </th>
                        <? endif; ?>
                        <? foreach ($this->DataGrid->getHeaders() as $header): ?>
                            <th <?= $header->buildAttributes() ?>>
                                <?= $header->getDisplayName() ?>
                            </th>
                        <? endforeach; ?>
                        <th>
                            Действия
                        </th>
                    </tr>
                    <? if ($this->DataGrid->hasFiltered()): ?>
                        <tr>
                            <? if ($this->DataGrid->hasGroupActions()): ?>
                                <th></th>
                            <? endif; ?>
                            <? foreach ($this->DataGrid->getHeaders() as $header): ?>
                                <th>
                                    <input type="text" name="filter-<?= $header->getKey() ?>" value="<?= $header->getFilterValue() ?>"/>
                                </th>
                            <? endforeach; ?>
                            <th>
                                <input name="filter" type="submit" value="Фильтровать"/>
                            </th>
                        </tr>
                    <? endif; ?>
                </thead>
                <tbody>
                    <? foreach ($this->DataGrid->getData() as $row): ?>
                        <tr>
                            <? if ($this->DataGrid->hasGroupActions()): ?>
                                <th>
                                    <input name="selected-<?= $this->DataGrid->getKey() ?>" type="checkbox" />
                                </th>
                            <? endif; ?>
                            <? foreach ($this->DataGrid->getHeaders() as $header): ?>
                                <td><?= $row[$header->getKey()] ?></td>
                            <? endforeach; ?>
                            <td>
                                <? foreach ($this->DataGrid->getActions() as $action): ?>
                                    <a name="action-<?= $action->getName() ?>-<?= $row[$this->DataGrid->getKey()] ?>" href="<?= CoreFunctions::addGETParamToURI($action->getURI(), $action->getParamName(), $row[$this->DataGrid->getKey()]) ?>">
                                        <span class="<?= $action->buildAttributes() ?>" title="<?= $action->getTitle() ?>"><?= $action->getDisplayName() ?></span>
                                    </a>
                                <? endforeach; ?>
                            </td>
                        </tr>
                    <? endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="<?= (count($this->DataGrid->getHeaders()) + ($this->DataGrid->hasGroupActions() ? 2 : 1)) ?>">
                            Групповые операции:&nbsp;
                            <? foreach ($this->DataGrid->getGroupActions() as $action): ?>
                                <button name="action-<?= $action->getName() ?>-selected" formmethod="post" type="submit" formaction="<?= $action->buildGroupURI() ?>" >
                                    <span class="<?= $action->buildAttributes() ?>" title="<?= $action->getTitle() ?>"><?= $action->getDisplayName() ?></span>
                                </button>
                            <? endforeach; ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
        <?
    }

}