<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jml_kurikulum = 0;
foreach ($dafkurikulum as $datane) {
	$jml_kurikulum++;
	$sel_kurikulum[$jml_kurikulum] = "";
	$nama_kurikulum[$jml_kurikulum] = $datane->kurikulum;
}

$jml_jenjang = 0;
foreach ($dafjenjang as $datane) {
	$jml_jenjang++;
	$sel_jenjang[$jml_jenjang] = "";
	$id_jenjang[$jml_jenjang] = $datane->id;
	$nama_jenjang[$jml_jenjang] = $datane->nama_jenjang;
}

$jml_kategori = 0;
foreach ($dafkategori as $datane) {
	$jml_kategori++;
	$sel_kategori[$jml_kategori] = "";
	$id_kategori[$jml_kategori] = $datane->id;
	$nama_kategori[$jml_kategori] = $datane->nama_kategori;
}

$sel_jenis[1] = "";
$disp[1] = "";
$disp2[1] = "style='display:none';";
$disp[2] = "";
$sel_ki1[3] = "";
$sel_ki1[4] = "";

$judul = "";
$topik = "";
$deskripsi = "";
$keyword = "";
$link_video = "";

?>

<div style="margin-top: 60px">
	<center><span style="color:black; font-size:20px;font-weight:Bold;"><?php echo $title; ?></span></center>

	<div class="row">
		<?php
		echo form_open('video/addvideox');
		?>
		<div class="col-md-5 col-md-offset-1">
			<div class="well bp-component" style="background-color: white">
				<fieldset>
					<legend style="color: black">Jenis dan Sasaran</legend>
					<div class="form-group" id="djenis">
						<label for="select" class="col-md-12 control-label">Jenis</label>
						<div class="col-md-12">
							<select class="form-control" name="ijenis" id="ijenis">
								<option selected value="1">Konten Instruksional</option>
								<option value="2">Konten Non Instruksional</option>
							</select>
						</div>
					</div>

					<div id="grupins" <?php echo $disp[1]; ?>>

						<div class="form-group" id="dkurikulum"><br>
							<label for="select" class="col-md-12 control-label">Kurikulum</label>
							<div class="col-md-12">
								<select class="form-control" name="ikurikulum" id="ikurikulum">
									<?php
									for ($b0 = 1; $b0 <= $jml_kurikulum; $b0++) {
										echo '<option ' . $sel_kurikulum[$b0] . ' value="' . $nama_kurikulum[$b0] . '">' . $nama_kurikulum[$b0] . '</option>';
									}
									?>
								</select>
							</div>
						</div>

						<div class="form-group" id="dstandar"><br>
							<label for="select" class="col-md-12 control-label">Standar Kurikulum</label>
							<div class="col-md-12">
								<select class="form-control" name="istandar" id="istandar">
									<option value="0">Nasional</option>
									<?php if ($this->session->userdata('sebagai')==1){?>
									<option value="<?php echo $this->session->userdata('npsn');?>">Standar Sekolah</option>
								<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group" id="djenjang"><br>
							<label for="select" class="col-md-12 control-label">Jenjang</label>
							<div class="col-md-12">
								<select class="form-control" name="ijenjang" id="ijenjang">
									<option value="0">-- Pilih --</option>
									<?php
									for ($b1 = 1; $b1 <= $jml_jenjang; $b1++) {
										echo '<option ' . $sel_jenjang[$b1] . ' value="' . $id_jenjang[$b1] . '">' . $nama_jenjang[$b1] . '</option>';
									}
									?>
								</select>
							</div>
						</div>

                        <div class="form-group" id="djurusan">
                            <input type="hidden" id="ijurusan" name="ijurusan" value=0 />
                        </div>

						<div class="form-group" id="dkelas"><br>
							<label for="select" class="col-md-12 control-label">Kelas</label>
							<div class="col-md-12">
								<select class="form-control" name="ikelas" id="ikelas">
									<option value="0">-- Pilih --</option>
								</select>
							</div>
						</div>

                        <div class="form-group" id="dtema">

                                <br>
                                <label for="select" class="col-md-12 control-label">Tema</label>
                                <div class="col-md-12">
                                    <select class="form-control" name="itema" id="itema">
                                        <option value="0">-- Pilih --</option>
<!--                                        --><?php
//
//                                            for ($bb11 = 1; $bb11 <= $jml_tema; $bb11++) {
//                                                echo '<option ' . $sel_tema[$id_tema[$bb11]] . ' value="' . $id_tema[$bb11] . '">' . $nama_tema[$bb11] . '</option>';
//                                            }
//                                        ?>
                                    </select>
                                </div>
                        </div>


						<div class="form-group" id="dmapel"><br>
							<label for="select" class="col-md-12 control-label">Mata Pelajaran</label>
							<div class="col-md-12">
								<select class="form-control" name="imapel" id="imapel">
									<option value="0">-- Pilih --</option>
								</select>
							</div>
						</div>

						<div class="form-group"><br>
							<label for="inputDefault" class="col-md-12 control-label">Kompetensi Inti </label>
							<div class="col-md-12">
								<table>
									<tr>
										<td style='width:auto'>
                                            <div id="isidki">
                                                <select class="form-control" name="iki1" id="iki1">
                                                    <option value="0">-- Pilih --</option>
                                                </select>
                                            </div>
										</td>

									</tr>
								</table>
							</div>
						</div>
					</div>

					<!--				<div id="grupnonins" style="display:none">-->
					<!--					<div class="form-group" id="dkategori">-->
					<!--						<label for="select" class="col-md-12 control-label">Kategori</label>-->
					<!--						<div class="col-md-12">-->
					<!--							<select class="form-control" name="ikategori" id="ikategori">-->
					<!--								<option value="0">-- Pilih --</option>-->
					<!--								--><?php
					//								for ($b2 = 1; $b2 <= $jml_kategori; $b2++) {
					//									echo '<option ' . $sel_kategori[$b2] . ' value="' . $id_kategori[$b2] . '">' . $nama_kategori[$b2] . '</option>';
					//								}
					//								?>
					<!--							</select>-->
					<!--						</div>-->
					<!--					</div>-->
					<!--				</div>-->

				</fieldset>
			</div>
		</div>


		<div class="col-md-5">
			<div class="well bp-component" style="background-color: white" id="dkade">
				<fieldset>
					<legend style="color: black">Kompetensi Dasar</legend>
					<div class="form-group">
						<div class="col-md-12" id="isidaftar2">
							<table id="tbl_user" class="table table-bordered nowrap" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th style='text-align:center;width:85%'>Kompetensi Dasar</th>
<!--									<th id="idedit" style='text-align:center;'>Edit</th>-->
								</tr>
								</thead>
							</table>
						</div>
						<div class="col-md-12">
							<div id="tbtambah" style="display: none">
								<button onclick="tambahkd()" type="button">Tambah</button>
							</div>
							<div id="gruptambah" style="display: none">
								<textarea class="form-control" id="ikade" cols="100" rows="3"
									   name="ikade" maxlength="300" value="" placeholder="">
                                </textarea>
								<div style="text-align: right">
									<button onclick="bataltambah()" type="button">Batal</button>
									<button onclick="simpankd()" type="button">Simpan</button>
								</div>
							</div>
							<div id="grupedit" style="display: none">
								<textarea class="form-control" id="ikade2" cols="100" rows="3"
									   name="ikade2" maxlength="300" value="" placeholder="">
                                </textarea>
								<div style="text-align: right">
									<button onclick="bataledit()" type="button">Batal</button>
									<button onclick="updatekd()" type="button">Update</button>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
			</div>

			<div class="well bp-component" id="dkate" style="background-color: white;display: none">
				<fieldset>
					<legend>Kategori</legend>
					<div class="form-group">
						<div class="col-md-12" id="isidaftar3">
							<table id="tbl_user" class="table table-bordered nowrap" cellspacing="0" width="100%">
								<thead>
								<tr>
									<th style='text-align:center;width:85%'>Kategori</th>
									<th id="idedit2" style='text-align:center;'>Edit</th>
								</tr>
								</thead>
							</table>
						</div>
						<div class="col-md-12">
							<div id="tbtambahkat" style="display: block">
								<button onclick="tambahkat()" type="button">Tambah</button>
							</div>
							<div id="gruptambahkat" style="display: none">
								<input type="text" class="form-control" id="ikate"
									   name="ikate" maxlength="100" value="" placeholder="">
								<div style="text-align: right">
									<button onclick="bataltambahkat()" type="button">Batal</button>
									<button onclick="simpankat()" type="button">Simpan</button>
								</div>
							</div>
							<div id="grupeditkat" style="display: none">
								<input type="text" class="form-control" id="ikatekat"
									   name="ikatekat" maxlength="100" value="" placeholder="">
								<div style="text-align: right">
									<button onclick="bataleditkat()" type="button">Batal</button>
									<button onclick="updatekat()" type="button">Update</button>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
			</div>
		</div>

		<input type="hidden" name="npsnsekolah" id="npsnsekolah" value="<?php
		if ($this->session->userdata('sebagai')==4 || $this->session->userdata('a01'))
			echo "0";
		else if ($this->session->userdata('sebagai')==1 && $this->session->userdata('npsn')==0)
			echo "0-0";
		else
			echo $this->session->userdata('npsn');
		?>">

		<?php
		echo form_close() . '';
		?>
	</div>
</div>


<!-- echo form_open('dasboranalisis/update'); -->

<script src="<?php echo base_url() ?>js/jquery-3.4.1.js"></script>

<script>

	var indeks = new Array();
	var teksedit = new Array();
	var idpilih = 0;
	var kadepilih = "";
	<?php
		if (!$this->session->userdata("a01"))
			echo "var npsnku = \"".$this->session->userdata('npsn')."\";";?>

	$(document).on('change', '#ijenis', function () {
		cektambah();
		pilihanjenis();
		//ambilkd(1);
	});

	$(document).on('change', '#ikurikulum', function () {
		ambilkd(1);
		cektambah();
	});

	$(document).on('change', '#istandar', function () {
		ambilkd(1);
		cektambah();
	});

	$(document).on('change', '#ijenjang', function () {
		//alert ("JENJANG");
        ambilki();
        ambiljurusan();
        ambiltema();
        ambilkelas();
        ambilmapel(0);
        ambilkd(1);
        cektambah();
    });

    $(document).on('change', '#ijurusan', function () {
        ambilkelas();
        ambilmapel();
        ambilkd(1);
        cektambah();
        $('#tbtambah').hide();
    });

	$(document).on('change', '#iki1', function () {
		ambilkd(1);
        cektambah();
	});

	$(document).on('change', '#ikelas', function () {
        ambiltema();
		ambilkd(1);
        cektambah();
	});

	$(document).on('change', '#imapel', function () {
		ambilkd(1);
        cektambah();
	});

    function ambilki() {

    //	alert ("OK");
        var jenjang = $('#ijenjang').val();

        isihtml1 = '<select class="form-control" name="iki1" id="iki1">\n' +
            '<option value="0">-- Pilih --</option>\n';

        if (jenjang==1)
        {
            isihtml2 = '<option value = "1" > Sikap Religius </option>'+
                '<option value = "2" > Sikap Sosial </option>'+
                '<option value = "3" > Pengetahuan </option>'+
                '<option value = "4" > Ketrampilan </option>';
        }
        else
        {
            isihtml2 = '<option value = "3" > Pengetahuan </option>'+
                '<option value = "4" > Ketrampilan </option>';
        }

        isihtml3='</select>';

        $('#isidki').html(isihtml1 + isihtml2 + isihtml3);
        // $('#isidki').html("kokok");
    }

	function pilihanjenis() {

		var jenis = document.getElementById("ijenis");
		var y1 = document.getElementById("grupins");
		//var y2 = document.getElementById("grupnonins");
		var y3 = document.getElementById("dkade");
		var y4 = document.getElementById("dkate");
		//var y2 = document.getElementById("grupnonins");

		if (jenis.value == 2) {
			y1.style.display = "none";
			//y2.style.display = "block";
			y3.style.display = "none";
			y4.style.display = "block";
			cektambahkat();
			ambilkat();

		}
		else {
			//y2.style.display = "none";
			y1.style.display = "block";
			y4.style.display = "none";
			y3.style.display = "block";
		}
	}

	function ambilkelas() {

    	//alert ("KELAS");

	    if ($('#ijenjang').val()==1)
        {
            //$('#dkelas').html("");
            var isihtmlf = '<input type="hidden" id="ikelas" name="ikelas" value=0 />';
            $('#dkelas').html(isihtmlf);
        }
        else {
            isihtml0 = '<br><label for="select" class="col-md-12 control-label">Kelas</label><div class="col-md-12">';
            isihtml1 = '<select class="form-control" name="ikelas" id="ikelas">' +
                '<option value="0">-- Pilih --</option>';
            isihtml3 = '</select></div>';
            $.ajax({
                type: 'GET',
                data: {idjenjang: $('#ijenjang').val()},
                dataType: 'json',
                cache: false,
                url: '<?php echo base_url(); ?>video/daftarkelas',
                success: function (result) {
                    //alert ($('#itopik').val());
                    isihtml2 = "";
                    $.each(result, function (i, result) {
                        isihtml2 = isihtml2 + "<option value='" + result.id + "'>" + result.nama_kelas + "</option>";
                    });
                    $('#dkelas').html(isihtml0 + isihtml1 + isihtml2 + isihtml3);
                }
            });
        }
	}

	function ambilmapel() {

		//alert ("MAPEL");

        if ($('#ijenjang').val()==1)
        {
            var isihtmlg = '<input type="hidden" id="imapel" name="imapel" value=0 />';
            $('#dmapel').html(isihtmlg);
        }
        else {

            //alert ("ambil mapel dari jurusan:"+$('#ijurusan').val());
            isihtmlb0 = '<br><label for="select" class="col-md-12 control-label">Mata Pelajaran</label><div class="col-md-12">';
            isihtmlb1 = '<select class="form-control" name="imapel" id="imapel">' +
                '<option value="0">-- Pilih --</option>';
            isihtmlb3 = '</select></div>';
            $.ajax({
                type: 'GET',
                data: {idjenjang: $('#ijenjang').val(),
                    idjurusan: $('#ijurusan').val()},
                dataType: 'json',
                cache: false,
                url: '<?php echo base_url(); ?>video/daftarmapel',
                success: function (result) {
                    //alert ($('#itopik').val());
                    isihtmlb2 = "";
                    $.each(result, function (i, result) {
                        isihtmlb2 = isihtmlb2 + "<option value='" + result.id + "'>" + result.nama_mapel + "</option>";
                    });
                    $('#dmapel').html(isihtmlb0 + isihtmlb1 + isihtmlb2 + isihtmlb3);
                }
            });
        }
	}

    function ambiltema() {
    	//alert ("TEMA");
        var kelasbener = $('#ikelas').val()-2;
        var jenjang = $('#ijenjang').val();

        if (jenjang!=2)
        {
            var isihtmlc = '<input type="hidden" id="itema" name="itema" value=0 />';
            $('#dtema').html(isihtmlc);
        }
        else {

            var isihtmlc0 = '<br><label for="select" class="col-md-12 control-label">Tema</label><div class="col-md-12">';
            var isihtmlc1 = '<select class="form-control" name="itema" id="itema">' +
                '<option value="0">-- Pilih --</option>';
            var isihtmlc3 = '</select></div>';
            $.ajax({
                type: 'GET',
                data: {idkelas: kelasbener},
                dataType: 'json',
                cache: false,
                url: '<?php echo base_url(); ?>video/daftartema',
                success: function (result) {
                    //alert ($('#itopik').val());
                    var isihtmlc2 = "";
                    $.each(result, function (i, result) {
                        isihtmlc2 = isihtmlc2 + "<option value='" + result.id + "'>" + result.nama_tematik + "</option>";
                    });
                    $('#dtema').html(isihtmlc0 + isihtmlc1 + isihtmlc2 + isihtmlc3);
                }
            });
            //$('#dtema').html('ISISISIS');
        }
    }

	function ambilkd(ki) {

		//alert ("KD");

		if ($('#ikelas').val() >= 0 && $('#imapel').val() >= 0 && $('#ijenjang').val() >= 0 && $('#iki1').val() >= 0) {
			isihtmlc1 = "<table id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
				"<thead>" +
				"<tr>" +
				"<th style='text-align:center;width:85%'>Kompetensi Dasar</th>" +
				"<th style='text-align:center;'>Edit</th>" +
				"</tr>" +
				"</thead>" +
				"<tbody>";

			isihtmlc1n = "<table id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
				"<thead>" +
				"<tr>" +
				"<th style='text-align:center;width:85%'>Kompetensi Dasar</th>" +
				"</tr>" +
				"</thead>" +
				"<tbody>";

			isihtmlc3 = "</tbody></table>";
			$.ajax({
				type: 'GET',
				data: {
					npsn: $('#istandar').val(),
					kurikulum: $('#ikurikulum').val(),
					idkelas: $('#ikelas').val(),
					idmapel: $('#imapel').val(),
					idki: $('#iki1').val()
				},
				dataType: 'json',
				cache: false,
				url: '<?php echo base_url(); ?>video/ambilkd',
				success: function (result) {
					isihtmlc2 = "";
					isihtmlc2n = "";
					isihtmlc2u = "";
					var jmlkd = 0;
					$.each(result, function (i, result) {
						jmlkd++;
						indeks[jmlkd] = result.id;
						teksedit[jmlkd] = result.nama_kd;

						isihtmlc2 = isihtmlc2 + "<tr><td>" + result.nama_kd + "</td>" +
							"<td style='text-align:center;'>"+
							"<button onclick=\"diedit('" +
							jmlkd + "')\" type=\"button\">Edit</button>"+
							"</td></tr>";

						isihtmlc2u = isihtmlc2u + "<tr><td>" + result.nama_kd + "</td>" +
							"<td style='text-align:center;'>"+
							"<button onclick=\"diedit('" +
							jmlkd + "')\" type=\"button\">Edit</button>"+
							"<button onclick=\"deletekd('" +
							jmlkd + "')\" type=\"button\">Hapus</button>"+
							"</td></tr>";

						isihtmlc2n = isihtmlc2n + "<tr><td>" + result.nama_kd + "</td>" +
							"</tr>";

					});
					if (npsnku>0 && $('#istandar').val()==0)
					{
						$('#isidaftar2').html(isihtmlc1n + isihtmlc2n + isihtmlc3);
					}
					else
					{
						$('#isidaftar2').html(isihtmlc1 + isihtmlc2u + isihtmlc3);
					}
					<?php if($this->session->userdata('a01'))
						{?>
							$('#isidaftar2').html(isihtmlc1 + isihtmlc2u + isihtmlc3);
						<?php } else if($this->session->userdata('sebagai')==4)
					{?>
					$('#isidaftar2').html(isihtmlc1 + isihtmlc2 + isihtmlc3);
					<?php }
					?>
				}

			});
		}
	}

	function ambilkat() {
		isihtmlkata1 = "<table id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
			"<thead>" +
			"<tr>" +
			"<th style='text-align:center;width:85%'>Nama Kategori</th>" +
			"<th style='text-align:center;'>Edit</th>" +
			"<th style='text-align:center;'>Delete</th>" +
			"</tr>" +
			"</thead>" +
			"<tbody>";
		isihtmlkata1n = "<table id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
			"<thead>" +
			"<tr>" +
			"<th style='text-align:center;width:85%'>Nama Kategori</th>" +
			"</tr>" +
			"</thead>" +
			"<tbody>";
		isihtmlkata3 = "</tbody></table>";
		$.ajax({
			type: 'GET',
			data: {id: 0},
			dataType: 'json',
			cache: false,
			url: '<?php echo base_url(); ?>video/ambilkategori',
			success: function (result) {
				isihtmlkata2 = "";
				isihtmlkata2n = "";
				var jmlkat = 0;
				$.each(result, function (i, result) {
					jmlkat++;
					indeks[jmlkat] = result.id;
					teksedit[jmlkat] = result.nama_kategori;
					isihtmlkata2 = isihtmlkata2 + "<tr><td>" + result.nama_kategori + "</td>" +
						"<td style='text-align:center;'><button onclick=\"dieditkat('" +
						jmlkat + "')\" type=\"button\">Edit</button></td>" +
						<?php
						{?>
						"<td style='text-align:center;'><button onclick=\"deletekat('" +
						jmlkat + "')\" type=\"button\">Hapus</button></td>" +
						<?php }
						?>
						"</tr>";
					isihtmlkata2n = isihtmlkata2n + "<tr><td>" + result.nama_kategori + "</td>" +
						"</tr>";
				});
				<?php if($this->session->userdata('a01') || $this->session->userdata('sebagai')==4)
				{?>
					$('#isidaftar3').html(isihtmlkata1 + isihtmlkata2 + isihtmlkata3);
				<?php } else {?>
				$('#isidaftar3').html(isihtmlkata1n + isihtmlkata2n + isihtmlkata3);
				<?php } ?>

			},
			error: function () {
				alert("Error");
			}

		});

	}

	function tambahkd() {
		$('#tbtambah').hide();
        $('#ikade').html('');
		$('#gruptambah').show();
	}

	function bataltambah() {
		$('#tbtambah').show();
		$('#gruptambah').hide();
	}

	function cektambah() {
		if ($('#npsnsekolah').val() == $('#istandar').val()) {
			if ($('#ijenjang').val() == 1 && $('#iki1').val() > 0)
				$('#tbtambah').show();
			else if ($('#ikelas').val() > 0 && $('#imapel').val() > 0 && $('#ijenjang').val() > 0 && $('#iki1').val() > 0) {
				$('#tbtambah').show();
			} else {
				$('#tbtambah').hide();
			}
		} else {
			$('#tbtambah').hide();
		}
	}

	function cektambahkat() {
		<?php if($this->session->userdata('a01')|| $this->session->userdata('sebagai')==4)
			{?>
				$('#tbtambahkat').show();
			<?php } else
			{?>
				$('#tbtambahkat').hide();
			<?php }
			?>
	}

	function klirkelas()
    {
        var isihtmlx0 = '<br><label for="select" class="col-md-12 control-label">Kelas</label><div class="col-md-12">';
        var isihtmlx1 = '<select class="form-control" name="ikelas" id="ikelas">' +
            '<option value="0">-- Pilih --</option>';
        var isihtmlx3 = '</select></div>';
        $('#dkelas').html(isihtmlx0 + isihtmlx1 + isihtmlx3);
    }

    function ambiljurusan() {
		//alert ("JURUSAN");
        var jenjang = $('#ijenjang').val();

        if (jenjang!=5)
        {
            var isihtmld = '<input type="hidden" id="ijurusan" name="ijurusan" value=0 />';
            $('#djurusan').html(isihtmld);
        }
        else {
            //alert ($('#ijenjang').val());
            var isihtmld0 = '<br><label for="select" class="col-md-12 control-label">Jurusan</label><div class="col-md-12">';
            var isihtmld1 = '<select class="form-control" name="ijurusan" id="ijurusan">' +
                '<option value="0">-- Semua Jurusan --</option>';
            var isihtmld3 = '</select></div>';
            $.ajax({
                type: 'GET',
                data: {idjenjang: jenjang},
                dataType: 'json',
                cache: false,
                url: '<?php echo base_url(); ?>video/daftarjurusan',
                success: function (result) {
                    //alert ($('#itopik').val());
                    var isihtmld2 = "";
                    $.each(result, function (i, result) {
                        isihtmld2 = isihtmld2 + "<option value='" + result.id + "'>" + result.nama_jurusan + "</option>";
                    });
                    $('#djurusan').html(isihtmld0 + isihtmld1 + isihtmld2 + isihtmld3);
                }
            });
        }
    }

	function tambahkat() {
		$('#tbtambahkat').hide();
		$('#gruptambahkat').show();
	}

	function bataltambahkat() {
		$('#tbtambahkat').show();
		$('#gruptambahkat').hide();
	}

	function simpankd() {
		isihtmld1 = "<table id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
			"<thead>" +
			"<tr>" +
			"<th style='text-align:center;width:85%'>Kompetensi Dasar</th>" +
			"<th style='text-align:center;'>Edit</th>" +
			"</tr>" +
			"</thead>" +
			"<tbody>";
		isihtmld1n = "<table id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
			"<thead>" +
			"<tr>" +
			"<th style='text-align:center;width:85%'>Kompetensi Dasar</th>" +
			"</tr>" +
			"</thead>" +
			"<tbody>";
		isihtmld3 = "</div></tbody></table>";

		//alert ($('#ikelas').val());


		$.ajax({
			url: "<?php echo base_url(); ?>video/addkd",
			method: "POST",
			dataType: 'json',
			data: {
				tekskd: $('#ikade').val(),
				idkelas: $('#ikelas').val(),
				idmapel: $('#imapel').val(),
                idtema: $('#itema').val(),
                idjurusan: $('#ijurusan').val(),
				idki: $('#iki1').val(),
				npsn: $('#npsnsekolah').val(),
				kurikulum: $('#ikurikulum').val()
			},
			success: function (result) {
				isihtmld2 = "";
				isihtmld2n = "";
				isihtmld2u = "";
				var jmlkd = 0;
				$.each(result, function (i, result) {
					jmlkd++;
					indeks[jmlkd] = result.id;
					teksedit[jmlkd] = result.nama_kd;
					isihtmld2 = isihtmld2 + "<tr><td>" + result.nama_kd + "</td>" +
						"<td style='text-align:center;'>"+
						"<button onclick=\"diedit('" +
						jmlkd + "')\" type=\"button\">Edit</button>"+
						"</td></tr>";

					isihtmld2u = isihtmld2u + "<tr><td>" + result.nama_kd + "</td>" +
						"<td style='text-align:center;'>"+
						"<button onclick=\"diedit('" +
						jmlkd + "')\" type=\"button\">Edit</button>"+
						"<button onclick=\"deletekd('" +
						jmlkd + "')\" type=\"button\">Hapus</button>"+
						"</td></tr>";

					isihtmld2n = isihtmld2n + "<tr><td>" + result.nama_kd + "</td>" +
						"</tr>";

				});

				if (npsnku>0 && $('#istandar').val()==0)
				{
					$('#isidaftar2').html(isihtmld1n + isihtmld2n + isihtmld3);
				}
				else
				{
					$('#isidaftar2').html(isihtmld1 + isihtmld2u + isihtmld3);
				}
				<?php if($this->session->userdata('a01'))
				{?>
				$('#isidaftar2').html(isihtmld1 + isihtmld2u + isihtmld3);
				<?php } else if($this->session->userdata('sebagai')==4)
				{?>
				$('#isidaftar2').html(isihtmld1 + isihtmld2 + isihtmld3);
				<?php }
				?>
				bataltambah();
			},
			error: function () {
				alert('error!');
			}
		})
	}

	function simpankat() {
		isihtmlkatb1 = "<table id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
			"<thead>" +
			"<tr>" +
			"<th style='text-align:center;width:85%'>Kategori</th>" +
			"<th style='text-align:center;'>Edit</th>" +
			"<th style='text-align:center;'>Delete</th>" +
			"</tr>" +
			"</thead>" +
			"<tbody>";
		isihtmlkatb1n = "<table id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
			"<thead>" +
			"<tr>" +
			"<th style='text-align:center;width:85%'>Kategori</th>" +
			"</tr>" +
			"</thead>" +
			"<tbody>";
		isihtmlkatb3 = "</div></tbody></table>";
		$.ajax({
			url: "<?php echo base_url(); ?>video/addkat",
			method: "POST",
			dataType: 'json',
			data: {
				tekskate: $('#ikate').val()
			},
			success: function (result) {
				isihtmlkatb2 = "";
				isihtmlkatb2n = "";
				var jmlkat = 0;
				$.each(result, function (i, result) {
					jmlkat++;
					indeks[jmlkat] = result.id;
					teksedit[jmlkat] = result.nama_kategori;
					isihtmlkatb2 = isihtmlkatb2 + "<tr><td>" + result.nama_kategori + "</td>" +
						"<td style='text-align:center;'><button onclick=\"dieditkat('" +
						jmlkat + "')\" type=\"button\">Edit</button></td>" +
						<?php
						{?>
						"<td style='text-align:center;'><button onclick=\"deletekat('" +
						jmlkat + "')\" type=\"button\">Hapus</button></td>" +
						<?php }
						?>
						"</tr>";
					isihtmlkatb2n = isihtmlkatb2n + "<tr><td>" + result.nama_kategori + "</td>" +
						"</tr>";
				});
				<?php if($this->session->userdata('a01') || $this->session->userdata('sebagai')==4)
				{?>
				$('#isidaftar3').html(isihtmlkatb1 + isihtmlkatb2 + isihtmlkatb3);
				<?php } else {?>
				$('#isidaftar3').html(isihtmlkatb1n + isihtmlkatb2n + isihtmlkatb3);
				<?php } ?>
				bataltambahkat();
			},
			error: function () {
				alert('error!');
			}
		})
	}

	function deletekat(idx) {
		var r = confirm("Yakin mau hapus?");
		if (r == true) {
			idpilih = indeks[idx];
			isihtmlkatb1 = "<table id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
				"<thead>" +
				"<tr>" +
				"<th style='text-align:center;width:85%'>Kategori</th>" +
				"<th style='text-align:center;'>Edit</th>" +
				"<th style='text-align:center;'>Delete</th>" +
				"</tr>" +
				"</thead>" +
				"<tbody>";
			isihtmlkatb1n = "<table id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
				"<thead>" +
				"<tr>" +
				"<th style='text-align:center;width:85%'>Kategori</th>" +
				"</tr>" +
				"</thead>" +
				"<tbody>";
			isihtmlkatb3 = "</div></tbody></table>";
			$.ajax({
				url: "<?php echo base_url(); ?>video/delkat",
				method: "POST",
				dataType: 'json',
				data: {
					idkate: idpilih
				},
				success: function (result) {
					if (result=="")
					{
						alert ("KATEGORI ini tidak bisa dihapus karena ada yang menggunakan");
					}
					else {
						isihtmlkatb2 = "";
						isihtmlkatb2n = "";
						var jmlkat = 0;
						$.each(result, function (i, result) {
							jmlkat++;
							indeks[jmlkat] = result.id;
							teksedit[jmlkat] = result.nama_kategori;
							isihtmlkatb2 = isihtmlkatb2 + "<tr><td>" + result.nama_kategori + "</td>" +
								"<td style='text-align:center;'><button onclick=\"dieditkat('" +
								jmlkat + "')\" type=\"button\">Edit</button></td>" +
								<?php
								{?>
								"<td style='text-align:center;'><button onclick=\"deletekat('" +
								jmlkat + "')\" type=\"button\">Hapus</button></td>" +
								<?php }
								?>
								"</tr>";
							isihtmlkatb2n = isihtmlkatb2n + "<tr><td>" + result.nama_kategori + "</td>" +
								"</tr>";
						});
						<?php if($this->session->userdata('a01') || $this->session->userdata('sebagai')==4)
						{?>
						$('#isidaftar3').html(isihtmlkatb1 + isihtmlkatb2 + isihtmlkatb3);
						<?php } else {?>
						$('#isidaftar3').html(isihtmlkatb1n + isihtmlkatb2n + isihtmlkatb3);
						<?php } ?>
						bataltambahkat();
					}
				},
				error: function () {
					alert('error!');
				}
			})


		} else {
			return false;
		}
		return false;
	}

	function diedit(idx) {
		//alert (indeks[idx]);
		idpilih = indeks[idx];
		kadepilih = teksedit[idx];

		$('#tbtambah').hide();
		$('#grupedit').show();
		$('#ikade2').val(kadepilih);

	}

	function dieditkat(idx) {
		//alert (indeks[idx]);
		idpilih = indeks[idx];
		kadepilih = teksedit[idx];

		$('#tbtambahkat').hide();
		$('#grupeditkat').show();
		$('#ikatekat').val(kadepilih);

	}

	function bataledit() {
		$('#tbtambah').show();
		$('#grupedit').hide();
	}

	function bataleditkat() {
		$('#tbtambahkat').show();
		$('#grupeditkat').hide();
	}

	function updatekd() {
		isihtmld1 = "<table id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
			"<thead>" +
			"<tr>" +
			"<th style='text-align:center;width:85%'>Kompetensi Dasar</th>" +
			"<th style='text-align:center;'>Edit</th>" +
			"</tr>" +
			"</thead>" +
			"<tbody>";
		isihtmld1n = "<table id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
			"<thead>" +
			"<tr>" +
			"<th style='text-align:center;width:85%'>Kompetensi Dasar</th>" +
			"</tr>" +
			"</thead>" +
			"<tbody>";
		isihtmld3 = "</div></tbody></table>";

		$.ajax({
			url: "<?php echo base_url(); ?>video/editkd",
			method: "POST",
			dataType: 'json',
			data: {
				idkade: idpilih,
				tekskade: $('#ikade2').val(),
				idkelas: $('#ikelas').val(),
				idmapel: $('#imapel').val(),
				idki: $('#iki1').val(),
				npsn: $('#npsnsekolah').val(),
				kurikulum: $('#ikurikulum').val()
			},
			success: function (result) {
				isihtmld2 = "";
				isihtmld2n = "";
				isihtmld2u = "";
				var jmlkd = 0;
				$.each(result, function (i, result) {
					jmlkd++;
					indeks[jmlkd] = result.id;
					teksedit[jmlkd] = result.nama_kd;
					isihtmld2 = isihtmld2 + "<tr><td>" + result.nama_kd + "</td>" +
						"<td style='text-align:center;'>"+
						"<button onclick=\"diedit('" +
						jmlkd + "')\" type=\"button\">Edit</button>"+
						"</td></tr>";

					isihtmld2u = isihtmld2u + "<tr><td>" + result.nama_kd + "</td>" +
						"<td style='text-align:center;'>"+
						"<button onclick=\"diedit('" +
						jmlkd + "')\" type=\"button\">Edit</button>"+
						"<button onclick=\"deletekd('" +
						jmlkd + "')\" type=\"button\">Hapus</button>"+
						"</td></tr>";

					isihtmld2n = isihtmld2n + "<tr><td>" + result.nama_kd + "</td>" +
						"</tr>";

				});

				if (npsnku>0 && $('#istandar').val()==0)
				{
					$('#isidaftar2').html(isihtmld1n + isihtmld2n + isihtmld3);
				}
				else
				{
					$('#isidaftar2').html(isihtmld1 + isihtmld2u + isihtmld3);
				}
				<?php if($this->session->userdata('a01'))
				{?>
				$('#isidaftar2').html(isihtmld1 + isihtmld2u + isihtmld3);
				<?php } else if($this->session->userdata('sebagai')==4)
				{?>
				$('#isidaftar2').html(isihtmld1 + isihtmld2 + isihtmld3);
				<?php }
				?>
				bataledit();
			},
			error: function () {
				alert('error!');
			}
		})
	}

	function deletekd(idx) {
		var r = confirm("Yakin mau hapus?");
		if (r == true) {
			idpilih = indeks[idx];
			isihtmld1 = "<table id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
				"<thead>" +
				"<tr>" +
				"<th style='text-align:center;width:85%'>Kompetensi Dasar</th>" +
				"<th style='text-align:center;'>Edit</th>" +
				"</tr>" +
				"</thead>" +
				"<tbody>";
			isihtmld1n = "<table id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
				"<thead>" +
				"<tr>" +
				"<th style='text-align:center;width:85%'>Kompetensi Dasar</th>" +
				"</tr>" +
				"</thead>" +
				"<tbody>";
			isihtmld3 = "</div></tbody></table>";

			$.ajax({
				url: "<?php echo base_url(); ?>video/delkd",
				method: "POST",
				dataType: 'json',
				data: {
					idkade: idpilih,
					idkelas: $('#ikelas').val(),
					idmapel: $('#imapel').val(),
					idki: $('#iki1').val(),
					npsn: $('#npsnsekolah').val(),
					kurikulum: $('#ikurikulum').val()
				},
				success: function (result) {
					if (result=="")
					{
						alert ("KD ini tidak bisa dihapus karena ada yang menggunakan");
					}
					else {
						isihtmld2 = "";
						isihtmld2u = "";
						isihtmld2n = "";
						var jmlkd = 0;
						$.each(result, function (i, result) {
							jmlkd++;
							indeks[jmlkd] = result.id;
							teksedit[jmlkd] = result.nama_kd;
							isihtmld2 = isihtmld2 + "<tr><td>" + result.nama_kd + "</td>" +
								"<td style='text-align:center;'>" +
								"<button onclick=\"diedit('" +
								jmlkd + "')\" type=\"button\">Edit</button>" +
								"</td></tr>";

							isihtmld2u = isihtmld2u + "<tr><td>" + result.nama_kd + "</td>" +
								"<td style='text-align:center;'>" +
								"<button onclick=\"diedit('" +
								jmlkd + "')\" type=\"button\">Edit</button>" +
								"<button onclick=\"deletekd('" +
								jmlkd + "')\" type=\"button\">Hapus</button>" +
								"</td></tr>";

							isihtmld2n = isihtmld2n + "<tr><td>" + result.nama_kd + "</td>" +
								"</tr>";

						});

						if (npsnku > 0 && $('#istandar').val() == 0) {
							$('#isidaftar2').html(isihtmld1n + isihtmld2n + isihtmld3);
						} else {
							$('#isidaftar2').html(isihtmld1 + isihtmld2u + isihtmld3);
						}
						<?php if($this->session->userdata('a01'))
						{?>
						$('#isidaftar2').html(isihtmld1 + isihtmld2u + isihtmld3);
						<?php } else if($this->session->userdata('sebagai') == 4)
						{?>
						$('#isidaftar2').html(isihtmld1 + isihtmld2 + isihtmld3);
						<?php }
						?>
						bataledit();
					}
				},
				error: function (result) {
					alert('error!');
				}
			})



		} else {
			return false;
		}
		return false;

	}

	function updatekat() {
		isihtmlkatc1 = "<table id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
			"<thead>" +
			"<tr>" +
			"<th style='text-align:center;width:85%'>Kategori</th>" +
			"<th style='text-align:center;'>Edit</th>" +
			"<th style='text-align:center;'>Delete</th>" +
			"</tr>" +
			"</thead>" +
			"<tbody>";
		isihtmlkatc1n = "<table id=\"tbl_user\" class=\"table table-bordered nowrap\" cellspacing=\"0\" width=\"100%\">" +
			"<thead>" +
			"<tr>" +
			"<th style='text-align:center;width:85%'>Kategori</th>" +
			"</tr>" +
			"</thead>" +
			"<tbody>";
		isihtmlkatc3 = "</div></tbody></table>";
		$.ajax({
			url: "<?php echo base_url(); ?>video/editkat",
			method: "POST",
			dataType: 'json',
			data: {
				idkate: idpilih,
				tekskate: $('#ikatekat').val()
			},
			success: function (result) {
				isihtmlkatc2 = "";
				isihtmlkatc2n = "";
				var jmlkat = 0;
				$.each(result, function (i, result) {
					jmlkat++;
					indeks[jmlkat] = result.id;
					teksedit[jmlkat] = result.nama_kategori;
					isihtmlkatc2 = isihtmlkatc2 + "<tr><td>" + result.nama_kategori + "</td>" +
						"<td style='text-align:center;'><button onclick=\"dieditkat('" +
						jmlkat + "')\" type=\"button\">Edit</button></td>" +
						<?php
						{?>
						"<td style='text-align:center;'><button onclick=\"deletekat('" +
						jmlkat + "')\" type=\"button\">Hapus</button></td>" +
						<?php }
						?>
						"</tr>";
					isihtmlkatc2n = isihtmlkatc2n + "<tr><td>" + result.nama_kategori + "</td>" +
						"</tr>";
				});
				<?php if($this->session->userdata('a01') || $this->session->userdata('sebagai')==4)
				{?>
				$('#isidaftar3').html(isihtmlkatc1 + isihtmlkatc2 + isihtmlkatc3);
				<?php } else {?>
				$('#isidaftar3').html(isihtmlkatc1n + isihtmlkatc2n + isihtmlkatc3);
				<?php } ?>
				bataleditkat();
			},
			error: function () {
				alert('error!');
			}
		})
	}


</script>
