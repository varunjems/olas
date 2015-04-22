<div id="player1"></div>
<div id="jp_container_1" class="player signin-speaker">
    <a href=#" class="jp-play"><img src="<?php echo image_path('sh/rev_audio_unselected_small.png') ?>" /></a>
    <a href=#" class="jp-pause"><img src="<?php echo image_path('sh/rev_audio_selected_small.png') ?>" /></a>
</div>
<div id="idform" class="form right">
    <form class="frm-setup frm-signin" method="post" action="#a">
        <?php echo $form->renderHiddenFields() ?>

        <?php if ($form->hasGlobalErrors()): ?>
        <?php echo $form->renderGlobalErrors() ?>
        <?php endif; ?>

        <div class="control-group">
            <?php if ($form['student_id']->hasError()): ?>
            <?php echo $form['student_id']->renderError() ?>
            <?php endif; ?>

            <label for="student_student_id">Enter student ID number: </label>
            <?php echo $form['student_id']->render() ?>
        </div>

        <div class="control-group">
            <?php if ($form['student_id2']->hasError()): ?>
            <?php echo $form['student_id2']->renderError() ?><br />
            <?php endif; ?>
            <label for="student_student_id2">Re-enter student ID number: </label>
            <?php echo $form['student_id2']->render() ?>
        </div>

        <?php /*<input type="submit" class="next" value="Next" />*/ ?>
    </form>
</div>
<div class="navigation">
    <button class="btn-next disabled"><img src="<?php echo image_path('sh/rev_text_next.png') ?>" class="next" alt="Next"/></button>
</div>

<style>
    hr.progress { width: 1% }
</style>

<script>
    document.cookie = "canSkipMD=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
    $(document).on('keyup', 'input[type=text]', function(e) {
        $(this).trigger('change');
    });

    $(document).on('change', 'form', function(e) {
        var enable = 1;

        $('input[type=text]').each(function(){
            if (!$(this).val()) {
                enable = 0;
            }
        });

        if ($('#student_student_id').val() !== $('#student_student_id2').val()) {
            enable = 0;

            if ($('#student_student_id').val().indexOf($('#student_student_id2').val()) !== 0) {
                $('#student_student_id2').addClass('error');
            } else {
                $('#student_student_id2').removeClass('error');
            }
        }
        if (enable) {
            $('#student_student_id2').removeClass('error');
            $('.btn-next').removeClass('disabled');
        } else {
            $('.btn-next').addClass('disabled');
        }
    });

  $(document).on('submit', 'form', function(e){
      if ($('.btn-next').hasClass('disabled')) {
          e.preventDefault();
          return;
      }

      /*
      if (!$('form').validate().form()) {
          console.log('failed validation');
      }
       */
  });

  $(document).on('click', '.btn-next', function(e){
      if ($('.btn-next').hasClass('disabled')) {
          e.preventDefault();
          return;
      }

      $('.btn-next').animate({left:'+=100'}, 300, function(){
          $('form').trigger('submit');
      });
  });

 $(function(){
  $('.pages-on').html(1);

  $('form').trigger('change');

  $("#player1").jPlayer({
   ready: function () {
    $(this).jPlayer("setMedia", {
     mp3: "<?php echo image_path('/audio/others/student_number_scr2.mp3') ?>",
     oga: "<?php echo image_path('/audio/others/student_number_scr2.ogg') ?>"
    });
   },
   swfPath: "<?php echo image_path('/js') ?>",
   supplied: "mp3, oga"
  });


  /*
  jQuery.validator.setDefaults({
      success: "valid"
      ,debug: true
  });
  $('form').validate({
      rules: {
          'student[student_id]': {
              required: true
              ,digits: true
          }
          ,'student[student_id2]': {
              required: true
              ,equalTo: '#student_student_id'
          }
      }
      ,messages: {
          'student[student_id]': {
              required: "Your student id is required."
              ,digits: "Your student id must be made up of digits."
          }
          ,'student[student_2]': {
              required: "Your student id is required."
              ,equalTo: "Please enter the same id in both fields."
          }
      }
  });
   */
 });
</script>
