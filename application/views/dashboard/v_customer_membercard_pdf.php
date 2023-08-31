<!DOCTYPE html>
<html>
<head>
	<title>Kartu Member Customer</title>
</head>
<body>

	<style type="text/css">
	body{
		font-family: sans-serif;
		font-size: 10pt;
	}

	.table{
		width: 100%;
	}

	th,td{
	}
	.table,
	.table th,
	.table td {
		padding: 5px;
		border: 1px solid black;
		border-collapse: collapse;
	}
	.text-center { text-align: center; }
	.wrap-membercard {
		position: relative;
		width: 600px;
		height: 426px;
		display: block;
		background-image: url("<?=base_url()?>gambar/sistem/membercard_bg.png");
 		background-color: #fff;
		background-size: cover;
	}
	.card-value { 
		position: absolute;
		color: #000;
		left: 90px;
		width: 220px;
		text-align: center;
	}
	.card-nama {
		font-size: 28px;
		line-heigh: 32px;
		top: 170px;
		overflow: hidden;
		white-space: nowrap;
	}
	.card-alamat {
		font-size: 22px;
		line-heigh: 26px;
		top: 235px;
		overflow: hidden;
		white-space: nowrap;
	}
	.card-expdate {
		font-size: 22px;
		line-heigh: 26px;
		top: 306px;
		left: 350px;
		overflow: hidden;
		white-space: nowrap;
		color: #568191;
	}
</style>

<center>
	<h2>Kartu Member Customer</h2>
	<br>
</center>

<?php 
	foreach($data as $c){
		if( $c->customer_memberstatus == 'Aktif' ){
			$customer_nama = substr($c->customer_nama, 0, 16);
			$customer_alamat = substr($c->customer_alamat, 0, 22);
			$customer_expdate = date("d-m-y", strtotime($c->customer_expdate));
		?>
			<br/>
			<div class="wrap-membercard">
				<p class="card-value card-nama"><?=$customer_nama;?></p>
				<p class="card-value card-alamat"><?= nl2br($customer_alamat); ?></p>
				<p class="card-value card-expdate"><?=$customer_expdate; ?></p>
			</div>


		<?php }else{ ?>
			<div class="alert alert-info text-center">
				Maaf, Kartu Member Customer tidak tersedia atau status Member Tidak Aktif
			</div>
		<?php
		} 
	}
?>
</body>

</html>
