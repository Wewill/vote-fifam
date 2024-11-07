<?php
echo(preg_match("/^[A-Z]{2}[-]\d{4}[-]\w{6}$/i",$_GET['v']));
/*
{echo("".$_GET['v']." = OK");}
else
	
{echo("".$_GET['v']." = NIET");}
*/

?>