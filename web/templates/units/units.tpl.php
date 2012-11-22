<div class="row-fluid">
  <h1>Units</h1>
  <p>Active units</p>
</div>
<div class="row-fluid">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Title</th>
        <th>Type</th>
        <th>Shows</th>
        <th>Clicks</th>
        <th>Time limit</th>
        <th>Status</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <? foreach($availableUnits as $availableUnit) : ?>
      <tr>
        <td><?= $availableUnit->name ?></td>
        <td><?= $availableUnit->title ?></td>
        <td><?= $availableUnit->type ?></td>
        <td><?= $availableUnit->shows ?></td>
        <td><?= $availableUnit->clicks ?></td>
        <td><?= ($availableUnit->time_limit == null ? 'No' : $availableUnit->time_limit) ?></td>
        <td class="unit-<?= $availableUnit->status ?>"><?= $availableUnit->status ?></td>
        <td>
          <a href="/units/<?= $availableUnit->name ?>" class="btn btn-mini"><i class="icon-play"></i>View</a>
          <a href="/units/<?= $availableUnit->name ?>/edit" class="btn btn-mini"><i class="icon-edit"></i>Edit</a>
          <a href="/units/<?= $availableUnit->name ?>/delete" class="btn btn-mini btn-danger"><i class="icon-trash"></i>Delete</a>
        </td>
      </tr>
      <? endforeach ?>
    </tbody>
  </table>
</div>
