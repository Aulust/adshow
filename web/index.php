<?php

require 'Slim/Slim.php';
require 'Slim/Middleware/SessionCookie.php';
require 'app/lib/LayoutView.php';

require 'app/model/Unit.php';
require 'app/model/Placement.php';
require 'app/dao/UnitDao.php';
require 'app/dao/StatisticDao.php';
require 'app/dao/PlacementDao.php';
require 'app/dao/BindingDao.php';
require 'app/dao/FileDao.php';
require 'app/service/ConfigService.php';
require 'app/service/DatabaseService.php';
require 'app/service/UnitErrors.php';
require 'app/service/PlacementErrors.php';
require 'app/service/ValidationService.php';
require 'app/service/PermissionsService.php';
require 'app/service/FileService.php';

$configService = new ConfigService();
$fileService = new FileService();
$databaseService = new DatabaseService($configService->getConfig());
$validationService = new ValidationService($configService->getConfig());
$permissionsService = new PermissionsService();

$unitDao = new UnitDao($databaseService->getConnection(), $configService->getConfig());
$statisticDao = new StatisticDao($databaseService->getConnection());
$placementDao = new PlacementDao($databaseService->getConnection());
$bindingDao = new BindingDao($databaseService->getConnection());
$fileDao = new FileDao($databaseService->getConnection());

$layoutView = new LayoutView();
$layoutView->set_permissions_service($permissionsService);
$app = new Slim(array('view' => $layoutView));
$app->add(new Slim_Middleware_SessionCookie(array(
    'expires' => '20 minutes',
    'path' => '/',
    'httponly' => true,
    'name' => 'adshow_session'
)));

require 'app/controllers/main.php';
require 'app/controllers/units.php';
require 'app/controllers/placements.php';
require 'app/controllers/statistics.php';
require 'app/controllers/upload.php';

$databaseService->beginTransaction();
$app->run();
$databaseService->commitTransaction();
$databaseService->disconnect();
