<div id="idform" class="form">
<form method="post">
<?php echo $form->renderHiddenFields() ?>

<strong><?php echo __('Student ID Number') ?></strong><br />
<?php if ($form->hasGlobalErrors()): ?>
<?php echo $form->renderGlobalErrors() ?>
<?php endif; ?>

<?php if ($form['student_id']->hasError()): ?>
<?php echo $form['student_id']->renderError() ?>
<?php endif; ?>
<?php echo $form['student_id']->renderLabel() ?><br />
<?php echo $form['student_id']->render() ?><br />

<br />

<?php if ($form['student_id2']->hasError()): ?>
<?php echo $form['student_id2']->renderError() ?><br />
<?php endif; ?>
<?php echo $form['student_id2']->renderLabel() ?><br />
<?php echo $form['student_id2']->render() ?><br />

<br />
<br />

<input type="submit" value="<?php echo __('Next') ?>" />
</form>
</div>
