<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Kategori
			<small>Kategori Artikel</small>
		</h1>
	</section>

	<section class="content">
	<div class="row">

			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-aqua">
					<div class="inner">
						<h3><?php echo $jumlah_produk ?></h3>

						<p>Jumlah Produk</p>
					</div>
					<div class="icon">
						<i class="ion ion-android-list"></i>
					</div>
				</div>
			</div>
			
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-green">
					<div class="inner">
						<h3><?php echo $jumlah_invoice ?></h3>

						<p>Jumlah Invoice / Pesanan</p>
					</div>
					<div class="icon">
						<i class="ion ion-android-document"></i>
					</div>
				</div>
			</div>
			
			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-red">
					<div class="inner">
						<h3><?php echo $jumlah_kategori ?></h3>

						<p>Jumlah Kategori</p>
					</div>
					<div class="icon">
						<i class="ion ion-pie-graph"></i>
					</div>
				</div>
			</div>

			<div class="col-lg-3 col-xs-6">
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3><?php echo $jumlah_admin ?></h3>

						<p>Jumlah Admin</p>
					</div>
					<div class="icon">
						<i class="ion ion-person-add"></i>
					</div>
				</div>
			</div>
			
		</div>

		<div class="row">
			<div class="col-lg-6">
				
				<div class="box box-primary">
					<div class="box-body">
						<h3>Selamat Datang !</h3>

						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<tr>
									<th width="%">Nama</th>
									<th width="1px">:</th>
									<td>
										<?php 
										$id_user = $this->session->userdata('id');
										$user = $this->db->query("select * from admin where admin_id='$id_user'")->row();
										?>
										<p><?php echo $user->admin_nama; ?></p>
									</td>
								</tr>
								<tr>
									<th width="20%">Username</th>
									<th width="1px">:</th>
									<td><?php echo $this->session->userdata('username') ?></td>
								</tr>
							</table>
						</div>
					</div>
				</div>

			</div>
			<div class="col-lg-6">
				<div class="box box-primary">
					<div class="box-body">
						<h3 style="margin-bottom: 25px;">Graph Penjualan Tahun <?=date("Y");?></h3>
						<div class="table-responsive">
							<div style="margin: auto;">
								<canvas id="myChart" height="190" width="600"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<div class="box box-primary">
					<div class="box-body">
						<h3 style="margin-bottom: 25px;">Graph 10 Besar Pembelian Custamer Tahun <?=date("Y");?></h3>
						<div class="table-responsive">
							<div style="margin: auto;">
								<canvas id="purchaseChart" height="190" width="600"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="box box-primary">
					<div class="box-body">
						<h3 style="margin-bottom: 25px;">Graph Reting Kepusan Pelanggan Tahun <?=date("Y");?></h3>
						<div class="table-responsive">
							<div style="width: 90%; margin: auto;">
								<canvas id="ratingChart" height="190" width="600"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
		<script>
			var ctx = document.getElementById('myChart').getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"],
					datasets: [{
						label: 'Sample Data',
						data: <?= json_encode($data); ?>,
						backgroundColor: 'rgba(75, 192, 192, 0.2)',
						borderColor: 'rgba(75, 192, 192, 1)',
						borderWidth: 1
					}]
				},
				options: {
					scales: {
						y: {
							beginAtZero: true
						}
					}
				}
			});

			var purchaseData = <?= json_encode($purchaseData) ?>;
			var customerNames = purchaseData.map(data => data.customer_nama);
			var purchaseAmounts = purchaseData.map(data => data.total_purchase);

			var ctx = document.getElementById('purchaseChart').getContext('2d');
			var purchaseChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: customerNames,
					datasets: [{
						label: 'Total Purchase',
						data: purchaseAmounts,
						backgroundColor: 'rgba(75, 192, 192, 0.2)',
						borderColor: 'rgba(75, 192, 192, 1)',
						borderWidth: 1
					}]
				},
				options: {
					scales: {
						y: {
							beginAtZero: true
						}
					}
				}
			});

			var ctx = document.getElementById('ratingChart').getContext('2d');
			var ratings = <?php echo json_encode($ratings); ?>;

			var labels = [];
			var data = [];

			for (var i = 0; i < ratings.length; i++) {
				labels.push(ratings[i].invoice_rating);
				data.push(ratings[i].count);
			}

			var ratingChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: labels,
					datasets: [{
						label: 'Rating Count',
						data: data,
						backgroundColor: 'rgba(75, 192, 192, 0.2)',
						borderColor: 'rgba(75, 192, 192, 1)',
						borderWidth: 1
					}]
				},
				options: {
					scales: {
						y: {
							beginAtZero: true
						}
					}
				}
			});
		</script>
	</section>
	
</div>
