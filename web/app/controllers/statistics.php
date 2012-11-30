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
    $start_date = $statisticDao->getStartDate($name);

    LayoutView::set_layout('layout/statistic.tpl.php');
    $app->render('statistics/view.tpl.php', array('units' => $units, 'unit' => $unit, 'start_date' => $start_date));
});

$app->post('/statistics/:name', function ($name) use($app, $unitDao, $statisticDao, $validationService, $permissionsService) {
    if(!$permissionsService->checkPermission('view statistics')) {
        $app->notFound();
    }
    $start_date = date("Y-m-d",strtotime($_POST['start_date']));
    $end_date = strtotime($_POST['end_date']);
    if($end_date == false)
        $end_date = date("Y-m-d");
    else 
        $end_date = date("Y-m-d", $end_date);
    $statistic_show = $_POST['statistic_show'];
 
    $units = $unitDao->getAll();
    if($units === null) {
        $app->error();
    }
            
    if(!$res = $statisticDao->getStatistic($name, $start_date, $end_date, $statistic_show)) {
        $unit = $unitDao->get($name);
        LayoutView::set_layout('layout/statistic.tpl.php');
        $app->render('statistics/view.tpl.php', array('units' => $units, 'unit' => $unit, 'start_date' => $start_date, 'error' => 'not_found'));
    }
    else if(isset($_POST['export_stat'])) {
            $helpLine = $statisticDao->getStatisticSelect($statistic_show);
            $statArray = array($helpLine);
            foreach ($res as $r) {
                $statArray[] = join(',', $r);
            }
            $stat = join("\r\n", $statArray);
            
            $res = $app->response();
            $res['Content-Type'] = 'application/CSV';
            $res->write($stat);
        
    }
    else {
        $clicksArray = array();
        $showsArray = array();
        $shows_sum = 0;
        $clicks_sum = 0;
        foreach($res as $r) {
            if(isset($r['shows'])) {
                $showsArray[] = array($r['date'], $r['shows']);
                $shows_sum += $r['shows'];
            }
            if(isset($r['clicks'])) {
                $clicksArray[] = array($r['date'], $r['clicks']);
                $clicks_sum += $r['clicks'];
            }
        }
        $stat=array('shows'=>$showsArray, 'clicks'=>$clicksArray, 'shows_sum'=>$shows_sum, 'clicks_sum'=>$clicks_sum);

        LayoutView::set_layout('layout/statistic.tpl.php');
        $app->render('statistics/stat.tpl.php', array('stat' => $stat, 'units' => $units, 'statistic_show' => $statistic_show));    
    }
});

