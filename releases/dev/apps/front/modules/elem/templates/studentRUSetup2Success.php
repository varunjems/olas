<div id="player1"></div>
<div id="jp_container_1" class="player">
    <a href=#" class="jp-play"><img src="<?php echo image_path('sh/rev_audio_unselected_small.png') ?>" /></a>
    <a href=#" class="jp-pause"><img src="<?php echo image_path('sh/rev_audio_selected_small.png') ?>" /></a>
</div>
<div id="setup-2form" class="form right">
    <form class="frm-setup frm-d2" method="post" action="#a">
        <?php echo $form->renderHiddenFields() ?>
        <?php if ($form->hasGlobalErrors()): ?>
        <?php echo $form->renderGlobalErrors() ?>
        <?php endif; ?>

        <div class="control-group">
            <?php //echo $form['class_id']->renderLabel() ?>
            <?php if ($form['class_id']->hasError()): ?>
            <?php echo $form['class_id']->renderError() ?>
            <?php endif; ?>
            <label for="ru_class_id">My class number is:</label>
            <?php echo $form['class_id']->render() ?>
        </div>

        <div class="control-group">
            <?php //echo $form['teacher']->renderLabel() ?>
            <?php if ($form['teacher']->hasError()): ?>
            <?php echo $form['teacher']->renderError() ?>
            <?php endif; ?>
            <label for="ru_teacher">My teacher's name is:</label>
            <?php echo $form['teacher']->render() ?>
        </div>
    </form>
</div>
<div class="navigation">
    <a href="#" class="btn-back"><img class="back" src="<?php echo image_path('sh/rev_text_back.png') ?>" alt="Back"/></a>
    <button class="btn-next disabled"><img src="<?php echo image_path('sh/rev_text_next.png') ?>" class="next" alt="Next"/></button>
</div>

<style>
    hr.progress { width: 4% }
</style>

<script>
    $(document).on('keyup', 'input:text', function(e) {
        $(this).trigger('change');
    });

    $(document).on('change', 'form', function(e) {
        var enable = 1;

        if ($('#ru_class_id').val().match(/^\d{1,2}$/) === null) {
            enable = 0;

            if (!$('#ru_class_id').val()) {
                $('#ru_class_id').removeClass('error');
            } else {
                $('#ru_class_id').addClass('error');
            }
        } else {
            $('#ru_class_id').removeClass('error');
        }

        if ($('#ru_teacher').val().length < 2) {
            enable = 0;
        }

        if (enable) {
            $('.btn-next').removeClass('disabled');
        } else {
            $('.btn-next').addClass('disabled');
        }
    });

  $(document).on('click', '.navigation a.btn-back', function(e) {
      e.preventDefault();

      $('.btn-back').animate({left:'-=100'}, 300, function(){
          window.location = '<?php echo url_for('elem_student_basics', array('assessment'=>$assessment, 'school'=>$school, 'sid'=>$sid)) ?>#a';
      });
  });

  $(document).on('click', '.btn-next', function(e){
      // TODO: Check that the form is valid with js
      if ($('.btn-next').hasClass('disabled')) {
          e.preventDefault();
          return;
      }
      
      $('.btn-next').animate({left:'+=100'}, 300, function(){
          $('form').submit();
      });
  });

 $(function(){
  $('.pages-on').html(4);

  $('form').trigger('change');

  $("#player1").jPlayer({
   ready: function () {
    $(this).jPlayer("setMedia", {
      mp3: "<?php echo image_path('/audio/others/class_number_scr4.mp3') ?>",
      oga: "<?php echo image_path('/audio/others/class_number_scr4.ogg') ?>"
    });
   },
   swfPath: "/js",
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
