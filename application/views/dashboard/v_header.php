<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>DASHBOARD - TOKO B-One Computer</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/morris.js/morris.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/jvectormap/jquery-jvectormap.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<style>
		.price-before.invprice {
			font-size: 13px;
			display: block;
			text-decoration: line-through;
			color: #e70000;
			margin-top: 0px;
		}
	</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">

		<?php 
		$id_user = $this->session->userdata('id');
		$user = $this->db->query("select * from admin where admin_id='$id_user'")->row();
		?>

		<header class="main-header">			
			<a href="<?php echo base_url(); ?>" class="logo">
				<span class="logo-mini"><b>CS</b></span>
				<span class="logo-lg"><b>B-ONE</b>COMPUTER</span>
			</a>
			
			<nav class="navbar navbar-static-top">
				
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<span class="hidden-xs">Halo, <?php echo $user->admin_nama ?> | <b>[ ADMIN ]</b></span> <i class="caret"></i>
							</a>
							<ul class="dropdown-menu">
								<li class="user-header">
									<?php if($user->admin_foto == ""){ ?>
										<img src="<?php echo base_url(); ?>/gambar/sistem/user.png" class="img-circle">
									<?php }else{ ?>
										<img src="<?php echo base_url(); ?>/gambar/user/<?php echo $user->admin_foto; ?>" class="img-circle">
									<?php } ?>
									<p>
										<?php echo $user->admin_nama ?>
										<small>Hak akses : ADMIN</small>
									</p>
								</li>
								
								<li class="user-footer">
									<div class="pull-right">
										<a href="<?php echo base_url().'dashboard/keluar' ?>" class="btn btn-default btn-flat">Keluar</a>
									</div>
								</li>
							</ul>
						</li>
						
					</ul>
				</div>
			</nav>
		</header>
		<aside class="main-sidebar">
			<section class="sidebar">
				<div class="user-panel">
					<div class="pull-left image">
						<?php if($user->admin_foto == ""){ ?>
							<img src="<?php echo base_url(); ?>/gambar/sistem/user.png" class="img-circle">
						<?php }else{ ?>
							<img src="<?php echo base_url(); ?>/gambar/user/<?php echo $user->admin_foto; ?>" class="img-circle">
						<?php } ?>
					</div>
					<div class="pull-left info">
						<p><?php echo $user->admin_nama; ?></p>
						<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
					</div>
				</div>
				
				<ul class="sidebar-menu" data-widget="tree">
					<li class="header">MAIN NAVIGATION</li>
					<li>
						<a href="<?php echo base_url().'dashboard' ?>">
							<i class="fa fa-dashboard"></i>
							<span>DASHBOARD</span>
						</a>
					</li>
					<li>
						<a href="<?php echo base_url().'dashboard/kategori' ?>">
							<i class="fa fa-folder"></i>
							<span>DATA KATEGORI</span>
						</a>
					</li>

					<li>
						<a href="<?php echo base_url().'dashboard/produk' ?>">
							<i class="fa fa-gift"></i>
							<span>DATA PRODUK</span>
						</a>
					</li>

					<li>
						<a href="<?php echo base_url().'dashboard/customer' ?>">
							<i class="fa fa-users"></i>
							<span>DATA CUSTOMER</span>
						</a>
					</li>

					<li>
						<a href="<?php echo base_url().'dashboard/transaksi' ?>">
							<i class="fa fa-retweet"></i>
							<span>TRANSAKSI / PESANAN</span>
						</a>
					</li>

					<li>
						<a href="<?php echo base_url().'dashboard/laporan' ?>">
							<i class="fa fa-file"></i>
							<span>LAPORAN PENJUALAN</span>
						</a>
					</li>

					<li>
						<a href="<?php echo base_url().'dashboard/admin' ?>">
							<i class="fa fa-user"></i>
							<span>DATA ADMIN</span>
						</a>
					</li>

					<li>
						<a href="<?php echo base_url().'dashboard/chat' ?>">
							<i class="fa fa-user"></i>
							<span>CHAT</span>
						</a>
					</li>

					<li>
						<a href="<?php echo base_url().'dashboard/ganti_password' ?>">
							<i class="fa fa-lock"></i>
							<span>GANTI PASSWORD</span>
						</a>
					</li>
					<li>
						<a href="<?php echo base_url().'dashboard/keluar' ?>">
							<i class="fa fa-share"></i>
							<span>KELUAR</span>
						</a>
					</li>
				</ul>
			</section>
		</aside>
