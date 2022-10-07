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
                    <div class="form-group">
						<div class="row">
							<div class="col-lg-4 col-md-4">
								Kode Prodi
							</div>
							<div class="col-lg-8 col-md-8">
								<input type="text" class="form-control"
								id="ikode" name="ikode" maxlength="11" value="">
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
                    
                    
                    <center>
                    <div>
                        <button class="btn-main" type="submit">SUBMIT</button>
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
