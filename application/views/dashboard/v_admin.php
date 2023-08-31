<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Admin
			<small>Admin</small>
		</h1>
	</section>

	<section class="content">

		<div class="row">
			<div class="col-lg-12">
				
				<a href="<?php echo base_url().'dashboard/admin_tambah'; ?>" class="btn btn-sm btn-primary">Buat Admin baru</a>

				<br/>
				<br/>

				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">Admin</h3>
					</div>
					<div class="box-body">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="1%">NO</th>
									<th>Nama</th>
									<th>Username</th>
									<th>Foto</th>
									<th width="10%">OPSI</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$no = 1;
								foreach($admin as $p){ 
									?>
									<tr>
										<td><?php echo $no++; ?></td>
										<td><?php echo $p->admin_nama; ?></td>
										<td><?php echo $p->admin_username; ?></td>
										<td>
											<center>
												<?php if($p->admin_foto == ""){ ?>
													<img src="<?php echo base_url(); ?>/gambar/sistem/user.png" style="width: 40px;height: auto">
												<?php }else{ ?>
													<img src="<?php echo base_url(); ?>/gambar/user/<?php echo $p->admin_foto; ?>" style="width: 40px;height: auto">
												<?php } ?>
											</center>
										</td>
										<td>
											<a href="<?php echo base_url().'dashboard/admin_edit/'.$p->admin_id; ?>" class="btn btn-warning btn-sm"> <i class="fa fa-pencil"></i> </a>
											<?php if($p->admin_id != 1){ ?>
												<a onclick="return confirm('Yakin ?')" href="<?php echo base_url().'dashboard/admin_hapus/'.$p->admin_id; ?>" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </a>
											<?php } ?>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						

					</div>
				</div>

			</div>
		</div>

	</section>

</div>