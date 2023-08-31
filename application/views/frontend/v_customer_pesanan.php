<!-- BREADCRUMB -->
<div id="breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="<?php echo base_url() ?>">Home</a></li>
			<li class="active">Pesanan Customer</li>
		</ul>
	</div>
</div>
<!-- /BREADCRUMB -->

<div class="section">
	<div class="container">
		<div class="row">
			
			<?php 
			$this->load->view('frontend/v_customer_sidebar');
			?>

			<div id="main" class="col-md-9">
				
				<h4>PESANAN</h4>

				<div id="store">
					<div class="row">

						<div class="col-lg-12">

							<?php 
							if(isset($_GET['alert'])){
								if($_GET['alert'] == "gagal"){
									echo "<div class='alert alert-danger'>Bukti pembayaran gagal diupload!</div>";
								}elseif($_GET['alert'] == "sukses"){
									echo "<div class='alert alert-success'>Pesanan berhasil dibuat, silahkan melakukan pembayaran!</div>";
								}elseif($_GET['alert'] == "upload"){
									echo "<div class='alert alert-success'>Konfirmasi pembayaran berhasil tersimpan, silahkan menunggu konfirmasi dari admin!</div>";
								}
							}
							?>

							<small class="text-muted">
								Semua data pesanan / invoice anda.
							</small>

							<br/>
							<br/>


							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>NO</th>
											<th>No.Invoice</th>
											<th>Tanggal</th>
											<th>Nama Penerima</th>
											<th>Total Bayar</th>
											<th class="text-center">Status</th>
											<th class="text-center">Rating</th>
											<th class="text-center">OPSI</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$no = 1;
										$id = $_SESSION['customer_id'];
										$invoice = $this->db->query("select * from invoice where invoice_customer='$id' order by invoice_id desc")->result();
										foreach($invoice as $i){

											?>
											<tr>
												<td><?php echo $no++ ?></td>
												<td>INVOICE-00<?php echo $i->invoice_id ?></td>
												<td><?php echo $i->invoice_tanggal ?></td>
												<td><?php echo $i->invoice_nama ?></td>
												<td><?php echo "Rp. ".number_format($i->invoice_total_bayar)." ,-" ?></td>
												<td class="text-center">
													<?php 
													if($i->invoice_status == 0){
														echo "<span class='label label-warning'>Menunggu Pembayaran</span>";
													}elseif($i->invoice_status == 1){
														echo "<span class='label label-default'>Menunggu Konfirmasi</span>";
													}elseif($i->invoice_status == 2){
														echo "<span class='label label-danger'>Ditolak</span>";
													}elseif($i->invoice_status == 3){
														echo "<span class='label label-primary'>Dikonfirmasi & Sedang Diproses</span>";
													}elseif($i->invoice_status == 4){
														echo "<span class='label label-warning'>Dikirim</span>";
													}elseif($i->invoice_status == 5){
														echo "<span class='label label-success'>Selesai</span>";
													}
													?>
												</td>
												<?php if($i->invoice_status == 5){ ?>
													<td class="text-center">
													<?php if($i->invoice_rating == 0){ ?>
														<form action="<?php echo base_url('welcome/reting_invoice') ?>" method="post">
															<input type="text" name="invoice_id" value="<?php echo $i->invoice_id; ?>" hidden>
															<table class="table" style="width: 100%">
																<tr>
																	<th><input type="radio" name="reting" value="1"></th> <th>1</th>
																	<th><input type="radio" name="reting" value="2"></th> <th>2</th>
																	<th><input type="radio" name="reting" value="3"></th> <th>3</th>
																	<th><input type="radio" name="reting" value="4"></th> <th>4</th>
																	<th><input type="radio" name="reting" value="5"></th> <th>5</th>
																</tr>
															</table>
															<input type="submit" class="btn btn-info btn-sm" value="Simpan">
														</form>
													<?php }else{ ?>
														<?php for ($item = 1; $item <= $i->invoice_rating; $item++) { ?>
															<li class="fa fa-star text-primary"></li>
														<?php } ?>
													<?php } ?>
													</td>
												<?php } ?>
												<td class="text-center">
													<?php 
													if($i->invoice_status == 0){
														?>
														<a class='btn btn-sm btn-primary' href="<?php echo base_url() ?>welcome/customer_pembayaran?id=<?php echo $i->invoice_id; ?>"><i class="fa fa-money"></i> Konfirmasi Pembayaran</a>
														<?php
													}elseif($i->invoice_status == 1){
														?>
														<a class='btn btn-sm btn-primary' href="<?php echo base_url() ?>welcome/customer_pembayaran?id=<?php echo $i->invoice_id; ?>"><i class="fa fa-money"></i> Konfirmasi Pembayaran</a>
														<?php
													}
													?>
													<a class='btn btn-sm btn-success' href="<?php echo base_url() ?>welcome/customer_invoice?id=<?php echo $i->invoice_id; ?>"><i class="fa fa-print"></i> Invoice</a>
												</td>
											</tr>
											<?php 
										}
										?>
									</tbody>
								</table>
							</div>
							


						</div>	

					</div>
				</div>

			</div>
		</div>
	</div>
</div>
