<div class="navbar navbar-light navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="<?php echo base_url(); ?>home" class="navbar-brand navbar-title">HOME</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <img width="20" height="20" src="<?php echo base_url(); ?>assets/images/dl_iko.png" />
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Menu <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                  <li style="font-size: 15px; font-weight: bold">
                      <a href="<?php echo base_url(); ?>">Beranda</a>
                  </li>
              <?php if ($this->session->userdata('a01') || $this->session->userdata('tukang_verifikasi')==1 || $this->session->userdata('tukang_verifikasi')==2) 
              { ?>
                <li><a href="<?php echo base_url(); ?>beranda"><span class="menuku">Statistik</span></a></li>
                <li><a href="<?php echo base_url(); ?>user"><span class="menuku">Daftar User</span></a></li>
              <?php }?>
              <?php if ($this->session->userdata('a01')) { ?>
                <li><a href="<?php echo base_url(); ?>user/verifikator"><span class="menuku">Calon Verifikator</span></a></li>
              <?php }?>
              <?php
              if ($this->session->userdata('a01') || $this->session->userdata('tukang_verifikasi')==1
              || $this->session->userdata('tukang_verifikasi')==2) {
               ?>
                <li><a href="<?php echo base_url(); ?>user/kontributor"><span class="menuku">Calon Kontributor</span></a></li>
                <li class="divider"></li>
              <?php } ?>
              <?php if ($this->session->userdata('a01') || $this->session->userdata('tukang_verifikasi')==1 
            ||  $this->session->userdata('tukang_verifikasi')==2 || $this->session->userdata('tukang_kontribusi')==1 
            || $this->session->userdata('tukang_kontribusi')==2) {?>
                <li><a href="<?php echo base_url(); ?>video"><span class="menuku">VOD</span></a></li>
                
              <?php } ?>
                <li><a href="#"><span class="menuku">Menu Lain</span></a></li>
                
              </ul>
            </li>
            <li>
              <a href="#">Bantuan</a>
            </li>
            <li>
              <a href="#">Hubungi Kami</a>
            </li>
            

          </ul>

          <ul class="nav navbar-nav navbar-right">
          <li>
              <?php echo anchor('login/profile', $this->session->userdata('first_name'))?>
            </li>
            <li>
                    <?php 
                      echo anchor('login/logout', 'Logout') ;
                    ?>
            </li>
          </ul>
          
        </div>
    </div>
</div>
