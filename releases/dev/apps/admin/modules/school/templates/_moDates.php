<?php
  $iCnt =  $school->getMOIncompleteCount();
  $iDt =  $school->getMOIncompleteDate();

  $cCnt =  $school->getMOCompleteCount();
  $cDt =  $school->getMOCompleteDate();

  $tCnt = $iCnt + $cCnt;
?>
<ul class="sf_admin_td_actions">
<br />
<li class="sf_admin_dates">
  <div style="display: inline-block; vertical-align: top; line-height: 17px;">
    <?php
      if ($iCnt) {
        if ($iDt) {
          echo "<span title='Last date a question was answered' class='last-date'>{$iDt}</span>";
        }
        echo '<br />';
      }
    ?>
    <?php
      if ($cCnt) {
        if ($cDt) {
          echo "<span title='Last date a question was answered' class='last-date'>{$cDt}</span>";
        }
      }
    ?>
  </div>
</li>
</ul>
