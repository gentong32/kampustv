<?php
defined('BASEPATH')OR exit('No direct script access allowed');

$jml_pernyataan = 0;
foreach ($dafpernyataan as $datane)
{
	$jml_pernyataan++;
	$nama_penilaian[$jml_pernyataan]=$datane->nama_penilaian;
	$wajibya[$jml_pernyataan]=$datane->wajibya;
}

for ($c1=1;$c1<=10;$c1++)
{
	$cek[$c1][1]="";
	$cek[$c1][2]="";
	$cek[$c1][$dafpenilaian[0]['penilaian'.$c1]]="checked='checked'";
}

$textjenis = Array('','Intstruksional','Non Instruksional');

$thumbs = $datavideo['thumbnail'];
if (substr($thumbs,0,4)!="http" && $thumbs!="")
	$thumbs="<?php echo base_url(); ?>uploads/thumbs/".$thumbs;

//checked='checked';

?>

<div class="row" style="margin-top: 60px;">
	<?php
		echo form_open('video/simpanverifikasi');
	?>
	<div class="col-md-5 col-md-offset-1" >
    	<div class="well bp-component" style="background-color: white">
			<fieldset>

			<div id="isi_profil">
                <legend>Data Video</legend>

				<div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Thumbnail</label>
                    <div class="col-md-12">
					<img style="align:middle;width:200px;" src="<?php echo $thumbs;?>">
                    </div>
				</div>

				<div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Durasi</label>
                    <div class="col-md-12">
					  <input type="text" disabled style="color:black; width:60px;" value="<?php 
					  echo $datavideo['durasi'];?>">
                    </div>
				</div>

				<div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Topik</label>
                    <div class="col-md-12">
					  <input type="text" disabled style="color:black; width:100%;" value="<?php 
					  echo $datavideo['topik'];?>">
                    </div>
				</div>

				<div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Judul</label>
                    <div class="col-md-12">
					  <input type="text" disabled style="color:black; width:100%;" value="<?php 
					  echo $datavideo['judul'];?>">
                    </div>
				</div>

				<div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Jenis</label>
                    <div class="col-md-12">
					  <input type="text" disabled style="color:black; width:100%;" value="<?php 
					  echo $textjenis[$datavideo['id_jenis']];?>">
                    </div>
				</div>

				<?php
				if ($datavideo['id_jenis']==1) 
				{ ?>
				<div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Sasaran</label>
                    <div class="col-md-12">
					  <input type="text" disabled style="color:black; width:100%;" value="<?php 
					  echo $datavideo['nama_jenjang'].", ".$datavideo['nama_kelas'];?>">
                    </div>
				</div>

				<div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Mapel</label>
                    <div class="col-md-12">
					<table style="color:black;">
					  <tr style="background-color: #ffffff;">
					  <td><?php 
					  echo $datavideo['nama_mapel'];?></td></tr></table>
                    </div>
				</div>

				<div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">KI - KD</label>
                    <div class="col-md-12">
					<table style="color:black;">
					  <tr style="background-color: #ffffff;">
					  <td><?php 
					  if ($datavideo['id_ki1']>0)
					  {
						echo 'Kompetensi Inti: '.$datavideo['id_ki1'].'<br>';
						if ($datavideo['id_kd1_1']>0)
							echo '- '.$datavideo['nama_kd1_1'];
						if ($datavideo['id_kd1_2']>0)
							echo '<br>'.'- '.$datavideo['nama_kd1_2'];
						if ($datavideo['id_kd1_3']>0)
							echo '<br>'.'- '.$datavideo['nama_kd1_3'];
					  }
					  if ($datavideo['id_ki2']>0)
					  {
						echo '<br>'.'Kompetensi Inti: '.$datavideo['id_ki2'].'<br>';
						if ($datavideo['id_kd2_1']>0)
							echo '- '.$datavideo['nama_kd2_1'];
						if ($datavideo['id_kd2_2']>0)
							echo '<br>'.'- '.$datavideo['nama_kd2_2'];
						if ($datavideo['id_kd2_3']>0)
							echo '<br>'.'- '.$datavideo['nama_kd2_3'];
					  }
					  
					  ?></td></tr></table>
                    </div>
				</div>

				<?php
				} else 
				{ ?>
				<div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Kategori</label>
                    <div class="col-md-12">
					<table style="color:black;">
					  <tr style="background-color: #ffffff;">
					  <td><?php 
					  echo $datavideo['nama_kategori'];?></td></tr></table>
                    </div>
				</div>
				<?php 
				}
				?>

				<div class="form-group">
                    <label for="inputDefault" class="col-md-12 control-label">Deskripsi</label>
                    <div class="col-md-12">
					<table style="color:black;">
					  <tr style="background-color: #ffffff;">
					  <td><?php 
					  echo $datavideo['deskripsi'];?></td></tr></table>
                    </div>
				</div>

				<div class="form-group">	
					<label for="inputDefault" class="col-md-12 control-label">Keyword</label>
					<div class="col-md-12">
					  <table style="color:black;">
					  <tr style="background-color: #ffffff;">
					  <td><?php
					  echo $datavideo['keyword'];
					  ?></td></tr></table>
					  <br>
					  <button onclick="return showvid()" id="btnCounter" disabled>Tunggu .... <span id="count"></span></button>
					<div id="batal1">
						<br>
						<button class="btn btn-default" onclick = "return takon()">Batal</button>
					</div>
					</div>
					
				</div>
			</div>
				

			<div class="form-group">
				<div id="isi_video" style='display:none'>
                <div class="form-group">
					<!-- <label class="col-md-12 control-label">Video</label> -->
					<div class="col-md-12">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="https://www.youtube-nocookie.com/embed/<?php echo youtube_id($datavideo['link_video']);?>" frameborder="0" allowfullscreen></iframe>                    -->
					</div>
					<br>
					<button style='color:black' onclick="return showswitch()">Profil Video</button>
					</div>
				</div>
				</div>
			</div>

            </fieldset>
    	</div>
	</div>


	<div id="isi_video2" class="col-md-5" style="display:none">
    	<div class="well bp-component">
            <fieldset>
                  <legend>Penilaian</legend>
                  				<div id="tabel1" style="margin-left:10px;margin-right:10px;">
									<table id="tbl_user2" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%" >
											<thead>
													<tr>
															<th width="5%">No</th>
															<th>Pernyataan</th>
															<th width="7%">Ya</th>
															<th width="7%">Tidak</th>

													</tr>
											</thead>

											<tbody>
													<?php for ($i=1;$i<=$jml_pernyataan;$i++)
													{?>
													<tr>
															<td><?php echo $i;?></td>
															<td><?php echo $nama_penilaian[$i];?></td>
															<td><input <?php echo $cek[$i][1];?> type="radio" name="inilai<?php echo $i;?>" value="1"></td>
															<td><input <?php echo $cek[$i][2];?> type="radio" name="inilai<?php echo $i;?>" value="2"></td>
																											</tr>
													<?php
													}
													?>        
											</tbody>
									</table>
								</div>
				

					<input type="hidden" id="id_video" name="id_video" value="<?php echo $datavideo['id_video'];?>"/>
					<input type="hidden" id="total_isian" name="total_isian" value="<?php echo $jml_pernyataan;?>"/>
					<input type="hidden" id="totalnilai" name="totalnilai" value=""/>
					<input type="hidden" id="jml_diisi" name="jml_diisi" value=""/>
					<input type="hidden" id="lulusgak" name="lulusgak" value=""/>
				  
					<div class="form-group">
                    <div class="col-md-10 col-md-offset-0">
					<label>Catatan</label>
						<textarea rows="4" cols="60" class="form-control" id="icatatan" name="icatatan" maxlength="200"><?php 
						echo $datavideo['catatan'.$this->session->userdata('tukang_verifikasi')];?></textarea><br>
                    </div>
                  	</div>

                  	<div class="form-group">
                    <div class="col-md-10 col-md-offset-0">
						<button class="btn btn-default" onclick = "return takon()">Batal</button>
						<button type="submit" class="btn btn-primary" onclick = "return ceklulus(2)">Lulus</button>
						<button type="submit" class="btn btn-primary" onclick = "return ceklulus(1)">Tidak Lulus</button>
                    </div>
                  	</div>
            	</fieldset>
    	</div>
	</div>
	<?php 
	echo form_close(). '';
	?>	
