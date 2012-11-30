<div class="row-fluid">
  <h1><?= $unit->title ?></h1>
</div>
<div class="row-fluid">
  <form method="POST">
  <dl class="dl-horizontal">
    <dt>Start date</dt>
    <dd><input type="text" name="startDate" id="startDate" class="input-xlarge" value="<?= htmlspecialchars($startDate) ?>"></dd>
    <dt>End date</dt>
    <dd><input type="text" name="endDate" id="endDate" class="input-xlarge" value="<?= date("Y-m-d"); ?>"></dd>
    <dt>Show</dt>
    <dd>
        <select name="statisticShow">
            <option value="all">all
            <option value="shows">shows
            <option value="clicks">clicks
        </select>
    </dd>
    <dd>
    <input type="submit" value="View Statistic" name="viewStat">
    <input type="submit" value="Export Statistic" name="exportStat">
    </dd>
    <?= (isset ($error) && $error == 'not_found' ? '<dd class="error">No statistic</dd>' : '')?>
  </dl>
  </form>
</div>
