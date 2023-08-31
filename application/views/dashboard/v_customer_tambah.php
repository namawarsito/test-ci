<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Customer
      <small>Tambah Customer</small>
    </h1>
  </section>

  <section class="content">

    <div class="row">
      <div class="col-lg-12">
        
        <a href="<?php echo base_url().'dashboard/customer'; ?>" class="btn btn-sm btn-primary">Kembali</a>

        <br/>
        <br/>

        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Customer</h3>
          </div>
          <div class="box-body">
            
             <form action="<?php echo base_url('dashboard/customer_aksi') ?>" method="post">
              <div class="form-group">
                <label>Nama</label>
                <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama customer..">
                <?php echo form_error('nama'); ?>
              </div>

              <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" name="email" placeholder="Masukkan email customer..">
                <?php echo form_error('email'); ?>
              </div>

              <div class="form-group">
                <label>HP</label>
                <input type="number" class="form-control" name="hp" placeholder="Masukkan no.hp customer..">
                <?php echo form_error('hp'); ?>
              </div>

              <div class="form-group">
                <label>Alamat</label>
                <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat customer..">
                <?php echo form_error('alamat'); ?>
              </div>
			  
				<div class="form-group">
					<label>Status Member</label>
					<select class="form-control" name="memberstatus">
						<option value="Tidak Aktif">Tidak Aktif</option>
						<option value="Aktif">Aktif</option>
					</select>
					<?php echo form_error('memberstatus'); ?>
				</div>

               <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" placeholder="Masukkan password customer..">
                <?php echo form_error('password'); ?>
              </div>

              <div class="form-group">
                <input type="submit" class="btn btn-sm btn-primary" value="Simpan">
              </div>
            </form>

          </div>
        </div>

      </div>
    </div>

  </section>

</div>