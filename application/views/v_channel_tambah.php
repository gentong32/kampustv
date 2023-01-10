<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
                        <h1>Tambah Prodi</h1>
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
                <?php
				echo form_open('channel/addprodi', array('autocomplete' => 'off', 'id' => 'myform'));
				?>
			    <br>
				<center><span style="font-size:18px;font-weight: bold;">MENAMBAHKAN PRODI BARU</span></center>
				<br><br>
				<div>
					<button type="button" class="btn-main"
							onclick="window.location.href='<?php echo base_url(); ?>channel/daftarprodi/'">
						Kembali
					</button>
				</div>
				<hr style="margin-top: 10px;">

                <div style="max-width:900px;margin:auto">
                    <?php if ($this->session->userdata('siag')==3) {?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    Nama Kampus
                                </div>
                                <div class="col-lg-8 col-md-8">
                                    <input readonly type="text" class="form-control"
                                        value="<?php echo $namakampus;?>">
                                </div>
                            </div>
                        </div>
                    <input type="hidden" id="ikampus" name="ikampus" value="<?php 
                        echo $this->session->userdata('npsn');?>">
                    <?php } ?>

                    <div class="form-group">
						<div class="row">
							<div class="col-lg-4 col-md-4">
								Kode Prodi
							</div>
							<div class="col-lg-8 col-md-8">
								<input type="text" class="form-control"
								id="ikode" name="ikode" maxlength="11" value="">
                                <label class="text-danger"><span><div id="kode_result"></div>
            				</span></label>
							</div>
						</div>
                    </div>
                    <div class="form-group">
						<div class="row">
							<div class="col-lg-4 col-md-4">
								Nama Prodi
							</div>
							<div class="col-lg-8 col-md-8">
								<input type="text" class="form-control"
								id="iprodi" name="iprodi" maxlength="100" value="">
							</div>
						</div>
                    </div>

                    <?php if ($this->session->userdata('a01')) {?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    Kampus
                                </div>
                                <div class="col-lg-8 col-md-8">
                                    <select class="form-control" name="ikampus" id="ikampus">
                                        <option value="0">-- Pilih --</option>
                                        <?php
                                        foreach ($dafkampus as $datarow) {
                                            echo '<option value="' . $datarow->npsn_sekolah . '">' . $datarow->nama_sekolah . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    
                    
                    <center>
                    <div>
                        <button onclick="return ceksubmit()" class="btn-main">SUBMIT</button>
                    </div>
                    </center>

                    <?php
					?>
                </div>
                <?php
                echo form_close() . '';
                ?>
            </div>
        </div>
    </section>
</div>

<script>
$(document).on('blur', '#ikode', function () {
    var kode = $('#ikode').val();
    var $result = $("#kode_result");
    var npsn = "<?php echo $this->session->userdata('npsn');?>";
    $result.text("");
    $.ajax({
        url: "<?php echo base_url(); ?>channel/cekprodi",
        method: "POST",
        data: {kode: kode, npsn: npsn},
        success: function (data) {
            $('#kode_result').html(data);
        }
    });
});

function ceksubmit() {
        if ($('#kode_result').html() == "" && $('#ikode').val()!="" && $('#iprodi').val()!="")
        {
            document.getElementById('myform').submit();
        } else {
            alert("Periksa kembali data anda!");
            return false;
        }
    }
</script>