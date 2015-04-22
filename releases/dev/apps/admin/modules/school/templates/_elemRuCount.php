<?php
  $iCnt =  $school->getElemRUIncompleteCount();
  $iDt =  $school->getElemRUIncompleteDate();

  $cCnt =  $school->getElemRUCompleteCount();
  $cDt =  $school->getElemRUCompleteDate();

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
