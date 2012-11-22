<div class="row-fluid">
  <form class="form-horizontal" method="post">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

    <fieldset>
      <legend><?= $action === 'create' ? 'Create new placement' : 'Edit placement' ?></legend>
      <div class="alert alert-error <?= isset($errors) ? '' : 'hidden' ?>">Please fix errors and try again.</div>
      <? if($action === 'create') : ?>
        <div class="control-group <?= isset($errors) && $errors->name ? 'error' : '' ?>">
          <label for="name" class="control-label">Placement name</label>
          <div class="controls">
            <input type="text" name="name" id="name" class="input-xlarge" value="<?= htmlspecialchars($placement->name) ?>">
            <p class="help-block">Placement internal name. Can't be changed. Accept only A-Z, a-z, 0-9 and dot.</p>
          </div>
        </div>
      <? endif ?>
      <div class="control-group <?= isset($errors) && $errors->title ? 'error' : '' ?>">
        <label for="title" class="control-label">Title</label>
        <div class="controls">
          <input type="text" name="title" id="title" class="input-xlarge" value="<?= htmlspecialchars($placement->title) ?>">
          <p class="help-block">Placement human-readable name.</p>
        </div>
      </div>
      <div class="control-group">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Show</th>
              <th>Name</th>
              <th>Title</th>
              <th>Type</th>
            </tr>
          </thead>
          <tbody>
            <? foreach($units as $unit) : ?>
            <tr>
              <td>
                <input type="checkbox" name="unit[]" value="<?= htmlspecialchars($unit->name) ?>"
                  <?= isset($showingUnitNames) && in_array($unit->name, $showingUnitNames) ? 'checked="checked"' : '' ?>>
              </td>
              <td><?= $unit->name ?></td>
              <td><?= $unit->title ?></td>
              <td><?= $unit->type ?></td>
            </tr>
            <? endforeach ?>
          </tbody>
        </table>
      </div>
      <div class="form-actions">
        <button class="btn btn-primary" type="submit"><?= $action === 'create' ? 'Create' : 'Save changes' ?></button>
        <a href="<?= $action === 'create' ? '/placements' : '/placements/' . htmlspecialchars($placement->name) ?>" class="btn">Cancel</a>
      </div>
    </fieldset>
  </form>
</div>
