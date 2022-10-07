<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//https://www.youtube.com/watch?v=xO51BDBhPWw

$jml_list = 0;
$do_not_duplicate = array();

foreach ($dafplaylist as $datane) {
	$jml_list++;
	$id_videolist[$jml_list] = $datane->id_video;
	$judulist[$jml_list] = $datane->judul;
	$do_not_duplicate[] = $datane->id_video;
	$durasilist[$jml_list] = $datane->durasi;
}

$jml_video = 0;
foreach ($dafvideoku as $datane) {
	if (in_array($datane->id_video, $do_not_duplicate)) {
		continue;
	} else {
		$do_not_duplicate[] = $datane->id_video;
		$jml_video++;
		$id_video[$jml_video] = $datane->id_video;
		$judul[$jml_video] = $datane->judul;
		$durasi[$jml_video] = $datane->durasi;
	}
}

$jml_videoall = 0;
foreach ($dafvideoku as $datane) {
	$jml_videoall++;
	$id_videoall[$jml_videoall] = $datane->id_video;
	$judulall[$jml_videoall] = $datane->judul;
	$durasiall[$jml_videoall] = $datane->durasi;
}

?>

<style>
	ul.source, ul.target {
		min-height: 50px;
		margin: 0px 25px 10px 0px;
		padding: 2px;
		border-width: 1px;
		border-style: solid;
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px;
		border-radius: 3px;
		list-style-type: none;
		list-style-position: inside;
	}

	ul.source {
		border-color: #f8e0b1;
	}

	ul.target {
		border-color: #add38d;
	}

	.source li, .target li {
		margin: 5px;
		padding: 5px;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
		text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
	}

	.source li {
		background-color: #fcf8e3;
		border: 1px solid #fbeed5;
		color: #c09853;
	}

	.target li {
		background-color: #ebf5e6;
		border: 1px solid #d6e9c6;
		color: #468847;
	}

	.sortable-dragging {
		border-color: #ccc !important;
		background-color: #fafafa !important;
		color: #bbb !important;
	}

	.sortable-placeholder {
		height: 40px;
	}

	.source .sortable-placeholder {
		border: 2px dashed #f8e0b1 !important;
		background-color: #fefcf5 !important;
	}

	.target .sortable-placeholder {
		border: 2px dashed #add38d !important;
		background-color: #f6fbf4 !important;
	}
</style>

<div class="sideBySide" style="text-align: center;margin-top: 65px">
	<div class="left" style="width: 300px;display: inline-block; margin-top: 60px; ">
		DAFTAR VIDEO YANG TERSEDIA
		<ul class="source connected">
			<?php
			for ($d=1;$d<=$jml_video;$d++) {
				echo '<div id="baris'.$id_video[$d].'"><li data-stock-symbol="'.$id_video[$d].'">'.$judul[$d].' ['.$durasi[$d].']<br><button onclick="pindahkanan('.$id_video[$d].')">Pindah</button>'.
				'</li></div>';
			} ?>

		</ul>
	</div>
	<div id="pilpil" class="right" style="width: 300px;display: inline-block;margin-top: 60px;">
		PLAY LIST PILIHAN
		<ul class="target connected">
		<!--<div id="pilpil">-->
			<?php
			for ($d=1;$d<=$jml_list;$d++) {
				echo '<div class="sasaran" id="baris'.$id_videolist[$d].'"><li data-stock-symbol="'.$id_videolist[$d].'">'.$judulist[$d].' ['.$durasilist[$d].']'.
				'<br><button onclick="pindahkiri('.$id_videolist[$d].')">Pindah</button>'.
				'</li></div>';
			} ?>
			<!--</div>-->
		</ul>
	</div>
</div>


<div id="manufacturer"></div>

<div style="text-align: center">
	<button onclick="updateValues()">Update</button>
</div>


<script src="https://www.youtube.com/iframe_api"></script>

<script type="text/javascript">
	$(function () {
		$(".source, .target").sortable({
			connectWith: ".connected"
		});
	});

	function updateValues() {
		var items = [];
		$(".sasaran").children().each(function () {
			//var item = $(this).text();
			var item = $(this).data("stock-symbol");
			items.push(item);
		});
		//$('#manufacturer').html(items);
		var jsonData = JSON.stringify(items);
		$.ajax({
			url: "<?php echo base_url(); ?>channel/updatelist",
			method: "POST",
			data: {datalist: jsonData},
			success: function (result) {
			window.open('<?php echo base_url(); ?>channel/guru/chusr'+<?php echo $this->session->userdata('id_user');?>, '_self');
			}
		})
	}
	
	function pindahkanan(id)
	{
		var judule = new Array();
		var ide = new Array();
		var durasie = new Array();
		var judulasal,durasiasal;
		
		<?php
		for ($a=1;$a<=$jml_videoall;$a++)
		{
			echo "judule[".$a."] = '".$judulall[$a]."';";
			echo "ide[".$a."] = '".$id_videoall[$a]."';";
			echo "durasie[".$a."] = '".$durasiall[$a]."';";
		}?>
		
		for (a=1;a<=<?php echo $jml_videoall;?>;a++)
		{
			if (ide[a]==id)
			{
				judulasal=judule[a];
				durasiasal=durasie[a];
			}
				
		}
		
		$('#baris'+id).remove();
		$('.target').append("<div class='sasaran' id='baris"+id+"'><li data-stock-symbol='"+id+"'>"+judulasal+" ["+durasiasal+"]<br><button onclick='pindahkiri("+id+")'>Pindah</button></li></div>");
	}
	
	function pindahkiri(id)
	{
		var judule = new Array();
		var ide = new Array();
		var durasie = new Array();
		var judulasal,durasiasal;

		<?php
		for ($a=1;$a<=$jml_videoall;$a++) {
			echo "judule[".$a."] = '".$judulall[$a]."';";
			echo "ide[".$a."] = '".$id_videoall[$a]."';";
			echo "durasie[".$a."] = '".$durasiall[$a]."';";
		}?>

		for (a=1;a<=<?php echo $jml_videoall;?>;a++) {
			if (ide[a]==id) {
				judulasal=judule[a];
				durasiasal=durasie[a];
			}
		}

		$('#baris'+id).remove();
		$('.source').append("<div id='baris"+id+"'><li data-stock-symbol='"+id+"'>"+judulasal+" ["+durasiasal+"]<br><button onclick='pindahkanan("+id+")'>Pindah</button></li></div>");
	}

</script>

