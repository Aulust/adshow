<div class="row-fluid">
  <form class="form-horizontal" method="post" enctype="multipart/form-data">
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
            <select onChange="changeUnitType(this.value);" name="type" id="type">
              <option value="image" selected="selected">Image unit</option>
              <option value="html">Html unit</option>
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
      <div class="control-group <?= isset($errors) && $errors->views_limit ? 'error' : '' ?>">
        <label for="title" class="control-label">Views limit</label>
        <div class="controls">
          <input type="text" name="views_limit" id="views_limit" class="input-xlarge" value="<?= htmlspecialchars($unit->views_limit) ?>">
          <p class="help-block">Views  limit.</p>
        </div>
      </div>
      <div class="control-group <?= isset($errors) && $errors->clicks_limit ? 'error' : '' ?>">
        <label for="title" class="control-label">Clicks limit</label>
        <div class="controls">
          <input type="text" name="clicks_limit" id="clicks_limit" class="input-xlarge" value="<?= htmlspecialchars($unit->clicks_limit) ?>">
          <p class="help-block">Clicks limit.</p>
        </div>
      </div>
      <div class="control-group <?= isset($errors) && $errors->time_limit ? 'error' : '' ?>">
        <label for="title" class="control-label">Time limit</label>
        <div class="controls">
          <input type="text" name="time_limit" id="time_limit" class="input-xlarge" value="<?= htmlspecialchars($unit->time_limit) ?>">
          <p class="help-block">Time limit.</p>
        </div>
      </div>
	  
      <div id="unit_link_div" <?= $unit->type == 'html' ? 'style="display:none;"' : '' ?> class="control-group <?= isset($errors) && $errors->link ? 'error' : '' ?>">
        <label for="link" class="control-label">Link</label>
        <div class="controls">
          <input type="text" name="link" id="link" class="input-xlarge" value="<?= htmlspecialchars($unit->link) ?>">
          <p class="help-block">Url to redirect when user click on unit.</p>
        </div>
      </div>
      <hr/>
      <div id="unit_image_div" <?= $unit->type == 'html' ? 'style="display:none;"' : '' ?> class="control-group <?= isset($errors) && $errors->imageUrl ? 'error' : '' ?>">
        <label for="imageUrl" class="control-label">Image file</label>
        <div class="controls">
          <input type="file" name="imageUrl" id="imageUrl" class="input-xlarge">
          <p class="help-block">Unit image.</p>
        </div>
      </div>
	  
      <div id="unit_html_div" <?= $unit->type == 'image' ||  $action === 'create'? 'style="display:none;"' : '' ?> class="control-group <?= isset($errors) && $errors->html ? 'error' : '' ?>">
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
<script type="text/javascript">
$(document).ready(function(){
$('#time_limit').simpleDatepicker();
});
</script>