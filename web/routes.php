<?php

use Jowy\SilexSkeleton\Controllers\MainController;

/**
 * mount controller
 */
$app->mount('/', $app[MainController::class]);
