<?php

use App\Controllers\MainController;

/**
 * mount controller
 */
$app->mount('/', $app[MainController::class]);
