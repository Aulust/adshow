<div class="row-fluid">
  <h1><?= $unit->title ?></h1>
</div>
<div class="row-fluid">
  <dl class="dl-horizontal">
    <dt>Name</dt>
    <dd><?= $unit->name ?></dd>
    <dt>Type</dt>
    <dd><?= $unit->type ?></dd>
    <dt>Views</dt>
    <dd><?= $unit->shows ?></dd>
    <dt>views_limit</dt>
    <dd><?= $unit->views_limit ?></dd>
    <dt>Clicks</dt>
    <dd><?= $unit->clicks ?></dd>
    <dt>clicks_limit</dt>
    <dd><?= $unit->clicks_limit ?></dd>
    <dt>time_limit</dt>
    <dd><?= $unit->time_limit ?></dd>
    <? if($unit->type == 'image') : ?>
    <dt>Link</dt>
    <dd><a href="<?= $unit->link ?>"><?= $unit->link ?></a></dd>
    <dt>Image</dt>
    <dd><img src="<?= $unit->imageUrl ?>"/></dd>
    <? endif ?>

    <? if($unit->type == 'html') : ?>
    <dt>Html</dt>
    <dd>
      <pre><?= htmlspecialchars($unit->html) ?></pre>
    </dd>
    <? endif ?>
  </dl>
  <a href="/units/<?= $unit->name ?>/edit" class="btn btn-mini"><i class="icon-edit"></i>Edit</a>
  <? if($unit->status == 'active') : ?><a href="/units/<?= $unit->name ?>/delete" class="btn btn-mini btn-danger"><i class="icon-trash"></i>Delete</a><? endif ?>
  <? if($unit->status == 'delete') : ?><a href="/units/<?= $unit->name ?>/activate" class="btn btn-mini btn-activate">Activate</a><? endif ?>
</div>
