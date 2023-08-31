<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Produk
			<small>Manajemen Produk</small>
		</h1>
	</section>

	<section class="content">

		<div class="row">
			<div class="col-lg-12">
				
				<a href="<?php echo base_url().'dashboard/produk_tambah'; ?>" class="btn btn-sm btn-primary">Buat produk baru</a>

				<br/>
				<br/>

				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">produk</h3>
					</div>
					<div class="box-body">

						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table-datatable">
								<thead>
									<tr>
										<th width="1%">NO</th>
										<th>NAMA PRODUK</th>
										<th>KATEGORI</th>
										<th>HARGA</th>
										<th>DISKON</th>
										<th>JUMLAH</th>
										<th width="20%">FOTO</th>
										<th width="10%">OPSI</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$no=1;
									foreach($produk as $p){
										?>
										<tr>
											<td><?php echo $no++; ?></td>
											<td><?php echo $p->produk_nama; ?></td>
											<td><?php echo $p->kategori_nama; ?></td>
											<td><?php echo "Rp. ".number_format($p->produk_harga).",-"; ?></td>
											<td><?php echo "Rp. ".number_format($p->produk_diskonharga).",-"; ?></td>
											<td><?php echo number_format($p->produk_jumlah); ?></td>
											<td>
												<div class="row">
													<div class="col-md-3 no-padding">
														<center>
															<?php if($p->produk_foto1 == ""){ ?>
																<img src="<?php echo base_url(); ?>/gambar/sistem/produk.png" style="width: 100%;height: auto">
															<?php }else{ ?>
																<img src="<?php echo base_url(); ?>/gambar/produk/<?php echo $p->produk_foto1; ?>" style="width: 100%;height: auto">
															<?php } ?>
														</center>
													</div>
													<div class="col-md-3 no-padding">
														<center>
															<?php if($p->produk_foto2 == ""){ ?>
																<img src="<?php echo base_url(); ?>/gambar/sistem/produk.png" style="width: 100%;height: auto">
															<?php }else{ ?>
																<img src="<?php echo base_url(); ?>/gambar/produk/<?php echo $p->produk_foto2; ?>" style="width: 100%;height: auto">
															<?php } ?>
														</center>
													</div>
													<div class="col-md-3 no-padding">
														<center>
															<?php if($p->produk_foto3 == ""){ ?>
																<img src="<?php echo base_url(); ?>/gambar/sistem/produk.png" style="width: 100%;height: auto">
															<?php }else{ ?>
																<img src="<?php echo base_url(); ?>/gambar/produk/<?php echo $p->produk_foto3; ?>" style="width: 100%;height: auto">
															<?php } ?>
														</center>
													</div>
												</div>
												
											</td>
											<td>                        
												<a href="<?php echo base_url().'dashboard/produk_edit/'.$p->produk_id; ?>" class="btn btn-warning btn-sm"> <i class="fa fa-pencil"></i> </a>
												<a href="<?php echo base_url().'dashboard/produk_hapus/'.$p->produk_id; ?>" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </a>
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

	</section>

</div>