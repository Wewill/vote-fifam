<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

$au=explode("?",$_SERVER['REQUEST_URI'])[0];
if (   $au!="/index.php" 
	&& $au!="/mod-mdp.php" 
	&& $au!="/raz-mdp.php" 
	&& $au!="/coin.php" 
	&& $au!="/enr.php" 
	&& $au!="/dem-mdp.php" 
	&& $au!="/upd-mdp.php" 
	&& $_SESSION["qui"]=="") 
	{header('Location:index.php');}
setlocale (LC_TIME,'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8','fra');
$cbdd = new PDO('mysql:host=localhost:3306;dbname=vote_fifam_fr', 'vote_fifam_fr', 'PlS9DF7JaS9A71JSA');
$clef="Argentique";
function encrypt($in, $k)
{
	$out = '';
	for($i=0; $i<strlen($in); $i++)
	{
		$char = substr($in, $i, 1);
		$keychar = substr($k, ($i % strlen($k))-1, 1);
		$char = chr(ord($char)+ord($keychar));
		$out .= $char;
	}
	return (base64_encode($out));
}
function decrypt($in, $k)
{
	$out = '';
	$in = base64_decode($in);

	for($i=0; $i<strlen($in); $i++)
	{
		$char = substr($in, $i, 1);
		$keychar = substr($k, ($i % strlen($k))-1, 1);
		$char = chr(ord($char)-ord($keychar));
		$out .= $char;
	}
	return ($out);
}
function nty($in)
{
	$out = htmlentities(htmlspecialchars(stripslashes($in)));
	return ($out);
}
function corr($in,$pn)
	{
	if ($pn=='n')
		{
		$av=array('à','á','â','ä','À','Á','Â','Ä','é','è','ê','ë','È','É','Ê','Ë','í','ì','î','ï','Ì','Í','Î','Ï','ò','о́','ô','ö','Ò','Ó','Ô','Ö','ù','ú','û','ü','Ù','Ú','Û','Ü','ý','ÿ','Ý','Ÿ','ç','Ç');
		$ap=array('A','A','A','A','A','A','A','A','E','E','E','E','E','E','E','E','I','I','I','I','I','I','I','I','O','O','O','O','O','O','O','O','U','U','U','U','U','U','U','U','Y','Y','Y','Y','C','C');
		}
		else
		{
		$av=array('-à','-á','-â','-ä','-À','-Á','-Â','-Ä','-é','-è','-ê','-ë','-È','-É','-Ê','-Ë','-í','-ì','-î','-ï','-Ì','-Í','-Î','-Ï','-ò','-о́','-ô','-ö','-Ò','-Ó','-Ô','-Ö','-ù','-ú','-û','-ü','-Ù','-Ú','-Û','-Ü','-ý','-ÿ','-Ý','-Ÿ','-ç','-Ç','ç','Ç');
		$ap=array('-A','-A','-A','-A','-A','-A','-A','-A','-E','-E','-E','-E','-E','-E','-E','-E','-I','-I','-I','-I','-I','-I','-I','-I','-O','-O','-O','-O','-O','-O','-O','-O','-U','-U','-U','-U','-U','-U','-U','-U','-Y','-Y','-Y','-Y','-C','-C','c','C');
		}
	$in=str_replace($av, $ap,'-'.$in);
	$in=substr($in,-(strlen($in)-1));
	return($in);
	}
?>
