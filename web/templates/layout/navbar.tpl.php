<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      <a class="brand" href="/">AD Show</a>
      <div class="btn-group pull-right">
        <span class="btn">
          <i class="icon-user"></i> <?= htmlspecialchars($_SERVER['PHP_AUTH_USER']) ?>
        </span>
      </div>
      <div class="nav-collapse">
        <ul class="nav">
          <? if($permissionsService->checkPermission('view units')) : ?>
            <li class="<?= isset($availableUnits) ? 'active' : '' ?>"><a href="/units">Units</a></li>
          <? endif ?>
          <? if($permissionsService->checkPermission('view placements')) : ?>
            <li class="<?= isset($availablePlacements) ? 'active' : '' ?>"><a href="/placements">Placements</a></li>
          <? endif ?>
          <? if($permissionsService->checkPermission('view statistics')) : ?>
            <li class="<?= isset($units) ? 'active' : '' ?>"><a href="/statistics">Statistics</a></li>
          <? endif ?>
        </ul>
      </div>
    </div>
  </div>
</div>
