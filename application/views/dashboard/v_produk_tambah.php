<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Produk
			<small>Tulis Produk Baru</small>
		</h1>
	</section>

	<section class="content">

		<a href="<?php echo base_url().'dashboard/produk'; ?>" class="btn btn-sm btn-primary">Kembali</a>

		<br/>
		<br/>

		<form method="post" action="<?php echo base_url('dashboard/produk_aksi') ?>" enctype="multipart/form-data">
			<div class="row">
				<div class="col-lg-9">

					<div class="box box-primary">
						<div class="box-body">


							<div class="box-body">
								<div class="form-group">
									<label>Nama Produk</label>
									<input type="text" name="nama" class="form-control" placeholder="Masukkan nama produk.." value="<?php echo set_value('nama'); ?>">
									<?php echo form_error('nama'); ?>
								</div>

								<div class="form-group">
									<label>Kategori</label>
									<select class="form-control" name="kategori">
										<option value="">- Pilih Kategori</option>
										<?php foreach($kategori as $k){ ?>
											<option <?php if(set_value('kategori') == $k->kategori_id){echo "selected='selected'";} ?> value="<?php echo $k->kategori_id ?>"><?php echo $k->kategori_nama; ?></option>
										<?php } ?>
									</select>
									<?php echo form_error('kategori'); ?>
								</div>

								<div class="form-group">
									<label>Harga</label>
									<input type="number" name="harga" class="form-control" placeholder="Masukkan harga produk.." value="<?php echo set_value('harga'); ?>">
									<?php echo form_error('harga'); ?>
								</div>

								<div class="form-group">
									<label>Diskon</label>
									<input type="number" name="diskonharga" class="form-control" placeholder="Masukkan diskon harga produk.." value="<?php echo set_value('diskon'); ?>">
									<?php echo form_error('diskonharga'); ?>
								</div>

								<div class="form-group">
									<label>Jumlah</label>
									<input type="number" name="jumlah" class="form-control" placeholder="Masukkan jumlah produk.." value="<?php echo set_value('jumlah'); ?>">
									<?php echo form_error('jumlah'); ?>
								</div>

								<div class="form-group">
									<label>Berat</label>
									<input type="number" name="berat" class="form-control" placeholder="Masukkan berat produk.." value="<?php echo set_value('berat'); ?>">
									<?php echo form_error('berat'); ?>
								</div>
							</div>

							<div class="box-body">
								<div class="form-group">
									<label>Keterangan</label>
									<?php echo form_error('keterangan'); ?>
									<br/>
									<textarea class="form-control" id="editor" name="keterangan"> <?php echo set_value('keterangan'); ?> </textarea>
								</div>
							</div>

						</div>
					</div>

				</div>

				<div class="col-lg-3">
					<div class="box box-primary">
						<div class="box-body">
							
							<div class="form-group">
								<label>Gambar 1</label>

								<input type="file" name="foto1">

								<br/>
								<?php 
								if(isset($gambar_error)){
									echo $gambar_error;
								}
								?>
								<?php echo form_error('foto1'); ?>
							</div>

							<div class="form-group">
								<label>Gambar 2</label>

								<input type="file" name="foto2">

								<br/>
								<?php 
								if(isset($gambar_error)){
									echo $gambar_error;
								}
								?>
								<?php echo form_error('foto2'); ?>
							</div>

							<div class="form-group">
								<label>Gambar 3</label>

								<input type="file" name="foto3">

								<br/>
								<?php 
								if(isset($gambar_error)){
									echo $gambar_error;
								}
								?>
								<?php echo form_error('foto3'); ?>
							</div>


							<input type="submit" name="status" value="Simpan" class="btn btn-success btn-block">

						</div>
					</div>

				</div>
			</div>
		</form>

	</section>

</div>