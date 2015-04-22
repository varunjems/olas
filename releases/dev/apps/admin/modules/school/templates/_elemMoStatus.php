<?php
  $iCnt =  $school->getElemMOIncompleteCount();
  $iDt =  $school->getElemMOIncompleteDate();

  $cCnt =  $school->getElemMOCompleteCount();
  $cDt =  $school->getElemMOCompleteDate();

  $tCnt = $iCnt + $cCnt;
?>
<ul class="sf_admin_td_actions">
<li class="sf_admin_action_toggle is-<?php echo ($school->elem_mo_enabled?'enabled':'disabled') ?>">
  <?php echo link_to(($school->elem_mo_enabled?'Enabled':'Disabled'), 'school/toggleElemMOEnabled?id='.$school->id, array('class'=>'link-enable', 'onclick'=>'return '.($school->elem_mo_enabled?'confirm("Are you sure you wish to take down Revving Up for this school?");':''))) ?>
</li>
<?php if ($tCnt): ?>
<li class="sf_admin_action_purge">
  <?php echo link_to('Purge', 'school/purgeElemMOData?id='.$school->id, array('class'=>'link-purge', 'onclick'=>'return confirm("Are you sure you wish to purge this Revving Up data?");')) ?>
</li>
<?php endif; ?>
<br />
<?php if ($iCnt): ?>
<li class="sf_admin_action_download sf_admin_dates sf_admin_count" style="display: block; margin-top: 5px;">
  <div style="display: inline-block; vertical-align: top; line-height: 17px;">
    <?php echo link_to('Incomplete', 'school/downloadElemMOI?id='.$school->id, array('class'=>'link-download', 'title'=>'Download spreadsheet for Incomplete assessments')); ?>
    <br />
    <?php if ($iDt): ?>
    <span title='Last date a question was answered' class='last-date'><?php echo $iDt ?></span>
    <?php endif; ?>
    <span title='<?php echo $iCnt ?> incomplete student records' class='student-count'><?php echo $iCnt ?></span>
    <br />
  </div>
</li>
<?php endif; ?>
<?php if ($cCnt): ?>
<li class="sf_admin_action_download sf_admin_dates sf_admin_count" style="display: block; margin-top: 5px;">
  <div style="display: inline-block; vertical-align: top; line-height: 17px;">
    <?php echo link_to('Complete', 'school/downloadElemMO?id='.$school->id, array('class'=>'link-download', 'title'=>'Download spreadsheet for Completed assessments')); ?>
    <br />
    <?php if ($cDt): ?>
      <span title='Last date a question was answered' class='last-date'><?php echo $cDt ?></span>
    <?php endif; ?>
    <span title='<?php echo $cCnt ?> complete student records' class='student-count'><?php echo $cCnt ?></span>
  </div>
</li>
<?php endif; ?>
</ul>
