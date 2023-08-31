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
						<h3 class="box-title">Customer - Kartu Member</h3>
					</div>
					<div class="box-body">
						<?php foreach($customer as $c){ ?>
							<?php
								// Load the stamp and the photo to apply the watermark to
								$img_bg_membercard = base_url()."gambar/sistem/membercard_bg.png";
								$customer_nama = $c->customer_nama;
								$customer_alamat = $c->customer_alamat;
				

								$im = imagecreatefrompng($img_bg_membercard);

								// First we create our stamp image manually from GD
								// Create the size of image or blank image
								//$stamp = imagecreate(500, 300);
								//imagefill($stamp,0,0,0x7fff0000);
								
								$stamp = imagecreatetruecolor(500, 300);
								$imageX = imagesx($stamp);
								$imageY = imagesy($stamp);

								// Transparent Background
								imagealphablending($stamp, false);
								$transparency = imagecolorallocatealpha($stamp, 0, 0, 0, 127);
								imagefill($stamp, 0, 0, $transparency);
								imagesavealpha($stamp, true);
								
								
								// Set the text color of image
								$bg_color = imagecolorallocate($stamp, 0, 0, 0);
								//imagefilledrectangle($stamp, 0, 0, 500, 300, $bg_color);
								
								$text_color = imagecolorallocate($stamp, 0, 0, 0);
								//imagefilledrectangle($stamp, 0, 0, 99, 69, 0x0000FF);
								//imagefilledrectangle($stamp, 9, 9, 90, 60, 0xFFFFFF);
								//imagestring($stamp, 5, 100, 100, $customer_nama, $text_color);
								//imagestring($stamp, 3, 20, 40, $customer_alamat, $text_color);
								//$font = base_url('system/fonts/arial.ttf');
								putenv('GDFONTPATH=' . realpath('.'));
								$font = "arial";
								$fontSize = 12;
								$text = "THIS IS A TEST";
								
								$textDim = imagettfbbox($fontSize, 0, $font, $text);
								$textX = $textDim[2] - $textDim[0];
								$textY = $textDim[7] - $textDim[1];

								$text_posX = ($imageX / 2) - ($textX / 2);
								$text_posY = ($imageY / 2) - ($textY / 2);

								imagettftext($stamp, $fontSize, 0, $text_posX, $text_posY, $bg_color, $font, $text);
								

								// Set the margins for the stamp and get the height/width of the stamp image
								$marge_right = 400;
								$marge_bottom = 500;
								$sx = imagesx($stamp);
								$sy = imagesy($stamp);

								// Merge the stamp onto our photo with an opacity of 50%
								//imagecopymerge($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 50);
								//imagecopymerge($im, $stamp, 400, 500, 0, 0, 500, 200, 75);

								//imagealphablending($im, true);
								//imagesavealpha($im, true);
								imagecopy($im, $stamp, 0, 0, 0, 0, 100, 100);
								//imagepng($im, 'image_3.png');

								// Save the image to file and free memory
								ob_start();
								//imagepng($im, 'photo_stamp.png');
								imagepng($im);

								$imagedata = ob_get_clean();

								print '<p><img src="data:image/png;base64,'.base64_encode($imagedata).'" alt="image 1" width="100%" height="auto"/></p>';

								imagedestroy($im);
							
							?>
						

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