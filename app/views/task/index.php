<?php

use \Core\Helpers\Html;
use \Core\Database\DB;

?>
<h1>Список задач</h1>
<div class="form-group">
    <a href="/task/create" class="btn btn-success">Добавить</a>
</div>
<? /** @var $listView \App\Widgets\ListView */ ?>
<? if (count($listView->items())) : ?>
    <table class="table tasks-table">
        <thead>
        <tr>
            <? foreach ($listView->columns() as $column): ?>
                <? /** @var $column \App\Widgets\ListViewColumn */ ?>
                <th>
                    <?= $column->render() ?>
                </th>
            <? endforeach; ?>
            <? if (\Core\Auth::isAdmin()): ?>
                <th></th>
            <? endif; ?>
        </tr>
        </thead>
        <tbody>
        <? foreach ($listView->items() as $task): ?>
            <? /** @var $task \App\Models\Task */ ?>
            <tr>
                <td><?= $task->user_name ?></td>
                <td><?= $task->email ?></td>
                <td><?= $task->description ?></td>
                <td>
                    <? if ($task->completed): ?>
                        <span class="badge badge-info">Выполнена</span>
                    <? else: ?>
                        <span class="badge badge-warning">Не выполнена</span>
                    <? endif; ?>
                </td>
                <? if (\Core\Auth::isAdmin()): ?>
                    <td>
                        <a class="fas fa-edit" href="/task/edit?id=<?= $task->id ?>"></a>
                    </td>
                <? endif; ?>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>
    <ul class="pagination">
        <? foreach ($listView->pagination() as $page): ?>
            <li class="page-item <?= $page['active'] ? 'active' : '' ?>">
                <?= Html::a('/', $page['number'], ['page' => $page['number']], ['class' => 'page-link']) ?>
            </li>
        <? endforeach; ?>
    </ul>
<? else: ?>
    <div class="alert alert-info">
        Не создано ни одной задачи
    </div>
<? endif; ?>
