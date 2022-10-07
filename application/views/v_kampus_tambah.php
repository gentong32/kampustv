<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$jml_propinsi = 0;
foreach ($dafpropinsi as $datane) {
	$jml_propinsi++;
	$id_propinsi[$jml_propinsi] = $datane->id_propinsi;
	$nama_propinsi[$jml_propinsi] = substr($datane->nama_propinsi,8);
}
?>

<!-- content begin -->
<div class="no-bottom no-top" id="content">
    <div id="top"></div>
    <!-- section begin -->
    <section
        id="subheader"
        class="text-light"
        data-bgimage="url(<?php echo base_url(); ?>images/background/subheader.jpg) top">
        <div class="center-y relative text-center">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 text-center wow fadeInRight" data-wow-delay=".5s">
                        <h1>Tambah Kampus</h1>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- section close -->

    <section aria-label="section" class="pt30">
        <div class="container">
            <div class="row">

			    <br>
				<center><span style="font-size:18px;font-weight: bold;">MENAMBAHKAN KAMPUS BARU</span></center>
				<br><br>
				<div>
					<button type="button" class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>channel/daftarkampus/'">
						Kembali
					</button>
				</div>
				<hr style="margin-top: 10px;">
				
                <div style="max-width:900px;margin:auto">
                    <div class="form-group">
						<div class="row">
							<div class="col-lg-4 col-md-4">
								NPSN / Kode Kampus
							</div>
							<div class="col-lg-8 col-md-8">
								<input type="text" class="form-control"
								id="inpsn" name="inpsn" maxlength="11" value="">
							</div>
						</div>
                    </div>
                    <div class="form-group">
						<div class="row">
							<div class="col-lg-4 col-md-4">
								Nama Kampus (dan singkatan)
							</div>
							<div class="col-lg-8 col-md-8">
								<input type="text" class="form-control"
								id="isekolah" name="isekolah" maxlength="100" value="">
							</div>
						</div>
                    </div>
                    <div class="form-group">
						<div class="row">
							<div class="col-lg-4 col-md-4">
								Propinsi
							</div>
							<div class="col-lg-8 col-md-8">
                                <select class="form-control" name="ipropinsi" id="ipropinsi">
                                    <option value="0">-- Pilih --</option>
                                    <?php
                                    for ($a = 1; $a <= $jml_propinsi; $a++) {
                                        echo '<option value="' . $id_propinsi[$a] . '">' . $nama_propinsi[$a] . '</option>';
                                    }
                                    ?>
                                </select>
							</div>
						</div>
                    </div>
                    <div class="form-group">
						<div class="row">
							<div class="col-lg-4 col-md-4">
								Kota
							</div>
							<div id="dkota" class="col-lg-8 col-md-8">
                                <select class="form-control" name="ikota" id="ikota">
                                    <option value="0">-- Pilih --</option>
                                </select>
							</div>
						</div>
                    </div>
                    <div class="form-group">
						<div class="row">
							<div class="col-lg-4 col-md-4">
								Kecamatan
							</div>
							<div class="col-lg-8 col-md-8">
								<input type="text" class="form-control"
								id="ikecamatan" name="ikecamatan" maxlength="50" value="">
							</div>
						</div>
                    </div>
                    <div class="form-group">
						<div class="row">
							<div class="col-lg-4 col-md-4">
								Alamat Kampus
							</div>
							<div class="col-lg-8 col-md-8">
								<input type="text" class="form-control"
								id="ialamat" name="ialamat" maxlength="250" value="">
							</div>
						</div>
                    </div>

                    <div class="form-group">
                        <div class="row">
							<div class="col-lg-4 col-md-4">
                                Logo Kampus
							</div>
                            <div class="col-lg-8 col-md-8">
                                <div style=";width: 300px;height: auto;">
                                    <table style="width:220px;border: 1px solid black;">
                                        <tr>
                                            <th>
                                                <img id="previewing" width="220px" src="<?php echo base_url()."assets/images/school_blank.jpg";?>">
                                            </th>
                                        </tr>

                                    </table>

                                    <form method="POST" enctype="multipart/form-data" id="fileUploadForm2">
                                    </form>

                                    <form class="form-horizontal" id="submit1">
                                        <div class="form-group" style="margin-left: 5px">
                                            <input type="file" name="file1" id="file1" accept="image/*">
                                            <span style="margin-left: 30px" id="message1"></span>
                                        </div>
                                    </form>

                                </div>
                                <h4 style="display: none;" id='loading1'>uploading ... </h4>

				            </div>
                        </div>
                    </div>
                    
                    <center>
                    <div>
                        <button class="btn-main" id="btn_upload1">SUBMIT</button>
                    </div>
                    </center>

                    <input
                        type="hidden"
                        name="npsnsekolah"
                        id="npsnsekolah"
                        value="<?php echo $this->session->userdata('npsn'); ?>">

                    <?php
					?>
                </div>
            </div>
        </div>
    </section>
</div>

<script>

    $(document).on('change', '#ipropinsi', function () {
        getdaftarkota();
    });

    function getdaftarkota() {
        isihtml1 = '<select class="form-control" name="ikota" id="ikota"><option value="0">-- Pilih --</option>';
        isihtml3 = '</select>';
        $.ajax({
            type: 'GET',
            data: {
                idpropinsi: $('#ipropinsi').val()
            },
            dataType: 'json',
            cache: false,
            url: '<?php echo base_url();?>login/daftarkota',
            success: function (result) {
                isihtml2 = "";
                $.each(result, function (i, result) {
                    isihtml2 = isihtml2 + "<option value='" + result.id_kota + "'>" + result.nama_kota +
                            "</option>";
                });
                $('#dkota').html(isihtml1 + isihtml2 + isihtml3);
            }
        });
    }

    $("#file1").change(function() {
			$("#message1").empty(); // To remove the previous error message
			var file1 = this.files[0];
			var imagefile1 = file1.type;
			var match1= ["image/jpeg","image/png","image/jpg"];
			if(!((imagefile1==match1[0]) || (imagefile1==match1[1]) || (imagefile1==match1[2])))
			{
				$("#message1").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
				return false;
			}
			else
			{
				var reader1 = new FileReader();
				reader1.onload = imageIsLoaded1;
				reader1.readAsDataURL(this.files[0]);
			}
		});

    function imageIsLoaded1(e) {
        $("#file1").css("color","green");
        $('#previewing').attr('src', e.target.result);
        $('#previewing').attr('width', '250px');
        $('#previewing').attr('height', '230px');
    };

    $("#btn_upload1").click(function (event) {
        $('#loading1').show();
		event.preventDefault();
		//var form = $("#fileUploadForm")[0];
		var formData = new FormData();
		var file = $('#file1').prop('files')[0];
        var kodekampus = $("#inpsn").val();
        var namakampus = $("#isekolah").val();
        var ikota = $("#ikota").val();
        var ikecamatan = $("#ikecamatan").val();
        var ialamat = $("#ialamat").val();
		formData.append("logofile",file);
        formData.append("kodekampus",kodekampus);
        formData.append("namakampus",namakampus);
        formData.append("ikota",ikota);
        formData.append("ikecamatan",ikecamatan);
        formData.append("ialamat",ialamat);
        
		$.ajax({
			url: "<?php echo base_url();?>login/upload_foto_sekolah",
			data: formData,
			type: 'POST',
			cache: false,
            contentType: false,
            processData: false,
			success: function (e) {
                // alert (e);
                $('#loading1').hide();
                if (e=="sukses")
                    window.open('<?php echo base_url();?>channel/daftarkampus/');
                else
                    $("#message1").html(e);
			}
		});

	});

</script>