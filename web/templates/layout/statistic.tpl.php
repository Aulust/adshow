<!DOCTYPE html>
<html lang="en">
  <? include 'header.tpl.php' ?>

  <body>
    <? include 'navbar.tpl.php' ?>
	
    <? include 'scripts.tpl.php' ?>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Units</li>
              <? foreach($units as $availableUnit) : ?>
                <li class="nav-controls <?= isset($unit) && $availableUnit->name == $unit->name ? 'active' : '' ?>">
                  <a href="/statistics/<?= $availableUnit->name ?>"><?= $availableUnit->title ?></a>
                </li>
              <? endforeach ?>
            </ul>
          </div>
        </div>
        <div class="span9"><?= $_html ?></div>
      </div>

      <? include 'footer.tpl.php' ?>

    </div>

  </body>
</html>
