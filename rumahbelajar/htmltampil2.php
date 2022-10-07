<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
   
<title>Bahan Ajar</title>
    
<!-- Bootstrap -->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/mapok.css" rel="stylesheet">
<link rel="icon" href="favicon.ico">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
<table class="framekonten">
<tbody>
<tr>
   <td width="79%"><img src="logo_rumah_belajar.png" width="315" height="70"></td>
   <td width="21%"><img src="logoOER70.png" width="201" height="70"></td>
</tr>
</tbody>
</table>
      
<table class="framekonten">
<tbody>
<tr class="kosong" bgcolor="#999999">
   <td colspan="3"></td>
</tr>
<tr><td>
<a id="unduh" href="../file_storage/learning_object/lo<?php echo $arg5 ?>/output_lo.zip">
<img style="margin: 20px 20px 0px 0px" align="right" src="logo_dl.png" width="25" height="25" border="0"></a>
</td></tr>
</tbody>
</table>
	
<div>
<table class="framekonten">
<tbody>
<tr>
	
<td>
<div class="frameteksisi">
<p align="center">
<object data="../file_storage/learning_object/lo<?php echo $arg5 ?>/story_html5.html" class="objek" style="overflow:hidden;padding:0;margin:0;top:0;right:0;width:850px;height:478px;" type="text/html">
</object>

</p>

</div>
</td>
</tr>
</tbody>
</table>

 
&nbsp;</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.11.2.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.js"></script>
  
</body>
</html>

<script>

var ratioWidth = 1024;
var ratioHeight = 576;

var ratioWidth = 850;
var ratioHeight = 478;



$(document).ready(function () {
	var timeOutFunction = false;
    $(window).resize(function() {
		if(timeOutFunction) clearTimeout(timeOutFunction);
        setTimeout(updateImageSize, 100);
    }).resize();
});

function updateImageSize() {
	var objectWidth = $('.objek').width();
	var objectHeight = ratioHeight/ratioWidth *  objectWidth;
	$('.objek').height(objectHeight);
	$('.objek').css("overflow: hidden");
};
</script>