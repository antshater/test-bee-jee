<div class="col-sm-4 offset-sm-4">
    <h1>Авторизация</h1>
    <? if (\Core\Session::instance()->get('auth_failed')): ?>
        <div class="alert alert-danger">
            Логин или пароль неверные
        </div>
    <? endif; ?>
    <form method="post">
        <div class="form-group">
            <label>Логин</label>
            <input type="text" name="auth[login]" class="form-control"/>
        </div>
        <div class="form-group">
            <label>Пароль</label>
            <input type="password" name="auth[password]" class="form-control"/>
        </div>
        <div class="form-group">
            <button class="btn btn-success float-right" type="submit">
                Войти
            </button>
        </div>
    </form>
</div>
