<?php 

	require_once "session.php";
	require_once "global.php";
	include ("xssfunc.php");
	error_reporting (E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
	
	$arg1 = $_GET['idmateri'];
	$arg2 = $_GET['menu'];
	
	function callback($buffer)
{
	$arg1 = $_GET['idmateri'];
	
	
	return(str_replace("css/", "../file_storage/kontenweb/konweb".$arg1."/css/", $buffer));
    //return(str_replace("media/", "../file_storage/materi_pokok/mp16_1/media/", $buffer));
}
function callback2($buffer)
{
	$arg1 = $_GET['idmateri'];

	//return(str_replace("css/", "../file_storage/materi_pokok/mp16_1/css/", $buffer));
    return(str_replace("media/", "../file_storage/kontenweb/konweb".$arg1."/media/", $buffer));
}
ob_start("callback");
ob_start("callback2");
//include 'foo.php';

		
	if($arg2>1)
	include('../file_storage/kontenweb/konweb'.$arg1.'/menu'.$arg2.'.html');
	else
	include('../file_storage/kontenweb/konweb'.$arg1.'/index.html'); 
ob_end_flush();
	?>
    
    <script language="javascript">
		document.getElementById("tambahan").innerHTML = "<p class=\"teksmenu\"><a id=\"unduh\" href=\"../file_storage/kontenweb/konweb<?php echo $arg1?>/konweb.zip\">Unduh</a></p>";
		document.getElementById("menu1").href = "/rumahbelajar/tampilajar.php?ver=41&idmateri=<?php echo $arg1?>";
	for (var $a=2;$a<=10;$a++)
	{
	document.getElementById("menu"+$a).href = "/rumahbelajar/tampilajar.php?ver=41&idmateri=<?php echo $arg1?>&menu="+$a;
	}
	$(document).ready(function(){
		alert("NI BISA");
	document.getElementById("menu1").href = "/rumahbelajar/tampilajar.php?ver=41&idmateri=<?php echo $arg1?>";
	for (var $a=2;$a<=10;$a++)
	{
	document.getElementById("menu"+$a).href = "/rumahbelajar/tampilajar.php?ver=41&idmateri=<?php echo $arg1?>&menu="+$a;
	}
	document.getElementById("tambahan").innerHTML = "<p class=\"teksmenu\"><a id=\"unduh\" href=\"../file_storage/kontenweb/konweb<?php echo $arg1?>/konweb.zip\">Unduh</a></p>";
	});
	</script>
   