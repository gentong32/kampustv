<!-- dashboard inner -->
<div class="midde_cont">
	<div class="container-fluid">
		<div class="row column_title">
			<div class="col-md-12">
				<div class="page_title">
					<h2>Profil Saya</h2>
				</div>
			</div>
		</div>
		<!-- row -->
		<div class="row column2 graph margin_bottom_30">
			<div class="col-md-l2 col-lg-12">
			
				<div class="white_shd full margin_bottom_30">
					<div class="full graph_head">
						<div class="heading1 margin_0">
							<h2>Informasi</h2>
						</div>
					</div>
					<div class="full price_table padding_infor_info">
						<div class="row">
							<!-- user profile section -->
							<!-- profile image -->
							<div class="col-lg-12" style="font-size: 18px;">
							
								Status Anda sekarang adalah Calon Verifikator. Admin akan segera memverifikasinya!<br>
								Apabila lebih dari 3 hari belum terverifikasi, silakan hubungi Admin pada nomor berikut:<br>
								<div style="font-weight:bold;margin-left:15px;">
									<i class="fa fa-user"></i> Sigit Wiryawan<br>
									<i class="fa fa-phone"></i> 0815-4236-9117<br>
								</div>

							</div>
						</div>
					</div>
				</div>
				
				<div class="white_shd full margin_bottom_30">
					<div class="full graph_head">
						<div class="heading1 margin_0">
							<h2>Data Pribadi</h2>
						</div>
					</div>
					<div class="full price_table padding_infor_info">
						<div class="row">
							<!-- user profile section -->
							<!-- profile image -->
							<div class="col-lg-12">
								<div class="full dis_flex center_text">
									<div class="profile_img"><img width="180" class="rounded-circle"
																  src="<?php echo $profilku->fotouser;?>" alt="#"/></div>
									<div class="profile_contant">
										<div class="contact_inner">
											<h3><?php echo $profilku->username;?></h3>
											<?php if ($this->session->userdata('sebagai')==1) { ?>
											<p><strong><i><?php echo $profilku->full_name;?></i></strong></p>
											<?php } ?>
											<ul class="list-unstyled">
												<li><i class="fa fa-home"></i> : <?php
													echo $profilku->alamat;?> </li>
												<li><i class="fa fa-envelope-o"></i> : <?php
													echo $this->session->userdata('email');?> </li>
												<li><i class="fa fa-phone"></i> : <?php
													echo $profilku->hp;?></li>
												<li><i class="fa fa-birthday-cake"></i> : <?php
													echo namabulan_panjang($profilku->tgl_lahir);?></li>
												<li><i class="fa fa-intersex"></i> : <?php
													if($profilku->gender==1)
														echo "Laki-laki";
													else if($profilku->gender==2)
														echo "Perempuan";
													else echo "-";?></li>
												<li>
													<hr>
												</li>
												<?php if ($this->session->userdata('sebagai')==2) { ?>
												<li>
													<?php echo $profilku->namakelas;?>
												</li>
												<li>
													<hr>
												</li>
												<?php } else if ($this->session->userdata('sebagai')==1 && 
												$profilku->namamapel!="") { ?>
												<li>
													<?php echo $profilku->namamapel;?>
												</li>
												<li>
													<hr>
												</li>
												<?php } ?>
												<li>
													<button onclick="window.open('<?php echo base_url()."login/profile";?>','_self')" class="btn-primary" style="padding: 5px;">Edit Profil</button>
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
																<span><img src="<?php echo base_url().'images/layout_img/msg2.png';?>"
																		   class="img-responsive" alt="#"></span>
																<span>
                                                               <span class="name_user">Taison Jack</span>
                                                               <span
																   class="msg_user">Sed ut perspiciatis unde omnis.</span>
                                                               <span class="time_ago">12 min ago</span>
                                                               </span>
															</li>
															<li>
																<span><img src="<?php echo base_url().'images/layout_img/msg3.png';?>"
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
	function jadiver()
	{
		$.ajax({
			url: "<?php echo base_url();?>profil/upgradever",
			method: "GET",
			data: {},
			success: function (result) {
				if (result == "ada")
					alert("VERIFIKATOR SUDAH ADA");
				else {
					window.location.reload();
				}

			}
		});
	}
</script>