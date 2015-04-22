<?php slot('showlang', 'es') ?>
<div class="lang-choose">
    <p class="lang-choice">Choose a language</p>
    <div class="languages">
        <div class="lang lang-en">
            <div>
                <?php echo link_to('English', array('sf_route'=>'student_signin_sid', 'assessment'=>$assessment, 'school'=>$school, 'sf_culture'=>'en', 'sid'=>$sid)) ?>
                <?php echo link_to('<img src="'.image_path("sh/rev_rightarrow_active.png").'" />', array('sf_route'=>'student_signin_sid', 'assessment'=>$assessment, 'school'=>$school, 'sf_culture'=>'en', 'sid'=>$sid)) ?>
            </div>
        </div>
        <div class="lang lang-es">
            <div>
                <?php echo link_to('Español', array('sf_route'=>'student_signin_sid', 'assessment'=>$assessment, 'school'=>$school, 'sf_culture'=>'es', 'sid'=>$sid)) ?>
                <?php echo link_to('<img src="'.image_path("sh/rev_rightarrow_active.png").'" />', array('sf_route'=>'student_signin_sid', 'assessment'=>$assessment, 'school'=>$school, 'sf_culture'=>'es', 'sid'=>$sid)) ?>
            </div>
        </div>
    </div>
    <p class="lang-choice">Seleccione un idioma</p>
</div>
