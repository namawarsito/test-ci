<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Admin
			<small>Edit Admin</small>
		</h1>
	</section>

	<section class="content">

		<div class="row">
			<div class="col-lg-6">
				<a href="<?php echo base_url().'dashboard/admin'; ?>" class="btn btn-sm btn-primary">Kembali</a>
				
				<br/>
				<br/>

				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">Admin</h3>
					</div>
					<div class="box-body">
						
						<?php foreach($admin as $p){ ?>

							<form method="post" action="<?php echo base_url('dashboard/admin_update') ?>" enctype="multipart/form-data">
								<div class="box-body">
									<div class="form-group">
										<label>Nama</label>
										<input type="hidden" name="id" value="<?php echo $p->admin_id; ?>">
										<input type="text" name="nama" class="form-control" placeholder="Masukkan nama admin .." value="<?php echo $p->admin_nama; ?>">
										<?php echo form_error('nama'); ?>
									</div>
									<div class="form-group">
										<label>Username</label>
										<input type="text" name="username" class="form-control" placeholder="Masukkan username admin.." value="<?php echo $p->admin_username; ?>">
										<?php echo form_error('username'); ?>
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" name="password" class="form-control" placeholder="Masukkan password admin..">
										<?php echo form_error('password'); ?>
										<small>Kosongkan jika tidak ingin mengubah password</small>
									</div>

									<div class="form-group">
										<label>Foto</label>
										<input type="file" name="foto">
										<br/>
										<?php 
										if(isset($gambar_error)){
											echo $gambar_error;
										}
										?>
										<?php echo form_error('foto'); ?>
									</div>
								</div>

								<div class="box-footer">
									<input type="submit" class="btn btn-success" value="Simpan">
								</div>
							</form>

						<?php } ?>

					</div>
				</div>

			</div>
		</div>

	</section>

</div>