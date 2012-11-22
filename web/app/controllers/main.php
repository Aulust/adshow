<?php

$app->get('/', function () use($app) {
    LayoutView::set_layout('layout/layout.tpl.php');
    $app->render('main/main.tpl.php');
});

$app->notFound(function () use ($app) {
    LayoutView::set_layout('layout/layout.tpl.php');
    $app->render('main/404.tpl.php');
});

$app->error(function () use ($app, $databaseService) {
    $databaseService->rollBackTransaction();
    LayoutView::set_layout('layout/layout.tpl.php');
    $app->render('main/500.tpl.php');
});
