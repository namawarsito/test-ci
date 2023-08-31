<!-- BREADCRUMB -->
<div id="breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="<?php echo base_url() ?>">Home</a></li>
			<li class="active">Ganti Password Customer</li>
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
				
				<h4>GANTI PASSWORD</h4>

				<div id="store">
					<div class="row">

						<div class="col-lg-12">
							<?php 
							if(isset($_GET['alert'])){
								if($_GET['alert'] == "sukses"){
									echo "<div class='alert alert-success'>Password anda berhasil diganti!</div>";
								}
							}
							?>

							<form action="<?php echo base_url('welcome/customer_password_act') ?>" method="post">
								<div class="form-group">
									<label for="">Masukkan Password Baru</label>
									<input type="password" class="input" required="required" name="password" placeholder="Masukkan password .." min="5">
								</div>

								<div class="form-group">
									<input type="submit" class="primary-btn" value="Ganti Password">
								</div>
							</form>
						</div>

					</div>
				</div>

			</div>
		</div>
	</div>
</div>
