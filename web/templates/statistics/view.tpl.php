<div class="row-fluid">
  <h1><?= $unit->title ?></h1>
</div>
<div class="row-fluid">
  <form method="POST">
  <dl class="dl-horizontal">
    <dt>Start date</dt>
    <dd><input type="text" name="start_date" id="start_date" class="input-xlarge" value="<?= htmlspecialchars($start_date) ?>"></dd>
    <dt>End date</dt>
    <dd><input type="text" name="end_date" id="end_date" class="input-xlarge" value="<?= date("Y-m-d"); ?>"></dd>
    <dt>Show</dt>
    <dd>
        <select name="statistic_show">
            <option value="all">all
            <option value="shows">shows
            <option value="clicks">clicks
        </select>
    </dd>
    <dd>
    <input type="submit" value="View Statistic" name="view_stat">
    <input type="submit" value="Export Statistic" name="export_stat">
    </dd>
    <?= (isset ($error) && $error == 'not_found' ? '<dd class="error">No statistic</dd>' : '')?>
  </dl>
  </form>
</div>
