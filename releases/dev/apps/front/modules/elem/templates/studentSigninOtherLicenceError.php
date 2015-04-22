<div>
    <p class="intro">
        There was an error getting a license for Level 1, <?php if ($assessment=='revvingup'): ?>Form A<?php else: ?>Form B<?php endif; ?>.
    </p>

    <p class="intro">
        Please contact your proctor for help.
    </p>
    <!--
    <?php if (!empty($errorMessage)) { echo $errorMessage; } ?>
    -->
</div>
<script>
    $(function(){
        $('p.pages').hide();
    });
</script>
