<!DOCTYPE html>
<html lang="en">
  <? include 'header.tpl.php' ?>

  <body>
    <? include 'navbar.tpl.php' ?>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Actions</li>
              <li><a href="/units">Main</a></li>
              <? if($permissionsService->checkPermission('add unit')) : ?>
                <li <?= isset($action) && $action === 'create' ? 'class="active"' : '' ?>><a href="/add/unit">Create new</a></li>
              <? endif ?>
              <li class="nav-header">Units</li>
              <? foreach($availableUnits as $availableUnit) : ?>
                <li class="nav-controls <?= isset($unit) && $availableUnit->name == $unit->name ? 'active' : '' ?>">
                  <a href="/units/<?= $availableUnit->name ?>"><?= $availableUnit->title ?></a>
                  <div>
                    <a href="/units/<?= $availableUnit->name ?>/edit" title="Edit" class="icon-edit"></a>
                    <a href="/units/<?= $availableUnit->name ?>/delete" title="Delete" class="icon-trash"></a>
                  </div>
                </li>
              <? endforeach ?>
            </ul>
          </div>
        </div>
        <div class="span9"><?= $_html ?></div>
      </div>

      <? include 'footer.tpl.php' ?>

    </div>

    <? include 'scripts.tpl.php' ?>
  </body>
</html>
