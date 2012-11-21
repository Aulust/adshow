<div class="row-fluid">
  <h1>Units</h1>
  <p>Active units</p>
</div>
<div class="row-fluid">
  <table class="table table-striped">
    <thead>
      <tr>
        <th></th>
        <th>Name</th>
        <th>Statistic</th>
      </tr>
    </thead>
    <tbody>
      <? foreach($Units as $availableUnit) : ?>
      <tr>
        <td><?= $availableUnit->type == 'image' ? '<img class="statisticImage" src="' .$availableUnit->image_url. '">' : '' ?></td>
        <td><?= $availableUnit->name ?></td>
        <td><a href="/statistics/<?= $availableUnit->name ?>" class="btn btn-mini"><i class="icon-camera"></i>OPEN</a></td>
      </tr>
      <? endforeach ?>
    </tbody>
  </table>
</div>
<div class="row-fluid">
  <p>Deleted units</p>
</div>
<div class="row-fluid">
  <table class="table table-striped">
    <tbody>
      <? foreach($nUnits as $availableUnit) : ?>
      <tr>
        <td><?= $availableUnit->type == 'image' ? '<img class="statisticImage" src="' .$availableUnit->image_url. '">' : '' ?></td>
        <td><?= $availableUnit->name ?></td>
        <td><a href="/statistics/<?= $availableUnit->name ?>" class="btn btn-mini"><i class="icon-camera"></i>OPEN</a></td>
      </tr>
      <? endforeach ?>
    </tbody>
  </table>
</div>
