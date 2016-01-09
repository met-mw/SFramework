<?php
namespace SFramework\Views;


use SFramework\Classes\DataGrid;
use SFramework\Classes\View;

class ViewDataGrid extends View {

    /** @var DataGrid */
    public $dataGrid;

    public function currentRender() {
        ?>
        <form method="get">
            <table border="1">
                <caption><?= $this->dataGrid->getCaption() ?></caption>
                <thead>
                    <tr>
                        <? if ($this->dataGrid->hasGroupActions()): ?>
                            <th>
                                <input type="checkbox" />
                            </th>
                        <? endif; ?>
                        <? foreach ($this->dataGrid->getHeaders() as $header): ?>
                            <th <?= $header->buildAttributes() ?>>
                                <?= $header->getDisplayName() ?>
                            </th>
                        <? endforeach; ?>
                        <th>
                            Действия
                        </th>
                    </tr>
                    <? if ($this->dataGrid->hasFiltered()): ?>
                        <tr>
                            <? if ($this->dataGrid->hasGroupActions()): ?>
                                <th></th>
                            <? endif; ?>
                            <? foreach ($this->dataGrid->getHeaders() as $header): ?>
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
                    <? foreach ($this->dataGrid->getData() as $row): ?>
                        <tr>
                            <? if ($this->dataGrid->hasGroupActions()): ?>
                                <th>
                                    <input name="selected-<?= $this->dataGrid->getKey() ?>" type="checkbox" />
                                </th>
                            <? endif; ?>
                            <? foreach ($this->dataGrid->getHeaders() as $header): ?>
                                <td><?= $row[$header->getKey()] ?></td>
                            <? endforeach; ?>
                            <td>
                                <? foreach ($this->dataGrid->getActions() as $action): ?>
                                    <a name="action-<?= $action->getName() ?>-<?= $row[$this->dataGrid->getKey()] ?>" href="<?= $action->buildURI($row[$this->dataGrid->getKey()]) ?>">
                                        <span class="<?= $action->buildClasses() ?>" title="<?= $action->getTitle() ?>"><?= $action->getDisplayName() ?></span>
                                    </a>
                                <? endforeach; ?>
                            </td>
                        </tr>
                    <? endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="<?= (count($this->dataGrid->getHeaders()) + ($this->dataGrid->hasGroupActions() ? 2 : 1)) ?>">
                            Групповые операции:&nbsp;
                            <? foreach ($this->dataGrid->getGroupActions() as $action): ?>
                                <button name="action-<?= $action->getName() ?>-selected" formmethod="post" type="submit" formaction="<?= $action->buildURI() ?>" >
                                    <span class="<?= $action->buildClasses() ?>" title="<?= $action->getTitle() ?>"><?= $action->getDisplayName() ?></span>
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