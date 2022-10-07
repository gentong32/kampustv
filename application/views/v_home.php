<div class="container">
    <div class="row">
        <div class="row">
            <?php
            if ($this->session->userdata('a01') || $this->session->userdata('tukang_verifikasi')==1 ||
            $this->session->userdata('tukang_verifikasi')==2) {
            ?>
            <div class="col-md-4">
                <div class="thumbnail">
                    <img src="images/thumb.jpg" alt="...">
                    <div class="caption">
                        <p><a href="user" class="btn btn-primary" role="button">Daftar User</a> </p>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php
            if ($this->session->userdata('a01')) {
            ?>
            <div class="col-md-4">
                <div class="thumbnail">
                    <img src="images/thumb-2.jpg" alt="...">
                    <div class="caption">
                        <a href="user/verifikator" class="btn btn-primary" role="button">Calon Verifikator</a> </p>
                    </div>
                </div>
            </div>
            <?php
            } 
            ?>
            <?php
            if ($this->session->userdata('a01') || $this->session->userdata('tukang_verifikasi')==1
            || $this->session->userdata('tukang_verifikasi')==2) {
            ?>
            <div class="col-md-4">
                <div class="thumbnail">
                    <img src="images/thumb-2.jpg" alt="...">
                    <div class="caption">
                        <a href="user/kontributor" class="btn btn-primary" role="button">Calon Kontributor</a> </p>
                    </div>
                </div>
            </div>
            <?php
            } 
            ?>
        </div>
    </div>
        
    <div class="row">
        <div class="row">
            <?php if ($this->session->userdata('a01') || $this->session->userdata('tukang_verifikasi')==1 || $this->session->userdata('tukang_verifikasi')==2 
            || $this->session->userdata('tukang_kontribusi')==1 || $this->session->userdata('tukang_kontribusi')==2) {?>
            <div class="col-md-4">
                <div class="thumbnail">
                    <img src="images/thumb.jpg" alt="...">
                    <div class="caption">
                        <p><a href="video" class="btn btn-primary" role="button">V O D</a> </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="thumbnail">
                    <img src="images/thumb.jpg" alt="...">
                    <div class="caption">
                        <p><a href="beranda" class="btn btn-primary" role="button">Statistik</a> </p>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!-- <div class="col-md-4">
                <div class="thumbnail">
                    <img src="images/thumb-2.jpg" alt="...">
                    <div class="caption">
                        <a href="video/tambah" class="btn btn-primary" role="button">Tambah Video</a> </p>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

</div>
