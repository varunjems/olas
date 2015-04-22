<div>
    <p class="intro">
        You have started but not completed Level 1, <?php if ($assessment=='revvingup'): ?>Form A<?php else: ?>Form B<?php endif; ?>.
    </p>
    <p class="intro">
        Press NEXT to continue.
    </p>
    <form method="post" action="<?php echo $signinPage ?>">
        <input type="hidden" name="started" value="OK" />
    </form>
</div>

<div class="navigation">
    <button class="btn-next"><img src="<?php echo image_path('sh/rev_text_next.png') ?>" class="next" alt="Next"/></button>
</div>


<script>
    $(document).on('click', '.btn-next', function(e){
        $('.btn-next').animate({left:'+=100'}, 300, function(){ });
        $('form').submit();
    });

    $(function(){
        $('p.pages').hide();
    });
</script>
