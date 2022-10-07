<!-- dashboard inner -->
<div class="midde_cont">
	<div class="container-fluid">
		<div class="row column_title">
			<div class="col-md-12">
				<div class="page_title">
					<h2>Sekolah Saya</h2>
				</div>
			</div>
		</div>
		<!-- row -->
		<div class="row column2 graph margin_bottom_30">
			<div class="col-md-l2 col-lg-12">
				<div class="white_shd full margin_bottom_30">
					<div class="full graph_head">
						<div class="heading1 margin_0">
							<h2>Data Sekolah</h2>
						</div>
					</div>
					<div class="full price_table padding_infor_info">
						<div class="row">
							<!-- user profile section -->
							<!-- profile image -->
							<div class="col-lg-12">
								<div class="full dis_flex center_text">
									<div class="profile_img"><img width="180" class="rounded-circle"
																  src="<?php if(substr($profilku->logosekolah,-3)=="png"
																	  || substr($profilku->logosekolah,-3)=="jpg" ||
																	  substr($profilku->logosekolah,-3)=="peg")
																  	echo $profilku->logosekolah;
																  else
																	  echo base_url()."assets/images/tutwuri.png";?>" alt="#"/></div>
									<div class="profile_contant">
										<div class="contact_inner">
											<h3><?php echo $profilku->sekolah.$statussekolah;?></h3>
											<ul class="list-unstyled">
												<li><i class="fa fa-home"></i> : <?php
													echo $profilku->alamat_sekolah.'<br>'.$namakota.", ".$namapropinsi.
														'<br>NPSN: '.$profilku->npsn;?> </li>
												<li><i class="fa fa-info"></i> :<br> <?php
													echo 'NISN: '.$profilku->nomor_nasional;?>
													<?php if($this->session->userdata('verifikator')!=3){ 
														if ($this->session->userdata('verifikator')==2 && $namaverifikator=="-")
														{

														}
														else 
														{
														?>
													<hr>
													<br>Verifikator Sekolah:<br>
													<i class="fa fa-user"></i> <?php echo $namaverifikator;?><br>
													<i class="fa fa-envelope"></i> <?php echo $emailverifikator;?><br>
													<i class="fa fa-phone"></i> <?php echo $telpverifikator;?><br>
													<?php }
													}
													if ($this->session->userdata('sebagai')!=4) {
														if ($this->session->userdata('bimbel')==3) {
															if ($namaverbimbel != "-" && $namaverbimbel == $namaag) { ?>
																<br>
																<hr>Agency / Verifikator Bimbel:<br>
																<i class="fa fa-user"></i> <?php echo $namaverbimbel; ?>
																<br>
																<i class="fa fa-envelope"></i> <?php echo $emailverbimbel; ?>
																<br>
																<i class="fa fa-phone"></i> <?php echo $telpverbimbel; ?>
																<br>
															<?php } else if ($namaverbimbel != "-" && $namaverbimbel != $namaag) { ?>
																<br>
																<hr>Verifikator Bimbel:<br>
																<i class="fa fa-user"></i> <?php echo $namaverbimbel; ?>
																<br>
																<i class="fa fa-envelope"></i> <?php echo $emailverbimbel; ?>
																<br>
																<i class="fa fa-phone"></i> <?php echo $telpverbimbel; ?>
																<br>
																<?php if(($referrer != "" && $referrer != null) && $namaag!="-"){?>
																	<hr>Agency aktif berasal dari kota lain:<br>
																	<i class="fa fa-user"></i> <?php echo $namaag; ?><br>
																	<i class="fa fa-envelope"></i> <?php echo $emailag; ?>
																	<br>
																	<i class="fa fa-phone"></i> <?php echo $telpag; ?><br> <?php } ?>
															<?php } else if ($namaverbimbel == "-" && $namaverbimbel != $namaag) { ?>
																<hr>
																Belum tersedia Agency / Verifikator Bimbel di kota Anda. Hubungi Admin:
																<br>
																<i class="fa fa-user"></i>Sigit Wiryawan<br>
																<i class="fa fa-phone"></i>0815-4236-9117<br>
																<?php if(($referrer != "" && $referrer != null) && $namaag!="-"){?>
																<hr>Agency aktif berasal dari kota lain:<br>
																<i class="fa fa-user"></i> <?php echo $namaag; ?><br>
																<i class="fa fa-envelope"></i> <?php echo $emailag; ?>
																<br>
																<i class="fa fa-phone"></i> <?php echo $telpag; ?><br> <?php } ?>
															<?php } else if ($namaverbimbel != "-" && $namaag == "-") { ?>
																<br>
																<hr>Verifikator Bimbel:<br>
																<i class="fa fa-user"></i> <?php echo $namaverbimbel; ?>
																<br>
																<i class="fa fa-envelope"></i> <?php echo $emailverbimbel; ?>
																<br>
																<i class="fa fa-phone"></i> <?php echo $telpverbimbel; ?>
																<br>
																<hr>Agency tidak berperan aktif<br>
															<?php } else if ($namaverbimbel == "-" && $namaag == "-") {
																?>
																<hr>
																Belum tersedia Agency / Verifikator Bimbel di kota Anda. Hubungi Admin:
																<br>
																<i class="fa fa-user"></i>Sigit Wiryawan<br>
																<i class="fa fa-phone"></i>0815-4236-9117<br>
															<?php }
														}
														else
														{
															if ($this->session->userdata('sebagai')!=2) {
																if ($namaag != "-") { ?>
																	<br>
																	<hr>Agency<br>
																	<i class="fa fa-user"></i> <?php echo $namaag; ?>
																	<br>
																	<i class="fa fa-envelope"></i> <?php echo $emailag; ?>
																	<br>
																	<i class="fa fa-phone"></i> <?php echo $telpag; ?>
																	<br>
																<?php } else {?>
																	<hr>Agency tidak berperan aktif<br>
																<?php }
															}
														}
														if (($referrer == "" || $referrer == null) && ($namaam != "-")
														&& ($this->session->userdata('sebagai')==1)) {
															?>
															<span style='color:red;'>
														<br>Apakah Mentor [<?php echo $namaam;?>] sudah mengunjungi Sekolah Anda? Abaikan jika tidak.</span>
															<br>Kode: <?php echo $koderef; ?>
															<br>
															<button onclick="salinteks()" style='padding: 3px;'
																	class='btn-primary'>Salin Kode
															</button>
														<?php } else {
															if ($namaam != "-") { ?>
																<hr>
																Mentor:<br>
																<i class="fa fa-user"></i> <?php echo $namaam; ?><br>
																<i class="fa fa-envelope"></i> <?php echo $emailam; ?>
																<br>
																<i class="fa fa-phone"></i> <?php echo $telpam; ?><br>
															<?php }
														}
													}?>

												</li>

											</ul>
										</div>
										<div class="user_progress_bar" style="display: none;">
											<div class="progress_bar">
												<!-- Skill Bars -->
												<span class="skill" style="width:85%;">Tugas Ekskul <span
														class="info_valume">85%</span></span>
												<div class="progress skill-bar ">
													<div class="progress-bar progress-bar-animated progress-bar-striped"
														 role="progressbar" aria-valuenow="85" aria-valuemin="0"
														 aria-valuemax="100" style="width: 85%;">
													</div>
												</div>
												<span class="skill" style="width:65%;">Kelas Virtual<span
														class="info_valume">65%</span></span>
												<div class="progress skill-bar">
													<div class="progress-bar progress-bar-animated progress-bar-striped"
														 role="progressbar" aria-valuenow="65" aria-valuemin="0"
														 aria-valuemax="100" style="width: 65%;">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- profile contant section -->
								<div class="full inner_elements margin_top_30" style="display: none;">
									<div class="tab_style2">
										<div class="tabbar">
											<nav>
												<div class="nav nav-tabs" id="nav-tab" role="tablist">
													<a class="nav-item nav-link active" id="nav-home-tab"
													   data-toggle="tab" href="#recent_activity" role="tab"
													   aria-selected="true">Recent Activity</a>
													<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab"
													   href="#project_worked" role="tab" aria-selected="false">Projects
														Worked on</a>
													<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab"
													   href="#profile_section" role="tab"
													   aria-selected="false">Profile</a>
												</div>
											</nav>
											<div class="tab-content" id="nav-tabContent">
												<div class="tab-pane fade show active" id="recent_activity"
													 role="tabpanel" aria-labelledby="nav-home-tab">
													<div class="msg_list_main">
														<ul class="msg_list">
															<li>
																<span><img src="images/layout_img/msg2.png"
																		   class="img-responsive" alt="#"></span>
																<span>
                                                               <span class="name_user">Taison Jack</span>
                                                               <span
																   class="msg_user">Sed ut perspiciatis unde omnis.</span>
                                                               <span class="time_ago">12 min ago</span>
                                                               </span>
															</li>
															<li>
																<span><img src="images/layout_img/msg3.png"
																		   class="img-responsive" alt="#"></span>
																<span>
                                                               <span class="name_user">Mike John</span>
                                                               <span
																   class="msg_user">On the other hand, we denounce.</span>
                                                               <span class="time_ago">12 min ago</span>
                                                               </span>
															</li>
														</ul>
													</div>
												</div>
												<div class="tab-pane fade" id="project_worked" role="tabpanel"
													 aria-labelledby="nav-profile-tab">
													<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem
														accusantium doloremque laudantium, totam rem aperiam, eaque ipsa
														quae ab illo inventore veritatis et
														quasi architecto beatae vitae dicta sunt explicabo. Nemo enim
														ipsam voluptatem quia voluptas sit aspernatur aut odit aut
														fugit, sed quia consequuntur magni dolores eos
														qui ratione voluptatem sequi nesciunt.
													</p>
												</div>
												<div class="tab-pane fade" id="profile_section" role="tabpanel"
													 aria-labelledby="nav-contact-tab">
													<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem
														accusantium doloremque laudantium, totam rem aperiam, eaque ipsa
														quae ab illo inventore veritatis et
														quasi architecto beatae vitae dicta sunt explicabo. Nemo enim
														ipsam voluptatem quia voluptas sit aspernatur aut odit aut
														fugit, sed quia consequuntur magni dolores eos
														qui ratione voluptatem sequi nesciunt.
													</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- end user profile section -->
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-2"></div>
			</div>
			<!-- end row -->
		</div>
		<!-- footer -->
		<div class="container-fluid">
			<div class="footer">
				<p>© Copyright 2021 - TV Sekolah. All rights reserved.</p>
			</div>
		</div>
	</div>
	<!-- end dashboard inner -->
</div>

<script>
	function salinteks() {
		var copyText = "<?php echo $koderef;?>";
		navigator.clipboard.writeText(copyText);
		window.open("<?php echo base_url().'login/profile/koderef';?>","_self");
	}
</script>
