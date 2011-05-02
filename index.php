<?php
		
	ob_start();
	require_once('FirePHPCore/FirePHP.class.php');
	
	$firephp = FirePHP::getInstance(true);
	
	$var = array('i'=>10, 'j'=>20);
	$firephp->log($var, 'Iterators');
?>
<html><body>
<script type="text/javascript">
console.debug('testing firebug');
</script></body>
</html>