</div>

<!-- echo form_open('dasboranalisis/update'); -->

<script src="<?php echo base_url()?>js/jquery-3.4.1.js"></script>

<script>


// Get refreence to span and button
var spn = document.getElementById("count");
var btn = document.getElementById("btnCounter");

var count = 5;     // Set count
var timer = null;  // For referencing the timer

(function countDown(){
  // Display counter and start counting down
  spn.textContent = count;
  
  // Run the function again every second if the count is not zero
  if(count !== 0){
    timer = setTimeout(countDown, 1000);
    count--; // decrease the timer
  } else {
    // Enable the button
	btn.removeAttribute("disabled");
	btn.innerHTML = "Video";
	btn.style.color = 'black';
  }
  return false;
}());

function showvid()
{
	document.getElementById("isi_video").style.display = 'block';
	document.getElementById("isi_video2").style.display = 'block';
	document.getElementById("isi_profil").style.display = 'none';
	document.getElementById("batal1").style.display = 'none';
	
	return false;
}

function showswitch()
{
	if (document.getElementById("isi_video").style.display == 'none')
	{
		document.getElementById("isi_video").style.display = 'block';
		document.getElementById("isi_profil").style.display = 'none';
	}
	else
	{
		document.getElementById("isi_video").style.display = 'none';
		document.getElementById("isi_profil").style.display = 'block';
	}
	
	return false;
}

