<div id="setup-form" class="form">
<form method="post">
<?php echo $form->renderHiddenFields() ?>
<?php if ($form->hasGlobalErrors()): ?>
<?php echo $form->renderGlobalErrors() ?>
<?php endif; ?>

<?php echo $form['class_id']->renderLabel() ?><br />
<?php if ($form['class_id']->hasError()): ?>
<?php echo $form['class_id']->renderError() ?>
<?php endif; ?>
<?php echo $form['class_id']->render() ?><br />

<br />

<?php echo $form['ethnicity']->renderLabel() ?><br />
<?php if ($form['ethnicity']->hasError()): ?>
<?php echo $form['ethnicity']->renderError() ?>
<?php endif; ?>
<?php echo $form['ethnicity']->render() ?><br />

<br />

<?php echo $form['gender']->renderLabel() ?><br />
<?php if ($form['gender']->hasError()): ?>
<?php echo $form['gender']->renderError() ?>
<?php endif; ?>
<?php echo $form['gender']->render() ?><br />

<br />
<input type="submit" value="<?php echo __("Next") ?>" />
</form>
</div>
