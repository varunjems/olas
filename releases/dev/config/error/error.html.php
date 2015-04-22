<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php $path = sfConfig::get('sf_relative_url_root', preg_replace('#/[^/]+\.php5?$#', '', isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : (isset($_SERVER['ORIG_SCRIPT_NAME']) ? $_SERVER['ORIG_SCRIPT_NAME'] : ''))) ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="symfony project" />
<meta name="robots" content="index, follow" />
<meta name="description" content="symfony project" />
<meta name="keywords" content="symfony, project" />
<meta name="language" content="en" />
<title>symfony project</title>

<link rel="shortcut icon" href="/favicon.ico" />
<?PHP /*
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/sf/sf_default/css/screen.css" />
<!--[if lt IE 7.]>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/sf/sf_default/css/ie.css" />
<![endif]-->
*/ ?>
<link rel="stylesheet" type="text/css" media="screen" href="/css/main.css" />


</head>
<body>

<div id="header">
<div id="shlogo"></div>
<div id="product"></div>
<div class="clear"></div>
<div class="bar"</div>
</div>
<div id="content">

<div class="sfTContainer">
  <div class="sfTMessageContainer sfTAlert">
    <img alt="page not found" class="sfTMessageIcon" src="<?php echo $path ?>/sf/sf_default/images/icons/tools48.png" height="48" width="48" />
    <div class="sfTMessageWrap">
      <h1>Oops! An Error Occurred</h1>
      <h5>The server returned a "<?php echo $code ?> <?php echo $text ?>".</h5>
    </div>
  </div>

<?php /*
  <dl class="sfTMessageInfo">
    <dt>Something is broken</dt>
    <dd>Please e-mail us at [email] and let us know what you were doing when this error occurred. We will fix it as soon as possible.
    Sorry for any inconvenience caused.</dd>

    <dt>What's next</dt>
    <dd>
      <ul class="sfTIconList">
        <li class="sfTLinkMessage"><a href="javascript:history.go(-1)">Back to previous page</a></li>
        <li class="sfTLinkMessage"><a href="/">Go to Homepage</a></li>
      </ul>
    </dd>
  </dl>
 */ ?>
</div>

</div>
<div class="bar"</div>
<div id="footer">
<div id="clogo"></div>
<div class="clear"></div>
</div>
<div style="font-size: small">&copy;2010 ScholarCentric</div>
</body>
</html>