function ceklulus(indeks)
{
	nemutidak=0;
	jml_diisi=0;
	jml_pertanyaan=<?php echo $jml_pernyataan;?>;

	wajiby = Array();
	n_isi = Array();

	<?php
	for ($c0=1;$c0<=$jml_pernyataan;$c0++)
	{
		echo 'wajiby['.$c0.']='.$wajibya[$c0].';';
	}
	?>
	
	yangbelumwajib="";
	jmlbelum=0;

	for (an=1;an<=<?php echo $jml_pernyataan;?>;an++)
	{
		//alert (parseInt($("input[name='inilai"+an+"']:checked").val())+"--"+wajiby[an]);
		if (!(parseInt($("input[name='inilai"+an+"']:checked").val())==wajiby[an]) && wajiby[an]==1)
		{
			jmlbelum++;
			yangbelumwajib=yangbelumwajib+'' +an+' ';
		}
		if (parseInt($("input[name='inilai"+an+"']:checked").val())>0)
		jml_diisi++;
		
	}

	//alert (jml_diisi);

	////////// NEK TOMBOLE LULUS DIPENCET ///////////
	if (indeks==2)
	{
		if (jmlbelum>0)
		{
			$('#icatatan').html("Opsi "+yangbelumwajib+ " harus sesuai");
			return false;
		}
		else
		{
			$('#lulusgak').val(2);
			return true;
		}
	}
	else //////////// YEN ORA
	{
		
		if (jml_diisi<jml_pertanyaan)
		{
			alert ("Harus dinilai semua dulu");
			return false;
		}
		else
		{
		if (jmlbelum==0 && $('#icatatan').val()=="")
		{
			alert ("Beri catatan kenapa tidak lulus, padahal sudah sesuai semua!");
			//$('#icatatan').html("Opsi "+yangbelumwajib+ " tidak sesuai");
			return false;
		}
		else if ($('#icatatan').val()=="")
		{
			alert ("Beri catatan kenapa tidak lulus");
			$('#icatatan').html("Opsi "+yangbelumwajib+ " tidak sesuai");
			return false;
		}
		else
		{
			$('#lulusgak').val(1);
			return true;
		}
		}

	}
	

	
}

function cekgaklulus()
{
	nilaitotal=0;
	jml_diisi=0;
	jml_pertanyaan=<?php echo $jml_pernyataan;?>;

	for (var i = 1; i<=<?php echo $jml_pernyataan;?>; i++)
	{
		nilaitotal=nilaitotal+parseInt($("input[name='inilai"+i+"']:checked").val());
		if (parseInt($("input[name='inilai"+i+"']:checked").val())>0)
		jml_diisi++;
	}

	alert (jml_pertanyaan);

	nilaitotal=nilaitotal/2;
	$('#totalnilai').val(nilaitotal);
	$('#jml_diisi').val(jml_diisi);

	if (jml_diisi<jml_pertanyaan)
	{
		alert ("Harus diisi semua dulu");
		return false;
	}
	else
	{
		return true;
	}

	

}


function takon()
{
	window.open("<?php echo base_url();?>video/vervideo","_self");
	return false;
}


</script>
