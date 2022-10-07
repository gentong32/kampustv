<?php 
	error_reporting (E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
	$arg1 = $_GET['idlo'];
		
	//include('../file_storage/learning_object/lo_1/tampil_lo.html');
	
	?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
   
    <title>Learning Object</title>
    <!-- Bootstrap -->
	<link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/mapok.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

  </head>
  <body>

	  <table class="framekonten" border="0">
	    <tbody>
	      <tr>
    		<td width="79%"><img src="logo_rumah_belajar.png" width="315" height="70"></td>
    		<td width="21%"><img src="logoOER70.png" width="201" height="70"></td>
  			</tr>
        </tbody>
      </table>


  <table class="framekonten" border="0">
	    <tbody>
	      <tr class="kosong" bgcolor="#999999">
	        <td colspan="3"></td>
          </tr>
        </tbody>
      </table>
  
  
	  <table border="0" class="framekonten">
	    <tbody>
	      <tr>
	        <td class="framemenu1">
<div class="intrinsic-container">
<iframe src="../file_storage/learning_object/lo<?php echo $arg1 ?>/story_html5.html" class="center-block" allowfullscreen scrolling="no">
  <p>Your browser does not support iframes.</p>
</iframe>
</div>
<div class="intrinsic-container2" id="tambahan">
<a id="unduh" href="../file_storage/learning_object/lo<?php echo $arg1 ?>/output_lo.zip">Unduhan</a></p>
</div>
            </td>
          </tr>
        </tbody>
      </table>
  
    &nbsp;


	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
	<script src="js/jquery-1.11.2.min.js"></script>

	<!-- Include all compiled plugins (below), or include individual files as needed --> 
	<script src="js/bootstrap.js"></script>
  </body>
</html>
    
    <script language="javascript">
	$(document).ready(function(){
	
	//document.getElementById("tambahan").innerHTML = "<p><a id=\"unduh\" href=\"konten.zip\">Unduhan</a></p>";
	});
	</script>