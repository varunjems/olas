<div id="player1"></div>
<div id="jp_container_1" class="player">
    <a href=#" class="jp-play"><img src="<?php echo image_path('sh/rev_audio_unselected_small.png') ?>" /></a>
    <a href=#" class="jp-pause"><img src="<?php echo image_path('sh/rev_audio_selected_small.png') ?>" /></a>
</div>
<div id="setup-form" class="form right">
    <form class="frm-setup frm-d1" method="post" action="#a">
        <?php echo $form->renderHiddenFields() ?>
        <?php if ($form->hasGlobalErrors()): ?>
        <?php echo $form->renderGlobalErrors() ?>
        <?php endif; ?>

        <div class="control-group">
            <?php if ($form['gender']->hasError()): ?>
            <?php echo $form['gender']->renderError() ?>
            <?php endif; ?>
            <label class="lbl-g1" for="ru_gender">I am a:</label>
            <div class="controls">
                <?php //echo $form['gender']->render() ?>
                <input name="ru[gender]" type="radio" value="1" id="ru_gender_1" <?php echo ($form['gender']->getValue()==1)?'checked':'' ?>>
                <label for="ru_gender_1"><img src="<?php echo image_path('sh/rev_gender_male.png') ?>" class="img-gender" alt="boy" /><span class="caption">boy</span></label>
                <input name="ru[gender]" type="radio" value="2" id="ru_gender_2" <?php echo ($form['gender']->getValue()==2)?'checked':'' ?>>
                <label for="ru_gender_2"><img src="<?php echo image_path('sh/rev_gender_female.png') ?>" class="img-gender" alt="girl" /><span class="caption">girl</span></label>
            </div>
        </div>

        <div class="control-group">
            <?php //echo $form['age']->renderLabel() ?>
            <?php if ($form['age']->hasError()): ?>
            <?php echo $form['age']->renderError() ?>
            <?php endif; ?>
            <label for="ru_age">I am </label>
            <?php echo $form['age']->render() ?>
            <label for="ru_age"> years old.</label><br />
        </div>

        <div class="control-group">
            <?php //echo $form['grade']->renderLabel() ?>
            <?php if ($form['grade']->hasError()): ?>
            <?php echo $form['grade']->renderError() ?>
            <?php endif; ?>
            <label for="ru_grade">I am in grade </label>
            <?php echo $form['grade']->render() ?>
            <label for="ru_grade">.</label><br />
        </div>
    </form>
</div>
<div class="navigation">
    <a href="#" class="btn-back"><img class="back" src="<?php echo image_path('sh/rev_text_back.png') ?>" alt="Back"/></a>
    <button class="btn-next"><img src="<?php echo image_path('sh/rev_text_next.png') ?>" class="next" alt="Next"/></button>
</div>

<div class="skip-dialogue" style="display: none;">
    <div class="skip-inner">
        <span class="skip-statement">Are you sure you want to skip this page?</span>
        <div class="skip-btns">
            <button class="btn-skip btn-yes">Yes, continue</button>
            <button class="btn-skip btn-no">No, cancel</button>
        </div>
    </div>
</div>

<style>
    hr.progress { width: 3% }
</style>

<script>
    var skipQuestions = (document.cookie.match("canSkipMD=true") !== null);

    $(document).on('keyup', 'input:text', function(e) {
        $(this).trigger('change');
    });

    $(document).on('change', 'form', function(e) {
        var enable = 1;
        $('.btn-next').removeClass('emptyField');

        if ($('input:checked').length !== 1) {
            $('.btn-next').addClass('emptyField');
        }

        if ($('#ru_age').val().match(/^\d{1,2}$/) === null) {
            if (!$('#ru_age').val()) {
                enable = 0;
                $('#ru_age').removeClass('error');
                $('.btn-next').addClass('emptyField');
            } else {
                enable = 0;
                $('#ru_age').addClass('error');
            }
        } else if (!parseInt($('#ru_age').val())) {
            enable = 0;
            $('#ru_age').addClass('error');
        } else {
            $('#ru_age').removeClass('error');
        }

        if ($('#ru_grade').val().match(/^\d{1,2}$/) === null) {
            if (!$('#ru_grade').val()) {
                enable = 0;
                $('#ru_grade').removeClass('error');
                $('.btn-next').addClass('emptyField');
            } else {
                enable = 0;
                $('#ru_grade').addClass('error');
            }
        } else if (!parseInt($('#ru_grade').val())) {
            enable = 0;
            $('#ru_grade').addClass('error');
        } else {
            $('#ru_grade').removeClass('error');
        }

        if (enable) {
            $('.btn-next').removeClass('disabled');
        } else {
            $('.btn-next').addClass('disabled');
        }
    });

  $(document).on('click', '.btn-back', function(e) {
      e.preventDefault();

      $('.btn-back').animate({left:'-=100'}, 300, function(){
          window.location = '<?php echo url_for('elem_student_name', array('assessment'=>$assessment, 'school'=>$school, 'sid'=>$sid)) ?>#a';
      });
  });

  $(document).on('click', '.btn-next', function(e){
      if ($('.btn-next').hasClass('disabled')) {
          e.preventDefault();
          return;
      }

      $('.btn-next').animate({left:'+=100'}, 300, function(){
          $('form').submit();
      });
  });

    $(document).on('submit', 'form', function(e){
        if ($('.btn-next').hasClass('disabled')) {
            e.preventDefault();
            return;
        }

        if (!skipQuestions && $('.btn-next').hasClass('emptyField')) {
            e.preventDefault();

            // IF never shown the empty warning before, show it here (and set a cookie to know if we've seen it)
            showSkipDialogue();
            return;
        }
    });

    function showSkipDialogue() {
        $('div.overlay').show();
        $('div.skip-dialogue').show();
        skipQuestions = true;
        document.cookie="canSkipMD=true; path=/";
    }

    function hideSkipDialogue() {
        $('div.skip-dialogue').hide();
        $('div.overlay').hide();
    }

    $(document).on('click', '.btn-no', function(e) {
        hideSkipDialogue();
        $('.btn-next').animate({left:'-=100'}, 300, function(){});
    });

    $(document).on('click', '.btn-yes', function(e) {
        hideSkipDialogue();
        skipQuestions = true;
        $('.navigation .btn-next').trigger('click');
    });

 $(function(){
  $('.pages-on').html(3);

  $('form').trigger('change');

  $("#player1").jPlayer({
   ready: function () {
    $(this).jPlayer("setMedia", {
     mp3: "<?php echo image_path('/audio/others/demog_scr3.mp3') ?>",
     oga: "<?php echo image_path('/audio/others/demog_scr3.ogg') ?>"
    });
   },
   swfPath: "<?php echo image_path('/js') ?>",
   supplied: "mp3, oga"
  });
 });

var history_api = typeof history.pushState !== 'undefined'
if ( location.hash == '#a' ) {
  if ( history_api ) history.pushState(null, '', '#b')
  else location.hash = '#b'
  window.onhashchange = function() {
    if ( location.hash == '#a' ) {
      alert("Using the back button is not supported in this application.")
      if ( history_api ) history.pushState(null, '', '#b')
      else location.hash = '#b'
    }
  }
}
</script>
