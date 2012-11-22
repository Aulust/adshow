<div class="row-fluid">
  <form class="form-horizontal" method="post">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

    <fieldset>
      <legend>Do you really want to delete "<?= htmlspecialchars($unit->title) ?>"?</legend>
      <div class="alert alert-error <?= isset($errors) ? '' : 'hidden' ?>">Please fix errors and try again.</div>
      <div class="form-actions">
        <button class="btn btn-danger" type="submit">Delete</button>
        <a href="/units/<?= htmlspecialchars($unit->name) ?>" class="btn">Cancel</a>
      </div>
    </fieldset>
  </form>
</div>
