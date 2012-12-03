<div class="row-fluid" data-component="ImageUpload">
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
      <div class="control-group <?= isset($errors) && $errors->showsLimit ? 'error' : '' ?>">
        <label for="title" class="control-label">Shows limit</label>
        <div class="controls">
          <input type="text" name="showsLimit" id="showsLimit" class="input-xlarge" value="<?= htmlspecialchars($unit->showsLimit) ?>">
          <p class="help-block">Shows  limit.</p>
        </div>
      </div>
      <div class="control-group <?= isset($errors) && $errors->clicksLimit ? 'error' : '' ?>">
        <label for="title" class="control-label">Clicks limit</label>
        <div class="controls">
          <input type="text" name="clicksLimit" id="clicksLimit" class="input-xlarge" value="<?= htmlspecialchars($unit->clicksLimit) ?>">
          <p class="help-block">Clicks limit.</p>
        </div>
      </div>
      <div class="control-group <?= isset($errors) && $errors->timeLimit ? 'error' : '' ?>">
        <label for="title" class="control-label">Time limit</label>
        <div class="controls">
          <input type="text" name="timeLimit" id="timeLimit" class="input-xlarge" value="<?= htmlspecialchars($unit->timeLimit) ?>">
          <p class="help-block">Time limit.</p>
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

      <? if($action === 'create') : ?>
        <div class="control-group <?= isset($errors) && $errors->type ? 'error' : '' ?>">
          <label for="unitType" class="control-label">Unit type</label>
          <div class="controls">
            <select name="type" id="unitType" data-component="SelectToggle">
              <option data-target="#unitImageDiv" value="image" <?= $unit->type == 'image' ? 'selected="selected"' : '' ?>>Image unit</option>
              <option data-target="#unitHtmlDiv" value="html" <?= $unit->type == 'html' ? 'selected="selected"' : '' ?>>Html unit</option>
            </select>
            <p class="help-block">Unit type. Can't be changed.</p>
          </div>
        </div>
      <? endif ?>

      <div id="unitImageDiv" class="control-group <?= $unit->type === 'html' ? 'hidden ' : '' ?><?= isset($errors) && $errors->imageUrl ? 'error' : '' ?>">
        <label for="imageUrl" class="control-label">Image file</label>
        <div class="controls">
          <div>
            <input type="text" name="imageUrl" id="imageUrl" class="input-xlarge ImageUpload-ImageUrl" value="<?= htmlspecialchars($unit->imageUrl) ?>">
          </div>
          <div class="ImageUpload-InputBlock">
            <span class="color-red hidden ImageUpload-Error">Error file upload. Please try again.</span>
            <div class="progress progress-striped active upload-progress hidden ImageUpload-Progress"><div class="bar" style="width: 100%;"></div></div>
            <input type="file" name="imageFile" class="input-xlarge ImageUpload-Input">
          </div>
          <p class="help-block">Unit image. Upload file or type image url.</p>
        </div>
      </div>
      <div id="unitHtmlDiv" class="control-group <?= ($unit->type === 'image' || $unit->type === '') ? 'hidden' : '' ?><?= isset($errors) && $errors->html ? 'error' : '' ?>">
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

  <div class="hidden">
    <form action="/upload/image" method="post" enctype="multipart/form-data" target="upload-result" class="ImageUpload-Form"></form>
    <iframe name="upload-result" class="ImageUpload-Iframe"></iframe>
  </div>
</div>
