<?php


namespace SFramework\Views\DataGrid;


class ViewSwitch extends ViewDecoration {

    public function currentRender() {
        $isSwitchOn = $this->value ? true : false;
        ?>
        <span class="label label-<?= $isSwitchOn ? 'success' : 'default' ?>">
            <?= $isSwitchOn ? 'Да' : 'Нет' ?>
        </span>
        <?
    }

} 