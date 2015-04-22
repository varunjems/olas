<?php
$rawQuestions = $sf_data->get('questions', ESC_RAW);

$firstQuestion = $rawQuestions[0];
$startProgress = 7;
$remainingProgress = 100 - $startProgress;
$totalQuestions = 55;
$progress = $startProgress + floor(($remainingProgress/$totalQuestions)*($firstQuestion['question_number']));

$scale = array('i', 'ii', 'iii', 'iv', 'v');
$scaleImages = array(1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5');
$scaleAudio = array(1=>'agree1', 2=>'agree2', 3=>'agree3', 4=>'agree4', 5=>'agree5');
if ($page == 7) {
    $scale = array('a', 'b', 'c', 'd', 'e');
    $scaleImages = array(1=>'a', 2=>'b', 3=>'c', 4=>'d', 5=>'e');
    $scaleAudio = array(1=>'conf1', 2=>'conf2', 3=>'conf3', 4=>'conf4', 5=>'conf5');
}

$qCounts = array(8, 10, 8, 10, 10, 9);
//$sectionPages = array(4, 8, 7, 9, 10, 7);
$firstPage = array(7, 11, 16, 20, 25, 30);
$totalPages = 34;

if ($page > 6) {
    $backPage = url_for('elem_question_page', array('assessment'=>$assessment, 'school'=>$school, 'page'=>$page-1, 'sid'=>$sid));
} else {
    $backPage = url_for('elem_ru_student_intro', array('assessment'=>$assessment, 'school'=>$school, 'sid'=>$sid));
}
if ($page < 12) {
    $nextPage = url_for('elem_question_page', array('assessment'=>$assessment, 'school'=>$school, 'page'=>$page+1, 'sid'=>$sid));
} else {
    $nextPage = url_for('elem_complete_page', array('assessment'=>$assessment, 'school'=>$school, 'sid'=>$sid));
}
?>
<style>
    hr.progress { width: <?php echo $progress ?>% }
</style>

<div id="player1"></div>
<div id="playerScale"></div>
<div class="block-intro inner">
    <div id="jp_container_1" class="player">
        <a href=#" class="jp-play"><img src="<?php echo image_path('sh/rev_audio_unselected_small.png') ?>" /></a>
        <a href=#" class="jp-pause"><img src="<?php echo image_path('sh/rev_audio_selected_small.png') ?>" /></a>
    </div>
    <div id="jp_container_scale" class="player">
        <a href=#" class="jp-play"></a>
        <a href=#" class="jp-pause"></a>
    </div>
    <div class="instructions right">
        <?php echo $qPage->getIntro(ESC_RAW) ?>

        <table class="table-instructions">
            <tr>
                <?php foreach ($scale as $key=>$img): ?>
                <td><input type='radio' name='scaledemo' class='r-large scaleaudio' value='<?php echo $key+1; ?>' data-sdb-image='url("<?php echo image_path("sh/assess/rev_radio_{$img}_large.jpg?v=3") ?>")'/></td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($scaleValues as $value): ?>
                    <td><?php echo strtolower($value['description']) ?></td>
                <?php endforeach; ?>
            </tr>
        </table>
    </div>
</div>

<div class="block-questions" style="display:none;">
    <form method='post' action='#a'>
        <?php echo $qPage->getInstructions(ESC_RAW) ?>

        <table class='table-questions' cellspacing='0' cellpadding='0' border='0'>
            <thead>
                <tr>
                    <td class='header-player'></td>
                    <td class='header-values'></td>
                    <?php foreach ($scaleValues as $value): ?>
                        <th scope='col' class='header-scale'><?php echo strtolower($value['description']) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>

            <tbody>
                <?php
                $row = 0;
                foreach ($rawQuestions as $question):
                    $qNum = $question['question_number'];
                ?>
                    <tr id="qr_<?php echo $qNum ?>" align='left' scope='row' class='q-row <?php echo ((++$row)%2==1?'odd':'even') ?>'>
                        <th id="pc_<?php echo $qNum ?>" class="pc"><div class="qp" id="qp_<?php echo $qNum ?>" data-aId="<?php echo $row ?>"></div><div class="pc_controls"><a href=#" class="jp-play"><img class="speaker speaker-unselected" src="<?php echo image_path('sh/rev_audio_unselected_small.png') ?>" /></a><a href=#" class="jp-pause"><img class="speaker speaker-selected" src="<?php echo image_path('sh/rev_audio_selected_small.png') ?>" /></a></div></th>
                        <th><?php echo $question['question'] ?></th>
                        <?php foreach ($scaleValues as $value): ?>
                        <td align='center'><input type='radio' class='r-small' name='q_<?php echo $qNum ?>' value='<?php echo $value['value'] ?>' data-sdb-image='url("<?php echo image_path("sh/assess/rev_radio_{$scaleImages[$value['value']]}.jpg?v=3") ?>")' <?php echo (($value['value'] == $question['answer'])?'checked ':'') ?>/></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>
</div>

<div class="navigation">
    <a href="#" class="btn-back"><img class="back" src="<?php echo image_path('sh/rev_text_back.png') ?>" alt="Back"/></a>
    <a href="#" class="btn-next"><img class="next" src="<?php echo image_path('sh/rev_text_next.png') ?>" alt="Next"/></a>
</div>

<div class="skip-dialogue" style="display: none;">
    <div class="skip-inner">
        <span class="skip-statement">Are you sure you want to skip answers?</span>
        <div class="skip-btns">
            <button class="btn-skip btn-yes">Yes, continue</button>
            <button class="btn-skip btn-no">No, cancel</button>
        </div>
    </div>
</div>

<script>
    var
        introDone = 0
        ,player = null
        ,pg = <?php echo $page ?>
        ,sections = ["ed", "conf", "conn", "stre", "well", "moti"]
        ,sectionQCount = <?php echo json_encode($qCounts) ?>
        ,section = sections[pg-6]
        ,firstPage = <?php echo json_encode($firstPage) ?>
        ,progressPg = firstPage[pg-6]
        ,qAt = 0
        ,questions = null
        ,qSet = null
        ,progressStart = <?php echo $startProgress ?>
        ,progressRemain = <?php echo $remainingProgress ?>
        ,totalQuestions = <?php echo $totalQuestions ?>
        ,firstQuestion = <?php echo $firstQuestion['question_number'] ?>
        ,nextBtn = null
        ,nextPageUrl = '<?php echo $nextPage ?>'
        ,backPageUrl = '<?php echo $backPage ?>'
        ,scaleAudio = <?php echo json_encode($scaleAudio) ?>
        ,skipQuestions = false
        ;

    function checkRadioButtons() {
        var checked = $('input:checked', qSet);
        if (checked.length == qSet.length) {
            nextBtn.removeClass('disabled');
        }
    }

    function showNextSet(nextUrl) {
        $('hr.progress').css('width', ''+(progressStart+Math.floor((progressRemain/totalQuestions)*(firstQuestion+qAt)))+'%');
        $('.pages-on').html(progressPg);
        var nextSet = questions.slice(qAt, qAt+3);

        if (!nextSet.length) {
            window.location = nextUrl+'?pg='+progressPg+'#a';
        } else {
            qSet.hide();
            hideSkipDialogue();
            nextBtn.fadeOut(0);
            backBtn.fadeOut(0);
            //nextSet.show();
            var cnt = 0;
            nextSet.each(function(i){
                $(this).fadeOut(0).delay((i+1)*300).fadeIn(0);
                cnt+=1;
            });
            nextBtn.css('left',0).fadeOut(0).delay((cnt+1)*300).fadeIn(0);
            backBtn.css('left',0).fadeOut(0).delay((cnt+1)*300).fadeIn(0);
            qSet = nextSet;
            checkRadioButtons();

            nextBtn.removeClass('restrict');
            backBtn.removeClass('restrict');
        }
    }

    $(document).on('change', 'input[type=radio]', function(e) {
        checkRadioButtons();
    });

    $(document).on('click', '.navigation a.btn-back', function(e) {
        e.preventDefault();

        if ($(this).hasClass('disabled') || $(this).hasClass('restrict')) {
            return;
        }

        player.jPlayer("pause");
        player.jPlayer("pauseOthers");


        nextBtn.addClass('restrict');
        backBtn.addClass('restrict');

        // If intro then just go back to previous page
        if (!introDone) {
            backBtn.animate({left:'-=100'}, 300, function(){
                if (pg == 6) {
                    window.location = backPageUrl+'#a';
                } else {
                    var prevPg = firstPage[pg-6]-1;
                    window.location = backPageUrl+'?pg='+prevPg+'#a';
                }
            });
            return;
        }

        // Otherwise save and show previous questions (or intro)
        backBtn.animate({left:'-=100'}, 300, function(){
        });
        $.post("", $('input[type=radio]', qSet).serialize(), function(data){
        }).done(function(){
            backBtn.promise().done(function(){
                if (qAt == 0) {
                    //show intro again
                    introDone = 0;
                    questions.hide();
                    $('.block-questions').hide();
                    $('.block-intro').show();
                    nextBtn.removeClass('restrict');
                    backBtn.removeClass('restrict');
                    backBtn.css('left',0);
                } else {
                    qAt -= 3; // Skip back by 3s
                    progressPg--;
                    showNextSet(backPageUrl);
                }
            });
        });
    });

    $(document).on('click', '.navigation a.btn-next', function(e) {
        e.preventDefault();

        if ($(this).hasClass('disabled') || $(this).hasClass('restrict')) {
            return;
        }

        player.jPlayer("pause");
        player.jPlayer("pauseOthers");

        if (!introDone) {
            introDone = 1;
            nextBtn.addClass('restrict');
            backBtn.addClass('restrict');
            nextBtn.animate({left:'+=100'}, 300, function(){
                $('.block-intro').hide();
                questions.hide();
                $('.block-questions').show();
                //qSet.show();
                progressPg++;
                $('.pages-on').html(progressPg);
                var cnt = 0;
                qSet.each(function(i){
                    $(this).fadeOut(0).delay((i+1)*300).fadeIn(0);
                    cnt+=1;
                });
                nextBtn.removeClass('restrict');
                backBtn.removeClass('restrict');
                nextBtn.css('left',0).fadeOut(0).delay((cnt+1)*300).fadeIn(0);
                backBtn.css('left',0).fadeOut(0).delay((cnt+1)*300).fadeIn(0);
                checkRadioButtons();
            });
            return;
        }

        if (qSet.length) { // Do not check if on intro page
            // Double check that all items in qSet are filled in
            var checked = $('input:checked', qSet);
            if (checked.length < qSet.length && !skipQuestions) {
                showSkipDialogue();
                return;
            }
            skipQuestions = false;

            // Submit items from qSet
            nextBtn.addClass('restrict');
            backBtn.addClass('restrict');
            nextBtn.animate({left:'+=100'}, 300, function(){
            });
            $.post("", $('input[type=radio]', qSet).serialize(), function(data){
            }).done(function(){
                nextBtn.promise().done(function(){
                    qAt += qSet.length;
                    progressPg++;
                    showNextSet(nextPageUrl);
                });
            });
        }
    });


    function showSkipDialogue() {
        $('div.overlay').show();
        $('div.skip-dialogue').show();
    }

    function hideSkipDialogue() {
        $('div.skip-dialogue').hide();
        $('div.overlay').hide();
    }

    $(document).on('click', '.btn-no', function(e) {
        hideSkipDialogue();
    });

    $(document).on('click', '.btn-yes', function(e) {
        hideSkipDialogue();
        skipQuestions = true;
        $('.navigation .btn-next').trigger('click');
    });


    function getURLParameter(name) {
        return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
    }

    $(function(){
        player = $('#player1');
        nextBtn = $('a.btn-next');
        backBtn = $('a.btn-back');
        questions = $('.q-row');
        qSet = questions.slice(qAt, 3);
        pSkip = getURLParameter('pg');

        if (pSkip && pSkip == progressPg) {
            // Show all questions
        } else if (pSkip && pSkip > progressPg && pSkip <= (progressPg+(Math.ceil(sectionQCount[pg-6]/3)))) {
            // Go to specific "page" (last of set usually)
            introDone = 1;
            $('.block-intro').hide();

            questions.hide();
            $('.block-questions').show();

            nextBtn.fadeOut(0);
            backBtn.fadeOut(0);

            progressPg++;
            while (pSkip != progressPg) {
                qAt += qSet.length;
                qSet = questions.slice(qAt, qAt+3);
                progressPg++;
            }

            var cnt = 0;
            qSet.each(function(i){
                $(this).fadeOut(0).delay((i+1)*300).fadeIn(0);
                cnt+=1;
            });
            nextBtn.css('left',0).fadeOut(0).delay((cnt+1)*300).fadeIn(0);
            backBtn.css('left',0).fadeOut(0).delay((cnt+1)*300).fadeIn(0);
            checkRadioButtons();
        } else {
            var checked = $('input:checked', qSet);
            while (checked.length && checked.length == qSet.length) {
                // Skips past answered questions
                qAt += qSet.length;
                qSet = questions.slice(qAt, qAt+3);
                progressPg++;
                if (!qSet.length) {
                    window.location = nextPageUrl+'#a';
                }
                checked = $('input:checked', qSet);
            }
        }

        $('hr.progress').css('width', ''+(progressStart+Math.floor((progressRemain/totalQuestions)*(firstQuestion+qAt)))+'%');
        $('.pages-on').html(progressPg);

        $('input.r-large:radio').screwDefaultButtons({
                image: 'url("<?php echo image_path('sh/assess/rev_radio_i_large.jpg?v=3') ?>")',
                width:141,
                height:88
        });

        $("#player1").jPlayer({
            ready: function () {
                $(this).jPlayer("setMedia", {
                    mp3: "<?php echo image_path('/audio') ?>/intros/"+section+"_intro.mp3",
                    oga: "<?php echo image_path('/audio') ?>/intros/"+section+"_intro.ogg"
                });
            },
            play: function() {
                $(this).jPlayer("pauseOthers");
            },
            swfPath: "<?php echo image_path('/js') ?>",
            supplied: "oga, mp3",
            cssSelectorAncestor: "#jp_container_1"
        });

        $("#playerScale").jPlayer({
            ready: function () {
                $(this).jPlayer("setMedia", {
                    mp3: "<?php echo image_path('/audio/scales/scale_agree1.mp3') ?>",
                    oga: "<?php echo image_path('/audio/scales/scale_agree1.ogg') ?>"
                });
            },
            play: function() {
                $(this).jPlayer("pauseOthers");
            },
            swfPath: "<?php echo image_path('/js') ?>",
            supplied: "oga, mp3",
            cssSelectorAncestor: "#jp_container_scale"
        });

        $('div.scaleaudio').click(function(e){
            var
                t = $(e.target).find('input.scaleaudio')
                ,player = $('#playerScale')
                ;

            player.jPlayer('setMedia', {
                mp3: "<?php echo image_path('/audio') ?>/scales/scale_"+scaleAudio[t.val()]+".mp3",
                oga: "<?php echo image_path('/audio') ?>/scales/scale_"+scaleAudio[t.val()]+".ogg"
            });
            player.jPlayer('play');
        });

        $('input.r-small:radio').screwDefaultButtons({
                image: 'url("<?php echo image_path('sh/assess/rev_radio_1.jpg?v=3') ?>")',
                width:81,
                height:52
        });

        $('.qp').each(function(){
            var $this = $(this), qid = $this.attr('id').replace(/qp_/, ''), aid = $this.data('aid');

            $this.jPlayer({
                ready: function () {
                    $(this).jPlayer("setMedia", {
                        mp3: "<?php echo image_path('/audio') ?>/"+section+aid+".mp3",
                        oga: "<?php echo image_path('/audio') ?>/"+section+aid+".ogg"
                    });
                },
                play: function() {
                    $(this).jPlayer("pauseOthers");
                },
                swfPath: "<?php echo image_path('/js') ?>",
                supplied: "oga, mp3",
                cssSelectorAncestor: "#pc_"+qid
            });
        });
    });

var history_api = typeof history.pushState !== 'undefined'
if ( location.hash == '#a' ) {
  if ( history_api ) { history.pushState(null, '', '#b'); }
  else { location.hash = '#b'; }
  window.onhashchange = function() {
    if ( location.hash == '#a' ) {
      alert("Using the back button is not supported in this application.")
      if ( history_api ) { history.pushState(null, '', '#b'); }
      else { location.hash = '#b'; }
    }
  }
}
</script>
