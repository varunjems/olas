<?php
  $iCnt =  $school->getElemMOIncompleteCount();
  $iDt =  $school->getElemMOIncompleteDate();

  $cCnt =  $school->getElemMOCompleteCount();
  $cDt =  $school->getElemMOCompleteDate();

  $tCnt = $iCnt + $cCnt;
?>
<ul class="sf_admin_td_actions">
<br />
<li class="sf_admin_count">
  <div style="display: inline-block; vertical-align: top; line-height: 17px;">
    <?php
      if ($iCnt) {
        echo "<span title='{$iCnt} incomplete student records' class='student-count'>{$iCnt}</span>";
        echo '<br />';
      }
    ?>
    <?php
      if ($cCnt) {
        echo "<span title='{$cCnt} complete student records' class='student-count'>{$cCnt}</span>";
      }
    ?>
  </div>
</li>
</ul>
