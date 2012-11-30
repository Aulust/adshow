<div class="row-fluid">
  <h1>Units</h1>
  <p>All units</p>
</div>
<div class="row-fluid">
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
      <? foreach($availableUnits as $availableUnit) : ?>
      <tr>
        <td><?= $availableUnit->name ?></td>
        <td><?= $availableUnit->title ?></td>
        <td><?= $availableUnit->type ?></td>
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
