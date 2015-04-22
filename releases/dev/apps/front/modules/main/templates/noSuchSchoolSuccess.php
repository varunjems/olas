The URL entered is invalid.<br />
<br />
<?php
	$url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$url = preg_replace('/\/('.$school.')(\/|$)/', '/<strong style="color: #ee0000;">$1</strong>$2', $url);

	echo $url;
?>
