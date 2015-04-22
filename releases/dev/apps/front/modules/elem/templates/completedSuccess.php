<div id="player1"></div>
<div class="message-complete">
    <p>
        <span id="jp_container_2" class="player">
            <a href=#" class="jp-play"><img src="<?php echo image_path('sh/rev_audio_unselected_small.png') ?>" /></a>
            <a href=#" class="jp-pause"><img src="<?php echo image_path('sh/rev_audio_selected_small.png') ?>" /></a>
        </span>
        You did it!  Nicely done.
    </p>
    <img src="<?php echo image_path('sh/rev_reward_done.png') ?>" />
</div>
<p class="message-next-assessment">
    <?php echo link_to('Make this computer or device ready for the next student', array('sf_route'=>'elem_student_signin_sid', 'assessment'=>$assessment, 'school'=>$school, 'sid'=>$sid)) ?>
</p>

<style>
    hr.progress { width: 100% }
</style>

<script>
 $(function(){
  $('.pages-on').html(34);

  $("#player1").jPlayer({
   ready: function () {
    $(this).jPlayer("setMedia", {
        mp3: "<?php echo image_path('/audio/others/nicely_done.mp3') ?>",
        oga: "<?php echo image_path('/audio/others/nicely_done.ogg') ?>"
    });
   },
   swfPath: "<?php echo image_path('/js') ?>",
   supplied: "mp3, oga",
   cssSelectorAncestor: "#jp_container_2"
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
