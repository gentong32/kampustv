<style>
	.sidenav {
		height: 80%;
		width: 0;
		position: fixed;
		z-index: 1;
		top: 70px;
		left: 0;
		background-color: #FFFFFF;
		border: 1px black solid;
		overflow-x: hidden;
		transition: 0.5s;
		padding-top: 60px;
	}

	.sidenav a {
		padding: 8px 8px 8px 32px;
		text-decoration: none;
		font-size: 20px;
		color: #818181;
		display: block;
		transition: 0.3s;
	}

	.sidenav a:hover {
		color: #f1f1f1;
	}

	.sidenav .closebtn {
		position: absolute;
		top: 0;
		right: 25px;
		font-size: 36px;
		margin-left: 50px;
	}

	@media screen and (max-height: 450px) {
		.sidenav {
			padding-top: 15px;
		}

		.sidenav a {
			font-size: 18px;
		}
	}
</style>


<?php
$logo = "Tvs_logo.png";
?>

<div class="navbar navbar-light" style="margin-bottom:10px;background-color: #ffffff;border-bottom: 1px solid black;">
	<div class="container" style="width: 100%;">
		<div class="navbar-header">
			<div style="float: left">
				<a href="" class="navbar-brand navbar-title">
					<img style="margin-top: -10px;" height="42"
						 src="<?php echo base_url(); ?>assets/images/<?php echo $logo; ?>"/>
				</a>
			</div>
		</div>
	</div>
</div>
