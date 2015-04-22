<p class="message-complete">
    <?php echo __('Thank you for completing %assessment%.', array('%assessment%'=>__('the Clear Path Survey'))) ?>
</p>
<p class="message-next-assessment">
    <?php echo __('New student? %link% to begin %assessment%.', array('%link%'=>link_to(__('Click here'), array('sf_route'=>'language_choice_sid', 'assessment'=>$assessment, 'school'=>$school, 'sid'=>$sid)),'%assessment%'=>__('the Clear Path Survey'))) ?>
</p>
