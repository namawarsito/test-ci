<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		// session_start();
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');

		$this->load->model('m_data');


		$file = $this->uri->segment(2);

		if(!isset($_SESSION['customer_status'])){
 			// halaman yg dilindungi jika customer belum login
			$lindungi = array('customer','customer_logout');
 			// periksa halaman, jika belum login ke halaman di atas, maka alihkan halaman
			if(in_array($file, $lindungi)){
				redirect(base_url());
			}
			if($file == "checkout"){
				redirect(base_url()."welcome/masuk?alert=login-dulu");
			}

		}else{
 			// halaman yg tidak boleh diakses jika customer sudah login
			$lindungi = array('masuk','daftar');
 			// periksa halaman, jika sudah dan mengakses halaman di atas, maka alihkan halaman
			if(in_array($file, $lindungi)){
				redirect(base_url()."welcome/customer");
			}
		}

		if($file == "checkout"){
			if(!isset($_SESSION['keranjang']) || count($_SESSION['keranjang']) == 0){
				redirect(base_url()."welcome/keranjang?alert=keranjang_kosong");
			}
		}

	}

	public function index()
	{	
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_index');
		$this->load->view('frontend/v_footer');
	}

	public function produk_detail($id)
	{	
		counter_view_product($id);
		$data['data'] = $this->db->query("select * from produk,kategori where kategori_id=produk_kategori and produk_id='$id'")->result();

		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_detail', $data);
		$this->load->view('frontend/v_footer');
	}

	public function produk_kategori($id)
	{
		$data['data'] = $this->db->query("select * from produk,kategori where kategori_id=produk_kategori and produk_id='$id'")->result();
		$data['k'] = $this->db->query("select * from kategori where kategori_id='$id'")->row();
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_kategori', $data);
		$this->load->view('frontend/v_footer');
	}


	public function keranjang()
	{
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_keranjang');
		$this->load->view('frontend/v_footer');
	}


	public function keranjang_hapus()
	{

		$id_produk = $_GET['id'];
		$redirect = $_GET['redirect'];

		if(isset($_SESSION['keranjang'])){

			for($a=0;$a<count($_SESSION['keranjang']);$a++){
				if($_SESSION['keranjang'][$a]['produk'] == $id_produk){
					unset($_SESSION['keranjang'][$a]);
					sort($_SESSION['keranjang']);
				}
			}
		}

		if($redirect == "index"){
			$r = "";
		}elseif($redirect == "detail"){
			$r = "welcome/produk_detail/".$id_produk;
		}elseif($redirect == "keranjang"){
			$r = "welcome/keranjang";
		}

		redirect(base_url().$r);

	}


	public function keranjang_masukkan()
	{

		$id_produk = $_GET['id'];
		$redirect = $_GET['redirect'];

		$d = $this->db->query("select * from produk,kategori where kategori_id=produk_kategori and produk_id='$id_produk'")->row();
		
		if(isset($_SESSION['keranjang'])){
			$jumlah_isi_keranjang = count($_SESSION['keranjang']);
			$sudah_ada = 0;
			for($a = 0;$a < $jumlah_isi_keranjang; $a++){
				// cek apakah produk sudah ada dalam keranjang
				if($_SESSION['keranjang'][$a]['produk'] == $id_produk){
					$sudah_ada = 1;
				}
			}
			if($sudah_ada == 0){
				$_SESSION['keranjang'][$jumlah_isi_keranjang] = array(
					'produk' => $id_produk,
					'jumlah' => 1
				);
			}
		}else{
			$_SESSION['keranjang'][0] = array(
				'produk' => $id_produk,
				'jumlah' => 1
			);
		}

		if($redirect == "index"){
			$r = "";
		}elseif($redirect == "detail"){
			$r = "welcome/produk_detail/".$id_produk;
		}elseif($redirect == "keranjang"){
			$r = "welcome/keranjang";
		}

		redirect(base_url().$r);
	}



	public function keranjang_update()
	{

		$produk = $this->input->post('produk');
		$jumlah = $this->input->post('jumlah');

		$jumlah_isi_keranjang = count($_SESSION['keranjang']);

		for($a = 0;$a < $jumlah_isi_keranjang; $a++){

			$_SESSION['keranjang'][$a] = array(
				'produk' => $produk[$a],
				'jumlah' => $jumlah[$a]
			);

		}
		redirect(base_url().'welcome/keranjang');
	}



	public function daftar()
	{
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_daftar');
		$this->load->view('frontend/v_footer');
	}

	public function daftar_act()
	{
		
		$nama  = $this->input->post('nama');
		$email = $this->input->post('email');
		$hp = $this->input->post('hp');
		$alamat = $this->input->post('alamat');
		$password = md5($this->input->post('password'));
		$joindate = date("Y-m-d");
		$expdate = date("Y-m-d", strtotime('+1 year'));
		// echo $email;
		$cek_email = $this->db->query("select * from customer where customer_email='$email'");
		if($cek_email->num_rows() > 0){
			redirect(base_url().'welcome/daftar?alert=duplikat');
		}else{
			$data = array(
				'customer_nama' => $nama,
				'customer_email' => $email,
				'customer_hp' => $hp,
				'customer_alamat' => $alamat,
				'customer_password' => $password,
				'customer_joindate' => $joindate,
				'customer_expdate' => $expdate,
			);
			$this->m_data->insert_data($data,'customer');
			redirect(base_url().'welcome/masuk?alert=terdaftar');
		}

	}


	public function masuk()
	{
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_masuk');
		$this->load->view('frontend/v_footer');
	}

	public function masuk_act()
	{
		
		// menangkap data yang dikirim dari form
		$email = $this->input->post('email');
		$password = md5($this->input->post('password'));

		$login = $this->db->query("SELECT * FROM customer WHERE customer_email='$email' AND customer_password='$password'");
		$cek = $login->num_rows();

		if($cek > 0){
			$data = $login->row();

			// hapus session yg lain, agar tidak bentrok dengan session customer
			unset($_SESSION['id']);
			unset($_SESSION['nama']);
			unset($_SESSION['username']);
			unset($_SESSION['status']);

			// buat session customer
			$_SESSION['customer_id'] = $data->customer_id;
			$_SESSION['customer_status'] = "login";
			redirect(base_url()."welcome/customer");
		}else{
			redirect(base_url()."welcome/masuk?alert=gagal");
		}


	}


	public function checkout()
	{
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_checkout');
		$this->load->view('frontend/v_footer');
	}

	public function checkout_act()
	{

		$id_customer = $_SESSION['customer_id'];
		$tanggal = date('Y-m-d');
		$nama = $this->input->post('nama');
		$hp = $this->input->post('hp');
		$alamat = $this->input->post('alamat');
		$provinsi = $this->input->post('provinsi2');
		$kabupaten = $this->input->post('kabupaten2');
		$kurir = $this->input->post('kurir') ." - ". $this->input->post('service');
		$berat = $this->input->post('berat');
		$ongkir = $this->input->post('ongkir2');
		$total_bayar = $this->input->post('total_bayar')+$ongkir;

		$data = array(
			'invoice_tanggal' => $tanggal,
			'invoice_customer' => $id_customer,
			'invoice_nama' => $nama, 	
			'invoice_hp' => $hp, 	
			'invoice_alamat' => $alamat,
			'invoice_provinsi' => $provinsi,
			'invoice_kabupaten' => $kabupaten,
			'invoice_kurir' => $kurir,
			'invoice_berat' => $berat,
			'invoice_ongkir' => $ongkir,
			'invoice_total_bayar' => $total_bayar,
			'invoice_status' => '0',
			'invoice_resi' => '0',
			'invoice_bukti' => '0', 
		);

		$this->m_data->insert_data($data, 'invoice');

		$last_id = $this->db->insert_id();
		$invoice = $last_id;
		$jumlah_isi_keranjang = count($_SESSION['keranjang']);
		for($a = 0; $a < $jumlah_isi_keranjang; $a++){
			$id_produk = $_SESSION['keranjang'][$a]['produk'];
			$jml = $_SESSION['keranjang'][$a]['jumlah'];


			$isi = $this->db->query("select * from produk where produk_id='$id_produk'");
			$i = $isi->row();

			$produk = $i->produk_id;
			$jumlah = $_SESSION['keranjang'][$a]['jumlah'];
			$harga = $i->produk_harga;
			$diskon = $i->produk_diskonharga;

			$data = array(
				'transaksi_invoice' => $invoice,
				'transaksi_produk' => $produk,
				'transaksi_jumlah' => $jumlah, 	
				'transaksi_harga' => $harga,
				'transaksi_diskonharga' => $diskon
			);

			$this->m_data->insert_data($data, 'transaksi');
			unset($_SESSION['keranjang'][$a]);
		}

		redirect(base_url()."welcome/customer_pesanan?alert=sukses");
	}



	public function rajaongkir_cek_kabupaten()
	{

		$provinsi_id = $_GET['prov_id'];

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://api.rajaongkir.com/starter/city?province=$provinsi_id",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: 8f22875183c8c65879ef1ed0615d3371"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
  //echo $response;
		}

		$data = json_decode($response, true);
		echo "<option value=''>- Pilih Kabupaten / Kota -</option>";
		for ($i=0; $i < count($data['rajaongkir']['results']); $i++) { 
			echo "<option value='".$data['rajaongkir']['results'][$i]['city_id']."'>".$data['rajaongkir']['results'][$i]['city_name']."</option>";
		}
	}


	public function rajaongkir_cek_ongkir()
	{
		
		// $asal = $this->input->post('asal');
		$id_kabupaten = $this->input->post('kab_id');
		$kurir = $this->input->post('kurir');
		$berat = $this->input->post('berat');

		$curl_pos = curl_init();
		curl_setopt_array($curl_pos, array(
			CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "origin=152&destination=".$id_kabupaten."&weight=".$berat."&courier=pos",
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded",
				"key: 8f22875183c8c65879ef1ed0615d3371"
			),
		));

		$curl_jne = curl_init();
		curl_setopt_array($curl_jne, array(
			CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "origin=152&destination=".$id_kabupaten."&weight=".$berat."&courier=jne",
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded",
				"key: 8f22875183c8c65879ef1ed0615d3371"
			),
		));

		$curl_tiki = curl_init();
		curl_setopt_array($curl_tiki, array(
			CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "origin=152&destination=".$id_kabupaten."&weight=".$berat."&courier=tiki",
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded",
				"key: 8f22875183c8c65879ef1ed0615d3371"
			),
		));

		$response_pos = curl_exec($curl_pos);
		$err_pos = curl_error($curl_pos);

		$response_jne = curl_exec($curl_jne);
		$err_jne = curl_error($curl_jne);

		$response_tiki = curl_exec($curl_tiki);
		$err_tiki = curl_error($curl_tiki);

		curl_close($curl_pos);
		curl_close($curl_jne);
		curl_close($curl_tiki);

		if ($err_pos) {
			echo "cURL Error #:" . $err;
		} else {
			$data_pos = json_decode($response_pos, true);
			$data_jne = json_decode($response_jne, true);
			$data_tiki = json_decode($response_tiki, true);
			?>
			<table class="table table-bordered">
				<tr>
					<th>Kurir</th>
					<th>Service</th>
					<th>Ongkir</th>
					<th>Lama Pengiriman</th>
					<th>Pilih Kurir</th>
				</tr>
				<?php
				if(count($data_pos['rajaongkir']['results'][0]['costs']) > 0){
					for($a = 0;$a < count($data_pos['rajaongkir']['results'][0]['costs']);$a++){
						?>
						<tr>
							<td>Pos Indonesia</td>
							<td><?php echo $data_pos['rajaongkir']['results'][0]['costs'][$a]['service']; ?></td>
							<td><?php echo "Rp. ". number_format($data_pos['rajaongkir']['results'][0]['costs'][$a]['cost'][0]['value'])." ,-"; ?></td>
							<td><?php echo $data_pos['rajaongkir']['results'][0]['costs'][$a]['cost'][0]['etd']; ?></td>
							<td class="text-center">
								<input type="radio" name="kurirx" class="pilih-kurir" kurir="Pos Indonesia" service="<?php echo $data_pos['rajaongkir']['results'][0]['costs'][$a]['service']; ?>" harga="<?php echo $data_pos['rajaongkir']['results'][0]['costs'][$a]['cost'][0]['value']; ?>" required="required">
							</td>
						</tr>
						<?php 
					}
				}
				?>

				<?php 
				if(count($data_jne['rajaongkir']['results'][0]['costs']) > 0){
					for($a = 0;$a < count($data_jne['rajaongkir']['results'][0]['costs']);$a++){
						?>
						<tr>
							<td>JNE</td>
							<td><?php echo $data_jne['rajaongkir']['results'][0]['costs'][$a]['service']; ?></td>
							<td><?php echo "Rp. ". number_format($data_jne['rajaongkir']['results'][0]['costs'][$a]['cost'][0]['value'])." ,-"; ?></td>
							<td><?php echo $data_jne['rajaongkir']['results'][0]['costs'][$a]['cost'][0]['etd']; ?></td>
							<td class="text-center">
								<input type="radio" name="kurirx" class="pilih-kurir" kurir="JNE" service="<?php echo $data_jne['rajaongkir']['results'][0]['costs'][$a]['service']; ?>" harga="<?php echo $data_jne['rajaongkir']['results'][0]['costs'][$a]['cost'][0]['value']; ?>" required="required">
							</td>
						</tr>
						<?php 
					}
				}
				?>

				<?php
				if(count($data_tiki['rajaongkir']['results'][0]['costs']) > 0){
					for($a = 0;$a < count($data_tiki['rajaongkir']['results'][0]['costs']);$a++){
						?>
						<tr>
							<td>TIKI</td>
							<td><?php echo $data_tiki['rajaongkir']['results'][0]['costs'][$a]['service']; ?></td>
							<td><?php echo "Rp. ". number_format($data_tiki['rajaongkir']['results'][0]['costs'][$a]['cost'][0]['value'])." ,-"; ?></td>
							<td><?php echo $data_tiki['rajaongkir']['results'][0]['costs'][$a]['cost'][0]['etd']; ?></td>
							<td class="text-center">
								<input type="radio" name="kurirx" class="pilih-kurir" kurir="TIKI" service="<?php echo $data_tiki['rajaongkir']['results'][0]['costs'][$a]['service']; ?>" harga="<?php echo $data_tiki['rajaongkir']['results'][0]['costs'][$a]['cost'][0]['value']; ?>" required="required">
							</td>
						</tr>
						<?php 
					}
				}
				?>
			</table>

			<?php

		}

	}


	public function customer()
	{
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_customer');
		$this->load->view('frontend/v_footer');
	}

	public function customer_logout(){

		unset($_SESSION['customer_id']);
		unset($_SESSION['customer_status']);

		redirect(base_url()."welcome");
	}

	public function customer_password(){
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_customer_password');
		$this->load->view('frontend/v_footer');
	}

	public function customer_password_act(){
		$id = $_SESSION['customer_id'];
		$password = md5($this->input->post('password'));

		$where = array(
			'customer_id' => $id
		);

		$data = array(
			'customer_password' => $password
		);

		$this->m_data->update_data($where, $data, 'customer');

		redirect(base_url()."welcome/customer_password?alert=sukses");
	}


	public function customer_pesanan(){
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_customer_pesanan');
		$this->load->view('frontend/v_footer');
	}

	public function customer_invoice(){
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_customer_invoice');
		$this->load->view('frontend/v_footer');
	}

	public function reting_invoice(){
		$invoice_id	= $this->input->post('invoice_id');
		$reting		= $this->input->post('reting');

		$where = array(
			'invoice_id' => $invoice_id
		);

		$data = array(
			'invoice_rating' => $reting
		);

		$this->m_data->update_data($where, $data, 'invoice');

		redirect(base_url()."welcome/customer_pesanan");
	}

	public function customer_invoice_cetak(){
		$this->load->view('frontend/v_customer_invoice_cetak');
	}


	public function customer_pembayaran(){
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_customer_pembayaran');
		$this->load->view('frontend/v_footer');
	}

	public function customer_pembayaran_act(){

		$id = $this->input->post('id');

		$config['encrypt_name'] = TRUE;
		$config['upload_path']   = './gambar/bukti_pembayaran/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';

		$this->load->library('upload', $config);

		if($this->upload->do_upload('bukti')){
			$bukti = $this->upload->do_upload('bukti');
			$gambar1 = $this->upload->data();
			$bukti1 = $gambar1['file_name'];

			// hapus gambar lama
			$lama = $this->db->query("select * from invoice where invoice_id='$id'");
			$l = $lama->row();
			$foto = $l->invoice_bukti;

			@chmod('./gambar/bukti_pembayaran/'.$foto, 0777);
			@unlink('./gambar/bukti_pembayaran/'.$foto);

			$where = array(
				'invoice_id' => $id
			);

			$data = array(
				'invoice_bukti' => $bukti1,
				'invoice_status' => '1'
			);

			$this->m_data->update_data($where, $data, 'invoice');

			redirect(base_url()."welcome/customer_pesanan?alert=upload");

		}else{
			redirect(base_url()."welcome/customer_pesanan?alert=gagal");
		}

	}

	public function customer_member()
	{
		$this->load->library('pdfgenerator');
		$id = $_SESSION['customer_id'];
		$data['title_pdf'] = 'Kartu Member Customer';
		$file_pdf = 'Kartu Member Customer';
		$paper = 'A4';
		$orientation = "landscape";
		$data['data'] = $this->db->query("SELECT * FROM customer WHERE customer_id=$id")->result();
		$html = $this->load->view('frontend/v_customer_membercard_pdf',$data, true);	
		$this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
	}
 
	public function notfound()
	{
		$this->load->view('frontend/v_header');
		$this->load->view('frontend/v_notfound');
		$this->load->view('frontend/v_footer');
	}
}
