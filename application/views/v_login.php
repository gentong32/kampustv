<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>V</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url();?>css/bootstrap.min.css?v=2500" media="screen">
    <link rel="stylesheet" href="<?php echo base_url();?>css/theme.css?v=2501">
    <link rel="stylesheet" href="<?php echo base_url();?>css/mystyle.css">
    <script type="text/javascript" src="<?php echo base_url();?>js/login.js"></script>
<!--    <script type="text/javascript" src="--><?php //echo base_url();?><!--js/jquery-3.4.1.js"></script>-->
	  <script src="<?php echo base_url(); ?>js/jquery-3.4.1.js"></script>
  </head>
  <body>
      
  <div class="container"> 
      <div class="row">
        <div class="bp-component">
          <div class="jumbotron">
            <h1></h1>
          </div>
        </div>
      </div>
      
      
      <!-- Forms INPUT 
      ================================================== -->
      <div class="bp-docs-section">

        <div class="row">
          <div id="tbdaftar" style="text-align:center;float:right">
          <a href="#" onclick="return cekdaftar(1)">
          <img width="20px" height="20px" src="<?php echo base_url();?>assets/images/signup.png">
		    	<br />
			    Daftar</a>
          </div>
          <div id="tblogin" style="text-align:center;float:right;display:none">
          <a href="#" onclick="return cekdaftar(2)">
          <img width="20px" height="20px" src="<?php echo base_url();?>assets/images/login.png">
		    	<br />
			    Login</a>
          </div>
          <div id="tbdaftar" style="text-align:center;float:right">
          <a href="#" onclick="return cekdaftar(0)">
          <img width="20px" height="20px" src="<?php echo base_url();?>assets/images/login.png">
		    	<br />
			    Depan</a>&nbsp;&nbsp;
          </div>
        </div>

        <div id="l_login">
        <div class="row">
          <div class="well bp-component">
            <?php
              echo form_open(site_url('login/login'));
            ?>
                <fieldset>
                  <legend>Login</legend>
                  <div>
                    <label for="inputEmail" class="control-label">Email address</label>
                    <div>
                      <span style="text-align: left"></span>
                      <span style="text-align: left"></span>
                      <?php echo form_input('username', $username, 'class="form-control" placeholder="Username" onfocus="clear_1()"') ?>
                    </div>
                  </div>
                  <div>
                    <label for="inputPassword" class="control-label">Password</label>
                    <div>
                      <?php echo form_password('password', $password, 'class="form-control" placeholder="Password" onfocus="clear_1()"') ?>
                      <div>
                        <label>
                        <?php echo form_checkbox('remember', TRUE, $remember) ?> Ingat Saya
                        </label>
                      </div>
                    </div>
                  </div>
                                    
                  <div>
                    <?php  echo form_submit('submit', 'Sign In', 'class="btn btn-default"') ?>
                    <span id="keterangan" class="text-danger" style="margin-left: 10px"><?php echo $message ?></span>
                    <?php echo form_close(); ?>
                  </div>

                </fieldset>
            <?php
              echo form_close();
            ?>
              <!-- </form> -->

            <br>       

            <div class="wrapper">
              <div class="box sidebar">
                  <a href="<?php echo $loginURL; ?>"><img src="<?php echo base_url('assets/images/google-sign-in-btn.png'); ?>"/></a>
              </div>
              <div class="box sidebar2">
                <a href="<?php echo $authURL; ?>"><img src="<?php echo base_url('assets/images/fb-login-btn.png'); ?>"></a>
              </div>
            </div>

          </div>             
        </div>
        </div>

        <div id="l_register" style="display:none;">
        <div class="row">
          <div class="col-xs-12">
            <div class="portlet light">
              <div class="portlet-body form">
                <div class="row">
                  <div style="text-align:center" class="col-xs-12">
                    <h3>Silahkan pilih pekerjaan anda</h3>
                  </div>
                  <div class="col-xs-12">
                    <div class="row">
                      <div style="text-align:center" class="col-xs-12 col-md-3">
                        <div class="regisration-selection">
                        <a href="<?php echo base_url();?>login/register/staf" class="btn green2 btn-hover-slide">
                          <img src="<?php echo base_url();?>assets/images/guru.png" class="img-responsive" />
                          <span>Staf Pustekkom</span>
                          </a>                        
                        </div>
                      </div>
                      <div class="col-xs-12 col-md-3">
                        <div style="text-align:center" class="regisration-selection">
                          <a href="<?php echo base_url();?>login/register/guru" class="btn green2 btn-hover-slide">
                          <img src="<?php echo base_url();?>assets/images/guru.png" class="img-responsive" />
                          <span>Guru</span>
                          </a>
                        </div>
                      </div>
                      <div style="text-align:center" class="col-xs-12 col-md-3">
                        <div class="regisration-selection">
                        <a href="<?php echo base_url();?>login/register/siswa" class="btn green2 btn-hover-slide">
                          <img src="<?php echo base_url();?>assets/images/siswa.png" class="img-responsive" />
                          <span>Siswa</span>
                          </a>
                        </div>
                      </div>
                      <div style="text-align:center" class="col-xs-12 col-md-3">
                        <div class="regisration-selection">
                        <a href="<?php echo base_url();?>login/register/umum" class="btn green2 btn-hover-slide">
                          <img src="<?php echo base_url();?>assets/images/umum.png" class="img-responsive" />
                          <span>Umum</span>
                          </a>                        
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>



      </div>
  </div>
  </body>
</html>


<script>

</script>

<!-- <script>
function clear_2() {
var x = document.getElementById("keterangan");
x.innerHTML = "";
}
</script> -->
