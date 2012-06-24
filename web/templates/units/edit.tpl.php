<div class="row-fluid">
  <form class="form-horizontal" method="post">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

    <fieldset>
      <legend><?= $action === 'create' ? 'Create new unit' : 'Edit unit' ?></legend>
      <div class="alert alert-error <?= isset($errors) ? '' : 'hidden' ?>">Please fix errors and try again.</div>
      <? if($action === 'create') : ?>
        <div class="control-group <?= isset($errors) && $errors->name ? 'error' : '' ?>">
          <label for="name" class="control-label">Unit name</label>
          <div class="controls">
            <input type="text" name="name" id="name" class="input-xlarge" value="<?= htmlspecialchars($unit->name) ?>">
            <p class="help-block">Unit internal name. Can't be changed. Accept only A-Z, a-z, 0-9 and dot.</p>
          </div>
        </div>
        <div class="control-group <?= isset($errors) && $errors->type ? 'error' : '' ?>">
          <label for="type" class="control-label">Unit type</label>
          <div class="controls">
            <select name="type" id="type">
              <option value="image" selected="selected">Image unit</option>
              <option value="html" selected="">Html unit</option>
            </select>
            <p class="help-block">Unit type. Can't be changed.</p>
          </div>
        </div>
      <? endif ?>
      <div class="control-group <?= isset($errors) && $errors->title ? 'error' : '' ?>">
        <label for="title" class="control-label">Title</label>
        <div class="controls">
          <input type="text" name="title" id="title" class="input-xlarge" value="<?= htmlspecialchars($unit->title) ?>">
          <p class="help-block">Unit human-readable name.</p>
        </div>
      </div>
      <div class="control-group <?= isset($errors) && $errors->weight ? 'error' : '' ?>">
        <label for="title" class="control-label">Weight</label>
        <div class="controls">
          <input type="text" name="weight" id="weight" class="input-xlarge" value="<?= htmlspecialchars($unit->weight) ?>">
          <p class="help-block">Unit weight. Number between 1 and 100.</p>
        </div>
      </div>
      <div class="control-group <?= isset($errors) && $errors->link ? 'error' : '' ?>">
        <label for="link" class="control-label">Link</label>
        <div class="controls">
          <input type="text" name="link" id="link" class="input-xlarge" value="<?= htmlspecialchars($unit->link) ?>">
          <p class="help-block">Url to redirect when user click on unit.</p>
        </div>
      </div>
      <hr/>
      <div class="control-group <?= isset($errors) && $errors->imageUrl ? 'error' : '' ?>">
        <label for="imageUrl" class="control-label">Image url</label>
        <div class="controls">
          <input type="text" name="imageUrl" id="imageUrl" class="input-xlarge" value="<?= htmlspecialchars($unit->imageUrl) ?>">
          <p class="help-block">Url for unit image.</p>
        </div>
      </div>
      <div class="control-group <?= isset($errors) && $errors->html ? 'error' : '' ?>">
        <label for="html" class="control-label">Html code</label>
        <div class="controls">
          <textarea rows="3" name="html" id="html" class="input-xlarge"><?= htmlspecialchars($unit->html) ?></textarea>
        </div>
      </div>
      <div class="form-actions">
        <button class="btn btn-primary" type="submit"><?= $action === 'create' ? 'Create' : 'Save changes' ?></button>
        <a href="<?= $action === 'create' ? '/units' : '/units/' . htmlspecialchars($unit->name) ?>" class="btn">Cancel</a>
      </div>
    </fieldset>
  </form>
</div>
