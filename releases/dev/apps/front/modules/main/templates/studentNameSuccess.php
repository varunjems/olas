<div id="setup-form" class="form">
<form method="post">
<?php echo $form->renderHiddenFields() ?>
<?php if ($form->canSkip()): ?>
    <input type="hidden" name="student_name[skip_name]" value="yes" />
<?php endif; ?>

<?php if ($form->hasGlobalErrors()): ?>
<?php echo $form->renderGlobalErrors() ?>
<?php endif; ?>

<?php if ($form['first_name']->hasError()): ?>
<?php echo $form['first_name']->renderError() ?><br />
<?php endif; ?>
<?php echo $form['first_name']->renderLabel() ?><br />
<?php echo $form['first_name']->render() ?><br />

<br />

<?php if ($form['last_name']->hasError()): ?>
<?php echo $form['last_name']->renderError() ?><br />
<?php endif; ?>
<?php echo $form['last_name']->renderLabel() ?><br />
<?php echo $form['last_name']->render() ?><br />

<br />
<br />

<input type="submit" value="<?php echo __('Next') ?>" />
</form>
</div>
