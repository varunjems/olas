<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $sf_user->getCulture() ?>" lang="<?php echo $sf_user->getCulture() ?>">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="<?php echo image_path('/favicon.ico') ?>" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <!--[if lte IE 6]>
    <link rel="stylesheet" type="text/css" href="<?php echo image_path('/css/ie6.css') ?>" />
    <![endif]-->
  </head>
  <body>
<div id="header">
<div id="shlogo"></div>
<div id="product" class="<?php if (get_slot('product')) { include_slot('product'); } else { echo 'p-none'; } ?> <?php if (get_slot('showes') == 'es') { echo 'l-es'; } else { echo 'l-'.$sf_user->getCulture(); } ?>">
    <div class="l-es p-ru">Nivel 2, Forma A</div>
    <div class="l-es p-mo">Nivel 2, Forma B</div>
    <div class="l-en p-ru">Level 2, Form A</div>
    <div class="l-en p-mo">Level 2, Form B</div>
</div>
<div class="clear"></div>
<hr class="bar" />
</div>
<div id="content">
    <?php echo $sf_content ?>
</div>
<br />
<br />
<hr class="bar" />
<div id="footer">
<!-- Copyright 2010 - 2014 Wevad Consulting Group, Contact: sales@wevad.com -->
<!-- Licensed to ScholarCentric -->
<!-- ScholarCentric logos Copyright 2010-2014 ScholarCentric -->
    <div id="copyright">Copyright 2014 ScholarCentric</div>
    <img id="clogo" src="<?php echo image_path('SCLogoWhite-2.png') ?>"/>
    <div class="clear"></div>
</div>
  </body>
</html>
