<?php

$app->get('/statistics', function () use($app, $unitDao, $permissionsService) {
    if(!$permissionsService->checkPermission('view statistics')) {
        $app->notFound();
    }

    $Units = $unitDao->getAll();
    $nUnits = $unitDao->getInActive();
    if($Units === null) {
        $app->error();
    }

    LayoutView::set_layout('layout/statistic.tpl.php');
    $app->render('statistics/units.tpl.php', array('Units' => $Units, 'nUnits' => $nUnits));
});

$app->get('/statistics/:name', function ($name) use($app, $unitDao, $StatisticDao, $validationService, $permissionsService) {
    if(!$validationService->checkName($name) || !$permissionsService->checkPermission('view statistics')) {
       $app->notFound();
    }

    $Units = $unitDao->getAll();
    $nUnits = $unitDao->getInActive();
    $unit = $unitDao->get($name);
    if($unit === null) {
        $app->notFound();
    }
    $sdate = $StatisticDao->getStartDate($name);
    $unit->start_date = $sdate[0];
    
    $availableUnits = $unitDao->getAll();
    if($availableUnits === null) {
        $app->error();
    }

    LayoutView::set_layout('layout/statistic.tpl.php');
    $app->render('statistics/view.tpl.php', array('Units' => $Units, 'nUnits' => $nUnits, 'unit' => $unit));
});

$app->post('/statistics/:name', function ($name) use($app, $unitDao, $StatisticDao, $validationService, $permissionsService) {
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
        $StatisticDao->uploadStatistic($name, $start_date, $end_date, $statistic_show);
    else 
        $stat = $StatisticDao->showStatistic($name, $start_date, $end_date, $statistic_show);
    
    if($stat) {
        $Units = $unitDao->getAll();
        $nUnits = $unitDao->getInActive();
        if($Units === null) {
            $app->error();
        }
        LayoutView::set_layout('layout/statistic.tpl.php');
        $app->render('statistics/stat.tpl.php', array('stat' => $stat, 'Units' => $Units, 'nUnits' => $nUnits, 'statistic_show' => $statistic_show));    
    }
    else {
        $app->error();
    }
    
});

