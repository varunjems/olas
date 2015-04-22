<form method='post'>
<?php
$lang = '';
if ($sf_user->getCulture() != 'en') {
    $lang = '_es';
}

$pgInfo = $sf_data->get('qPage', ESC_RAW);
?>

<h1 class='title'><?php echo $qPage['title'.$lang] ?></h1>
<?php echo $pgInfo['intro'.$lang] ?>

<?php if ($missingItem): ?>
<div class="missing-item">
    <p><?php echo __("You didn't answer all the items on this page.") ?></p>
    <?php if ($nextButton): ?>
        <p><?php echo __('Please complete all items or click Next to continue.') ?></p>
    <?php else: ?>
        <p><?php echo __('Please complete all items or click Finished.') ?></p>
    <?php endif; ?>
    <input type="hidden" name="missingok" value="1" />
</div>
<?php endif; ?>

<h2 class='instructions'>
    <?php echo $pgInfo['instructions'.$lang] ?>
</h2>

<table class='table-questions' cellspacing='0' cellpadding='0' border='0'>
<thead>
<tr><td class='header-values'></td>
<?php
foreach ($scaleValues as $value) {
	echo "<th scope='col' class='header-scale'>",$value['description'.$lang],"</th>";
}
?>
</tr>
</thead>

<tbody>
<?php
$row = 0;
$rawQuestions = $sf_data->get('questions', ESC_RAW);
foreach ($rawQuestions as $question) {
	echo "<tr align='left' scope='row' class='".((++$row)%2==1?'odd':'even')."'>";
	echo "<th>",$question['question'.$lang],"</th>";
	foreach ($scaleValues as $value) {
		echo "<td align='center'><input type='radio' name='q_{$question['question_number']}' value='{$value['value']}' ".(($value['value'] == $question['answer'])?'checked ':'')."/></td>";
	}
	echo "</tr>";
}
echo "</tbody>";
echo "</table>";
?>


<div id="navProgress">
    <?php echo __('Page %page% of %pages%', array('%page%'=>$page, '%pages%'=>17)) ?>
</div>
<div id="navButtonsWrap">
<?php if ($prevButton): ?>
    <input type="submit" name="SButton" value="<?php echo __('Previous') ?>" />
<?php endif; ?>
<?php if ($nextButton): ?>
    <input type="submit" name="SButton" value="<?php echo __('Next') ?>" />
<?php endif; ?>
<?php if ($finishButton): ?>
    <input type="submit" name="SButton" value="<?php echo __('Finished') ?>" />
<?php endif; ?>
<br />
<div id="navInstructions">
<?php if ($nextButton): ?>
    <?php echo __('Click "Previous" or "%next%" to save your answers.', array('%next%'=>(($nextButton)?__('Next'):__('Finished')) ))?>
<?php else: ?>
    <?php echo __('Click "Finished" if all your answers are final and you are ready to submit %assessment%.', array('%assessment%'=>__('the Clear Path Survey'))) ?>
<?php endif; ?>
</div>
</div>
</form>
