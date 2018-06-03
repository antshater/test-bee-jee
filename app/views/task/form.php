<? \Core\App::registerJs('create-task.js') ?>
<? /** @var $task \App\Models\Task */ ?>
<!--Задача существует только в случае если ее просматривает админ-->
<h1><?= $task->exists() ? 'Задача #' . $task->id : 'Новая задача' ?></h1>
<form
        id="edit-form"
        class="edit-mode"
        method="post"
        enctype="multipart/form-data"
>
    <div class="form-group">
        <label for="user_name">Имя пользователя:</label>
        <? if ($task->exists()): ?>
            <div><?= $task->user_name ?></div>
        <? else: ?>
            <input id="user_name" required maxlength="20" type="text" name="task[user_name]" class="form-control"/>
            <div class="preview user_name"></div>
        <? endif; ?>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <? if ($task->exists()): ?>
            <div><?= $task->email ?></div>
        <? else: ?>
            <input id="email" required type="email" name="task[email]" class="form-control"/>
            <div class="preview email"></div>
        <? endif; ?>
    </div>
    <div class="form-group">
        <label for="description">Описание:</label>
        <textarea
                id="description"
                required
                name="task[description]"
                class="form-control"
        ><?= $task->description ?></textarea>
        <div class="preview description"></div>
    </div>
    <div class="form-group">
        <? if ($task->exists()): ?>
            <img alt="файл для задачи #<? $task->id ?>" src="<?= $task->image ?>"/>
        <? else: ?>
            <input type="file" name="file" accept=".jpg,.jpeg,.gif,.png" class="form-control-file"/>
            <div class="preview file"></div>
        <? endif; ?>
    </div>
    <? if ($task->exists()): ?>
        <div class="form-check">
            <input id="completed"
                   type="checkbox"
                   class="form-check-input"
                   name="task[completed]"
                   value="1"
                <?= $task->completed ? 'checked' : '' ?>
            />
            <label for="completed">Задача выполнена</label>
        </div>
    <? endif; ?>
    <button class="btn btn-success" type="submit"><?= $task->exists() ? 'Сохранить' : 'Создать' ?></button>
    <? if (!$task->exists()): ?>
        <button class="btn btn-info" id="preview-btn" type="button">Предварительный просмотр</button>
    <? endif; ?>
</form>
