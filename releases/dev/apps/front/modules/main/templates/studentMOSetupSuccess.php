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

<?php echo $form['lessons']->renderLabel() ?><br />
<?php if ($form['lessons']->hasError()): ?>
<?php echo $form['lessons']->renderError() ?>
<?php endif; ?>
<?php echo $form['lessons']->render() ?><br />

<br />
<input type="submit" value="<?php echo __('Next') ?>" />
</form>
</div>
