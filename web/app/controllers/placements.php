<?php

$app->get('/placements', function () use($app, $placementDao, $permissionsService) {
    if(!$permissionsService->checkPermission('view placements')) {
        $app->notFound();
    }

    $availablePlacements = $placementDao->getAll();
    if($availablePlacements === null) {
        $app->error();
    }

    LayoutView::set_layout('layout/placement.tpl.php');
    $app->render('placements/placements.tpl.php', array('availablePlacements' => $availablePlacements));
});

$app->get('/placements/:name', function ($name) use($app, $placementDao, $bindingDao, $validationService, $permissionsService) {
    if(!$validationService->checkName($name) || !$permissionsService->checkPermission('view placements')) {
       $app->notFound();
    }

    $placement = $placementDao->get($name);
    if($placement === null) {
        $app->notFound();
    }


    $availablePlacements = $placementDao->getAll();
    if($availablePlacements === null) {
        $app->error();
    }

    $showingUnits = $bindingDao->getUnitsByPlacement($placement);

    LayoutView::set_layout('layout/placement.tpl.php');
    $app->render('placements/view.tpl.php', array('availablePlacements' => $availablePlacements,
        'placement' => $placement, 'showingUnits' => $showingUnits));
});

$app->get('/placements/:name/edit', function ($name) use($app, $placementDao, $unitDao, $bindingDao, $validationService,
    $permissionsService) {
    if(!$validationService->checkName($name) || !$permissionsService->checkPermission('view placements') ||
       !$permissionsService->checkPermission('edit placement')) {
       $app->notFound();
    }

    $placement = $placementDao->get($name);
    if($placement == null) {
        $app->notFound();
    }

    $availablePlacements = $placementDao->getAll();
    if($availablePlacements === null) {
        $app->error();
    }

    $units = $unitDao->getAll();
    if($units === null) {
        $app->error();
    }

    $showingUnitNames = $bindingDao->getUnitNamesByPlacement($placement);
    if($showingUnitNames === null) {
        $app->error();
    }

    $token = $validationService->generateToken(ValidationService::PLACEMENT_FORM_TOKEN_NAME);

    LayoutView::set_layout('layout/placement.tpl.php');
    $app->render('placements/edit.tpl.php', array('availablePlacements' => $availablePlacements, 'action' => 'edit',
        'placement' => $placement, 'units' => $units, 'showingUnitNames' => $showingUnitNames, 'token' => $token));
});

$app->post('/placements/:name/edit', function ($name) use($app, $placementDao, $unitDao, $bindingDao, $validationService,
    $permissionsService) {
    if(!$validationService->checkName($name) || !$permissionsService->checkPermission('view placements') ||
       !$permissionsService->checkPermission('edit placement')) {
       $app->notFound();
    }

    $placement = $placementDao->get($name);
    if($placement === null) {
        $app->notFound();
    }

    $unitNames = $unitDao->getNames();
    if($unitNames === null) {
        $app->error();
    }

    $placement->title = isset($_POST['title']) ? $_POST['title'] : '';
    $showingUnitNames = isset($_POST['unit']) ? $_POST['unit'] : array();

    $token = isset($_POST['token']) ? $_POST['token'] : '';

    $errors = $validationService->validatePlacement($placement, $showingUnitNames, $unitNames, $token);

    if($errors->hasErrors()) {
        $availablePlacements = $placementDao->getAll();
        if($availablePlacements === null) {
            $app->error();
        }

        $units = $unitDao->getAll();
        if($units === null) {
            $app->error();
        }

        $token = $validationService->generateToken(ValidationService::PLACEMENT_FORM_TOKEN_NAME);

        LayoutView::set_layout('layout/placement.tpl.php');
        $app->render('placements/edit.tpl.php', array('availablePlacements' => $availablePlacements, 'action' => 'edit',
            'placement' => $placement, 'units' => $units, 'showingUnitNames' => $showingUnitNames, 'token' => $token,
            'errors' => $errors));
    } else {
        if($placementDao->update($placement) && $bindingDao->setBindingForPlacement($placement, $showingUnitNames)) {
            $app->redirect('/placements/' . $placement->name);
        } else {
            $app->error();
        }
    }
});

