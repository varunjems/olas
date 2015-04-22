<div>
<p>
    <?php echo __('You have started but not completed %assessment%.', array('%assessment%'=>(($assessment=='revvingup')?__('Level 2, Form A'):__('Level 2, Form B')))) ?>
</p>
<p>
    <?php echo __('Click OK to continue.') ?>
</p>
<form method="post" action="<?php echo $signinPage ?>">
    <input type="submit" name="started" value="<?php echo __('OK') ?>" />
</form>
</div>
