<div id="player1"></div>
<div id="jp_container_1" class="player">
    <a href=#" class="jp-play"><img src="<?php echo image_path('sh/rev_audio_unselected_small.png') ?>" /></a>
    <a href=#" class="jp-pause"><img src="<?php echo image_path('sh/rev_audio_selected_small.png') ?>" /></a>
</div>
<div id="setup-form" class="form right">
    <form class="frm-setup frm-d3" method="post" action="#a">
        <?php echo $form->renderHiddenFields() ?>
        <?php if ($form->hasGlobalErrors()): ?>
        <?php echo $form->renderGlobalErrors() ?>
        <?php endif; ?>

        <?php //echo $form['ethnicity']->renderLabel() ?>
        <?php if ($form['ethnicity']->hasError()): ?>
        <?php echo $form['ethnicity']->renderError() ?>
        <?php endif; ?>
        <label for="ru_ethnicity">I am...</label><br />
        <?php //echo $form['ethnicity']->render() ?>

        <div class="list-part">
        <input name="ru[ethnicity]" type="radio" value="1" id="ru_ethnicity_1" required="required" <?php echo ($form['ethnicity']->getValue()==1)?'checked':'' ?> />
        <label for="ru_ethnicity_1">White</label>
        <br />

        <input name="ru[ethnicity]" type="radio" value="2" id="ru_ethnicity_2" required="required" <?php echo ($form['ethnicity']->getValue()==2)?'checked':'' ?> />
        <label for="ru_ethnicity_2">African American/Black</label>
        <br />

        <input name="ru[ethnicity]" type="radio" value="3" id="ru_ethnicity_3" required="required" <?php echo ($form['ethnicity']->getValue()==3)?'checked':'' ?> />
        <label for="ru_ethnicity_3">American Indian</label>
        </div>

        <div class="list-part">
        <input name="ru[ethnicity]" type="radio" value="4" id="ru_ethnicity_4" required="required" <?php echo ($form['ethnicity']->getValue()==4)?'checked':'' ?> />
        <label for="ru_ethnicity_4">Asian/Pacific Islander</label>
        <br />

        <input name="ru[ethnicity]" type="radio" value="5" id="ru_ethnicity_5" required="required" <?php echo ($form['ethnicity']->getValue()==5)?'checked':'' ?> />
        <label for="ru_ethnicity_5">Hispanic and/or Latino</label>
        <br />

        <input name="ru[ethnicity]" type="radio" value="6" id="ru_ethnicity_6" required="required" <?php echo ($form['ethnicity']->getValue()==6)?'checked':'' ?> />
        <label for="ru_ethnicity_6">Other/More than One</label>
        </div>
        <br />

        <br />
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
    hr.progress { width: 5% }
</style>

<script>
    var skipQuestions = (document.cookie.match("canSkipMD=true") !== null);

  $(document).on('change', 'form', function(e) {
      if ($('input:checked', $(this)).length) {
          $('.btn-next').removeClass('disabled');
          $('.btn-next').removeClass('emptyField');
      } else {
          $('.btn-next').addClass('emptyField');
      }
  });

  $(document).on('click', '.navigation a.btn-back', function(e) {
      e.preventDefault();

      $('.btn-back').animate({left:'-=100'}, 300, function(){
          window.location = '<?php echo url_for('elem_ru_student_class', array('assessment'=>$assessment, 'school'=>$school, 'sid'=>$sid)) ?>#a';
      });
  });

  $(document).on('click', '.btn-next', function(e){
      if ($(this).hasClass('disabled')) {
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
  $('.pages-on').html(5);

  $('form').trigger('change');

  $("#player1").jPlayer({
   ready: function () {
    $(this).jPlayer("setMedia", {
      mp3: "<?php echo image_path('/audio/others/race_scr5.mp3') ?>",
      oga: "<?php echo image_path('/audio/others/race_scr5.ogg') ?>"
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