$app->get('/add/placement', function () use($app, $placementDao, $unitDao, $bindingDao, $validationService,
    $permissionsService) {
    if(!$permissionsService->checkPermission('view placements') || !$permissionsService->checkPermission('add placement')) {
       $app->notFound();
    }

    $availablePlacements = $placementDao->getAll();
    if($availablePlacements === null) {
        $app->error();
    }

    $units = $unitDao->getAll();
    if($units === null) {
        $app->error();
    }

    $placement = new Placement();
    $placement->setDefault();

    $token = $validationService->generateToken(ValidationService::PLACEMENT_FORM_TOKEN_NAME);

    LayoutView::set_layout('layout/placement.tpl.php');
    $app->render('placements/edit.tpl.php', array('availablePlacements' => $availablePlacements, 'action' => 'create',
        'placement' => $placement, 'units' => $units, 'showingUnitNames' => array(), 'token' => $token));
});

$app->post('/add/placement', function () use($app, $placementDao, $unitDao, $bindingDao, $validationService,
    $permissionsService) {
    if(!$permissionsService->checkPermission('view placements') ||!$permissionsService->checkPermission('edit placement')) {
       $app->notFound();
    }

    $unitNames = $unitDao->getNames();
    if($unitNames === null) {
        $app->error();
    }

    $placement = new Placement();
    $placement->name = isset($_POST['name']) ? $_POST['name'] : '';
    $placement->title = isset($_POST['title']) ? $_POST['title'] : '';
    $placement->width = isset($_POST['width']) ? $_POST['width'] : 0;
    $placement->height = isset($_POST['height']) ? $_POST['height'] : 0;
    $showingUnitNames = isset($_POST['unit']) ? $_POST['unit'] : array();

    $token = isset($_POST['token']) ? $_POST['token'] : '';

    $errors = $validationService->validatePlacement($placement, $showingUnitNames, $unitNames, $token);

    if($errors->hasErrors()) {
        $availablePlacements = $placementDao->getAll();
        if($availablePlacements === null) {
            $app->error();
        }

        $units = $unitDao->getAll();
        if($units === null) {
            $app->error();
        }

        $token = $validationService->generateToken(ValidationService::PLACEMENT_FORM_TOKEN_NAME);

        LayoutView::set_layout('layout/placement.tpl.php');
        $app->render('placements/edit.tpl.php', array('availablePlacements' => $availablePlacements, 'action' => 'create',
            'placement' => $placement, 'units' => $units, 'showingUnitNames' => $showingUnitNames, 'token' => $token,
            'errors' => $errors));
    } else {
        if($placementDao->insert($placement) && $bindingDao->setBindingForPlacement($placement, $showingUnitNames)) {
            $app->redirect('/placements/' . $placement->name);
        } else {
            $app->error();
        }
    }
});

$app->get('/placements/:name/delete', function ($name) use($app, $placementDao, $validationService, $permissionsService) {
    if(!$validationService->checkName($name) || !$permissionsService->checkPermission('view placements') ||
       !$permissionsService->checkPermission('delete placement')) {
       $app->notFound();
    }

    $placement = $placementDao->get($name);
    if($placement == null) {
        $app->notFound();
    }

    $availablePlacements = $placementDao->getAll();
    if($availablePlacements === null) {
        $app->error();
    }

    $token = $validationService->generateToken(ValidationService::PLACEMENT_FORM_TOKEN_NAME);

    LayoutView::set_layout('layout/placement.tpl.php');
    $app->render('placements/delete.tpl.php', array('availablePlacements' => $availablePlacements,
        'placement' => $placement, 'token' => $token));
});

$app->post('/placements/:name/delete', function ($name) use($app, $placementDao, $validationService, $permissionsService) {
    if(!$validationService->checkName($name) || !$permissionsService->checkPermission('view placements') ||
       !$permissionsService->checkPermission('delete placement')) {
       $app->notFound();
    }

    $placement = $placementDao->get($name);
    if($placement == null) {
        $app->notFound();
    }

    $token = isset($_POST['token']) ? $_POST['token'] : '';

    if(!$validationService->checkToken(ValidationService::PLACEMENT_FORM_TOKEN_NAME, $token)) {
        $availablePlacements = $placementDao->getAll();
        if($availablePlacements === null) {
            $app->error();
        }

        $token = $validationService->generateToken(ValidationService::PLACEMENT_FORM_TOKEN_NAME);

        LayoutView::set_layout('layout/placement.tpl.php');
        $app->render('placements/delete.tpl.php', array('availablePlacements' => $availablePlacements,
            'placement' => $placement, 'errors' => '', 'token' => $token));
    } else {
        if($placementDao->delete($placement)) {
            $app->redirect('/placements');
        } else {
            $app->error();
        }
    }
});
