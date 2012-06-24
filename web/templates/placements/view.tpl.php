<div class="row-fluid">
  <h1><?= $placement->title ?></h1>
</div>
<div class="row-fluid">
  <dl class="dl-horizontal">
    <dt>Name</dt>
    <dd><?= $placement->name ?></dd>
  </dl>
  <h4>Units</h4>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Title</th>
        <th>Type</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <? foreach($showingUnits as $showingUnit) : ?>
      <tr>
        <td><?= $showingUnit->name ?></td>
        <td><?= $showingUnit->title ?></td>
        <td><?= $showingUnit->type ?></td>
        <td>
          <a href="/units/<?= $showingUnit->name ?>" class="btn btn-mini"><i class="icon-play"></i>View</a>
        </td>
      </tr>
      <? endforeach ?>
    </tbody>
  </table>
  <a href="/placements/<?= $placement->name ?>/edit" class="btn btn-mini"><i class="icon-edit"></i>Edit</a>
  <a href="/placements/<?= $placement->name ?>/delete" class="btn btn-mini btn-danger"><i class="icon-trash"></i>Delete</a>
</div>
