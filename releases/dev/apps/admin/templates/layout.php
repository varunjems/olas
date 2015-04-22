<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
<div id="header">
<div id="logout" style="float: right;">
<?php
if ($sf_user->isAuthenticated()) {
	echo link_to('Logout', '@sf_guard_signout');
}
?>
</div>
</div>
    <?php echo $sf_content ?>
<!-- Copyright 2010-2014 Wevad Consulting Group, Contact: sales@wevad.com -->
<!-- Licensed to ScholarCentric -->
<!-- ScholarCentric logos Copyright 2010-2014 ScholarCentric -->
  </body>
</html>
