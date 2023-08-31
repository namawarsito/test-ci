<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Customer
			<small>Edit Customer</small>
		</h1>
	</section>

	<section class="content">

		<div class="row">
			<div class="col-lg-6">
				<a href="<?php echo base_url().'dashboard/customer'; ?>" class="btn btn-sm btn-primary">Kembali</a>
				
				<br/>
				<br/>

				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">customer</h3>
					</div>
					<div class="box-body">
						
						<?php foreach($customer as $c){ ?>

							<form method="post" action="<?php echo base_url('dashboard/customer_update') ?>">
								<div class="form-group">
									<label>Nama</label>
									<input type="hidden" name="id" value="<?php echo $c->customer_id; ?>">
									<input type="text" class="form-control" name="nama" placeholder="Masukkan Nama customer.." value="<?php echo $c->customer_nama; ?>">
									<?php echo form_error('nama'); ?>
								</div>

								<div class="form-group">
									<label>Email</label>
									<input type="text" class="form-control" name="email" placeholder="Masukkan email customer.." value="<?php echo $c->customer_email; ?>">
									<?php echo form_error('email'); ?>
								</div>

								<div class="form-group">
									<label>HP</label>
									<input type="number" class="form-control" name="hp" placeholder="Masukkan no.hp customer.." value="<?php echo $c->customer_hp; ?>">
									<?php echo form_error('hp'); ?>
								</div>

								<div class="form-group">
									<label>Alamat</label>
									<input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat customer.." value="<?php echo $c->customer_alamat; ?>">
									<?php echo form_error('alamat'); ?>
								</div>
								
								<div class="form-group">
									<label>Status Member</label>
									<select class="form-control" name="memberstatus">
										<option <?php if($c->customer_memberstatus == "Tidak Aktif"){echo "selected='selected'";} ?> value="Tidak Aktif">Tidak Aktif</option>
										<option <?php if($c->customer_memberstatus == "Aktif"){echo "selected='selected'";} ?> value="Aktif">Aktif</option>
									</select>
									<?php echo form_error('memberstatus'); ?>
								</div>

								<div class="form-group">
									<label>Password</label>
									<input type="password" class="form-control" name="password" placeholder="Masukkan password customer..">
									<?php echo form_error('password'); ?>
									<small>Kosongkan jika tidak ingin mengubah password</small>
								</div>

								<div class="form-group">
									<input type="submit" class="btn btn-sm btn-primary" value="Simpan">
								</div>
							</form>

						<?php } ?>

					</div>
				</div>

			</div>
		</div>

	</section>

</div>