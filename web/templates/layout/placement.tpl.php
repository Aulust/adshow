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
              <li><a href="/placements">Main</a></li>
              <? if($permissionsService->checkPermission('add placement')) : ?>
                <li <?= isset($action) && $action === 'create' ? 'class="active"' : '' ?>><a href="/add/placement">Create new</a></li>
              <? endif ?>
              <li class="nav-header">Placements</li>
              <? foreach($availablePlacements as $availablePlacement) : ?>
                <li class="nav-controls <?= isset($placement) && $availablePlacement->name == $placement->name ? 'active' : '' ?>">
                  <a href="/placements/<?= $availablePlacement->name ?>"><?= $availablePlacement->title ?></a>
                  <div>
                    <a href="/placements/<?= $availablePlacement->name ?>/edit" title="Edit" class="icon-edit"></a>
                    <a href="/placements/<?= $availablePlacement->name ?>/delete" title="Delete" class="icon-trash"></a>
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
