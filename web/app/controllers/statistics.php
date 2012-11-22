<?php

$app->get('/statistics', function () use($app, $unitDao, $permissionsService) {
    if(!$permissionsService->checkPermission('view statistics')) {
        $app->notFound();
    }

    $units = $unitDao->getAll();
    if($units === null) {
        $units = array();
    }

    LayoutView::set_layout('layout/statistic.tpl.php');
    $app->render('statistics/units.tpl.php', array('units' => $units));
});

$app->get('/statistics/:name', function ($name) use($app, $unitDao, $statisticDao, $validationService, $permissionsService) {
    if(!$validationService->checkName($name) || !$permissionsService->checkPermission('view statistics')) {
       $app->notFound();
    }

    $units = $unitDao->getAll();
    $unit = $unitDao->get($name);
    if($unit === null) {
        $app->notFound();
    }
    $sdate = $statisticDao->getStartDate($name);
    $start_date = $sdate[0];

    LayoutView::set_layout('layout/statistic.tpl.php');
    $app->render('statistics/view.tpl.php', array('units' => $units, 'unit' => $unit, 'start_date' => $start_date));
});

$app->post('/statistics/:name', function ($name) use($app, $unitDao, $statisticDao, $validationService, $permissionsService) {
    if(!$permissionsService->checkPermission('view statistics')) {
        $app->notFound();
    }
    $start_date = date("Y-m-d",strtotime($_POST['start_date']));
    $end_date = date("Y-m-d",strtotime($_POST['end_date']));
    if($end_date == '1970-01-01')
        $end_date = $date("Y-m-d");
    
    switch($_POST['statistic_show']) {
        case 'all': $statistic_show = 'all'; break;
        case 'shows': $statistic_show = 'shows'; break;
        case 'clicks': $statistic_show = 'clicks'; break;
        default: $statistic_show = 'all';
    }
    
    if(isset($_POST['download_stat'])) 
        $statisticDao->uploadStatistic($name, $start_date, $end_date, $statistic_show);
    else 
        $stat = $statisticDao->showStatistic($name, $start_date, $end_date, $statistic_show);
    
    if($stat) {
        $units = $unitDao->getAll();
        if($units === null) {
            $units = array();
        }
        LayoutView::set_layout('layout/statistic.tpl.php');
        $app->render('statistics/stat.tpl.php', array('stat' => $stat, 'units' => $units, 'statistic_show' => $statistic_show));    
    }
    else {
        $app->error();
    }
    
});

