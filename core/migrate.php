<?php

require __DIR__ . '/../vendor/autoload.php';

$sql = file_get_contents(\Core\App::path('migration.sql'));
\Core\Database\DB::instance()->queryRaw($sql);
