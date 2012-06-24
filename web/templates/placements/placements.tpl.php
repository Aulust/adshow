<div class="row-fluid">
  <h1>Placements</h1>
  <p>All placements</p>
</div>
<div class="row-fluid">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Title</th>
        <th>Size</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <? foreach($availablePlacements as $availablePlacement) : ?>
      <tr>
        <td><?= $availablePlacement->name ?></td>
        <td><?= $availablePlacement->title ?></td>
        <td><?= $availablePlacement->width ?>x<?= $availablePlacement->height ?></td>
        <td>
          <a href="/placements/<?= $availablePlacement->name ?>" class="btn btn-mini"><i class="icon-play"></i>View</a>
          <a href="/placements/<?= $availablePlacement->name ?>/edit" class="btn btn-mini"><i class="icon-edit"></i>Edit</a>
          <a href="/placements/<?= $availablePlacement->name ?>/delete" class="btn btn-mini btn-danger"><i class="icon-trash"></i>Delete</a>
        </td>
      </tr>
      <? endforeach ?>
    </tbody>
  </table>
</div>
