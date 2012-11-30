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
    $startDate = $statisticDao->getStartDate($name);

    LayoutView::set_layout('layout/statistic.tpl.php');
    $app->render('statistics/view.tpl.php', array('units' => $units, 'unit' => $unit, 'startDate' => $startDate));
});

$app->post('/statistics/:name', function ($name) use($app, $unitDao, $statisticDao, $validationService, $permissionsService) {
    if(!$permissionsService->checkPermission('view statistics')) {
        $app->notFound();
    }
    $startDate = date("Y-m-d",strtotime($_POST['startDate']));
    $endDate = strtotime($_POST['endDate']);
    if($endDate == false)
        $endDate = date("Y-m-d");
    else 
        $endDate = date("Y-m-d", $endDate);
    $statisticShow = $_POST['statisticShow'];
 
    $units = $unitDao->getAll();
    if($units === null) {
        $app->error();
    }
            
    if(!$res = $statisticDao->getStatistic($name, $startDate, $endDate, $statisticShow)) {
        $unit = $unitDao->get($name);
        LayoutView::set_layout('layout/statistic.tpl.php');
        $app->render('statistics/view.tpl.php', array('units' => $units, 'unit' => $unit, 'startDate' => $startDate, 'error' => 'not_found'));
    }
    else if(isset($_POST['exportStat'])) {
        $helpLine = $statisticDao->getStatisticSelect($statisticShow);
        $statArray = array($helpLine);
        foreach ($res as $r) {
            $statArray[] = join(',', $r);
        }
        $stat = join("\r\n", $statArray);
            
        $res = $app->response();
        $res['Content-Type'] = 'application/CSV';
        $res->write($stat);
        
    } else {
        $clicksArray = array();
        $showsArray = array();
        $showsSum = 0;
        $clicksSum = 0;
        foreach($res as $r) {
            if(isset($r['shows'])) {
                $showsArray[] = array($r['date'], $r['shows']);
                $showsSum += $r['shows'];
            }
            if(isset($r['clicks'])) {
                $clicksArray[] = array($r['date'], $r['clicks']);
                $clicksSum += $r['clicks'];
            }
        }
        $stat=array('shows'=>$showsArray, 'clicks'=>$clicksArray, 'showsSum'=>$showsSum, 'clicksSum'=>$clicksSum);

        LayoutView::set_layout('layout/statistic.tpl.php');
        $app->render('statistics/stat.tpl.php', array('stat' => $stat, 'units' => $units, 'statisticShow' => $statisticShow));    
    }
});

