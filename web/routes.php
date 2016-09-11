<?php

declare(strict_types=1);

use App\Http\Controllers\MainController;

/*
 * mount controller
 */
$app->mount('/', $app[MainController::class]);
