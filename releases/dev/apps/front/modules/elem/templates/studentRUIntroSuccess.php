<div class="inner">
    <div class="screen-intro">
        <div id="player1"></div>
        <div id="jp_container_1" class="player">
            <a href=#" class="jp-play"><img src="<?php echo image_path('sh/rev_audio_unselected_small.png') ?>" /></a>
            <a href=#" class="jp-pause"><img src="<?php echo image_path('sh/rev_audio_selected_small.png') ?>" /></a>
        </div>
        <div class="right">
            <ul>
                <li>This is different than most other tests you'll take.</li>
                <li>It is not a test about how much math or vocabulary, or how many facts you know.</li>
                <li>It asks you questions about your beliefs, feelings, and ideas.</li>
                <li>Listen to or read the instructions and pick the answers that best match YOU.</li>
            </ul>
        </div>
    </div>
</div>

<div class="navigation">
    <a href="#" class="btn-back"><img class="back" src="<?php echo image_path('sh/rev_text_back.png') ?>" alt="Back"/></a>
    <a href="#" class="btn-next"><img src="<?php echo image_path('sh/rev_text_next.png') ?>" class="next" class="next" alt="Next"/></a>
</div>

<style>
    hr.progress { width: 6% }
</style>

<script>
  $(document).on('click', '.navigation a.btn-back', function(e) {
      e.preventDefault();

      $('.btn-back').animate({left:'-=100'}, 300, function(){
          window.location = '<?php echo url_for('elem_ru_student_demographics', array('assessment'=>$assessment, 'school'=>$school, 'sid'=>$sid)) ?>#a';
      });
  });

  $(document).on('click', '.btn-next', function(e){
      $('.btn-next').animate({left:'+=100'}, 300, function(){
          window.location = '<?php echo url_for('elem_question_page', array('assessment'=>$assessment, 'school'=>$school, 'page'=>6, 'sid'=>$sid)) ?>#a';
      });
  });

  $(function(){
    $('.pages-on').html(6);

    $("#player1").jPlayer({
      ready: function () {
        $(this).jPlayer("setMedia", {
          mp3: "<?php echo image_path('/audio/others/intro_scr6.mp3') ?>",
          oga: "<?php echo image_path('/audio/others/intro_scr6.ogg') ?>"
        });
      },
      swfPath: "<?php echo image_path('/js') ?>",
      supplied: "mp3, oga"
    });

    preload([
        '<?php echo image_path('sh/assess/rev_radio_i_large.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_ii_large.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_iii_large.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_iv_large.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_v_large.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_1.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_2.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_3.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_4.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_5.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_a_large.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_b_large.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_c_large.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_d_large.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_e_large.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_a.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_b.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_c.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_d.jpg?v=3') ?>'
        ,'<?php echo image_path('sh/assess/rev_radio_e.jpg?v=3') ?>'
    ]);
  });

  function preload(imgs) {
      $(imgs).each(function(){
          (new Image()).src = this;
      });
  }

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
