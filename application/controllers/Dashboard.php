<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		date_default_timezone_set('Asia/Jakarta');

		$this->load->model('m_data');
		$this->load->helper('artikel');

		// cek session yang login, 
		// jika session status tidak sama dengan session telah_login, berarti admin belum login
		// maka halaman akan di alihkan kembali ke halaman login.
		if($this->session->userdata('status')!="telah_login"){
			redirect(base_url().'login?alert=belum_login');
		}
	}

	public function index()
	{
		$ci =& get_instance();
		// hitung jumlah artikel
		$jumlah_produk = $this->m_data->get_data('produk')->num_rows();
		// hitung jumlah kategori
		$jumlah_kategori = $this->m_data->get_data('kategori')->num_rows();
		// hitung jumlah admin
		$jumlah_admin = $this->m_data->get_data('admin')->num_rows();
		// hitung jumlah halaman
		$jumlah_invoice = $this->m_data->get_data('invoice')->num_rows();

		$label = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        for($bulan = 1;$bulan < 13;$bulan++)
        {
			$query = $ci->db->query("SELECT COALESCE(SUM(invoice_total_bayar),0) AS totalval FROM invoice WHERE MONTH(invoice_tanggal) = $bulan  AND invoice_status IN ('3', '4', '5')")->row();
			$data[] = $query->totalval;
        }

		$purchaseData = $this->m_data->get_data_grafik_pembelian_custamer();

		$ratings = $this->db->select('invoice_rating, COUNT(*) as count')->from('invoice')->group_by('invoice_rating')->get()->result();
		
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_index', compact('jumlah_produk','jumlah_kategori','jumlah_admin','jumlah_invoice','label','data','purchaseData','ratings'));
		$this->load->view('dashboard/v_footer');
	}

	public function keluar()
	{
		$this->session->sess_destroy();
		redirect('login?alert=logout');
	}

	public function ganti_password()
	{
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_ganti_password');
		$this->load->view('dashboard/v_footer');
	}

	public function ganti_password_aksi()
	{

		// form validasi
		$this->form_validation->set_rules('password_lama','Password Lama','required');
		$this->form_validation->set_rules('password_baru','Password Baru','required|min_length[8]');
		$this->form_validation->set_rules('konfirmasi_password','Konfirmasi Password Baru','required|matches[password_baru]');

		// cek validasi
		if($this->form_validation->run() != false){

			// menangkap data dari form
			$password_lama = $this->input->post('password_lama');
			$password_baru = $this->input->post('password_baru');
			$konfirmasi_password = $this->input->post('konfirmasi_password');

			// cek kesesuaian password lama dengan id admin yang sedang login dan password lama
			$where = array(
				'admin_id' => $this->session->userdata('id'),
				'admin_password' => md5($password_lama)
			);
			$cek = $this->m_data->cek_login('admin', $where)->num_rows();

			// cek kesesuaikan password lama
			if($cek > 0){

				// update data password admin
				$w = array(
					'admin_id' => $this->session->userdata('id')
				);
				$data = array(
					'admin_password' => md5($password_baru)
				);
				$this->m_data->update_data($where, $data, 'admin');

				// alihkan halaman kembali ke halaman ganti password
				redirect('dashboard/ganti_password?alert=sukses');
			}else{
				// alihkan halaman kembali ke halaman ganti password
				redirect('dashboard/ganti_password?alert=gagal');
			}

		}else{
			$this->load->view('dashboard/v_header');
			$this->load->view('dashboard/v_ganti_password');
			$this->load->view('dashboard/v_footer');
		}

	}

	// CRUD KATEGORI
	public function kategori()
	{
		$data['kategori'] = $this->m_data->get_data('kategori')->result();
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_kategori',$data);
		$this->load->view('dashboard/v_footer');
	}

	public function kategori_tambah()
	{
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_kategori_tambah');
		$this->load->view('dashboard/v_footer');
	}

	public function kategori_aksi()
	{
		$this->form_validation->set_rules('kategori','Kategori','required');

		if($this->form_validation->run() != false){

			$kategori = $this->input->post('kategori');

			$data = array(
				'kategori_nama' => $kategori
			);

			$this->m_data->insert_data($data,'kategori');

			redirect(base_url().'dashboard/kategori');
			
		}else{
			$this->load->view('dashboard/v_header');
			$this->load->view('dashboard/v_kategori_tambah');
			$this->load->view('dashboard/v_footer');
		}
	}

	public function kategori_edit($id)
	{
		$where = array(
			'kategori_id' => $id
		);
		$data['kategori'] = $this->m_data->edit_data($where,'kategori')->result();
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_kategori_edit',$data);
		$this->load->view('dashboard/v_footer');
	}

	public function kategori_update()
	{
		$this->form_validation->set_rules('kategori','Kategori','required');

		if($this->form_validation->run() != false){

			$id = $this->input->post('id');
			$kategori = $this->input->post('kategori');

			$where = array(
				'kategori_id' => $id
			);

			$data = array(
				'kategori_nama' => $kategori
			);

			$this->m_data->update_data($where, $data,'kategori');

			redirect(base_url().'dashboard/kategori');
			
		}else{

			$id = $this->input->post('id');
			$where = array(
				'kategori_id' => $id
			);
			$data['kategori'] = $this->m_data->edit_data($where,'kategori')->result();
			$this->load->view('dashboard/v_header');
			$this->load->view('dashboard/v_kategori_edit',$data);
			$this->load->view('dashboard/v_footer');
		}
	}


	public function kategori_hapus($id)
	{
		$where = array(
			'kategori_id' => $id
		);

		$this->m_data->delete_data($where,'kategori');


		$w = array(
			'produk_kategori' => $id
		);

		$data = array(
			'produk_kategori' => "1"
		);

		// $this->m_data->update_data($where, $data, 'produk');

		redirect(base_url().'dashboard/kategori');
	}
	// END CRUD KATEGORI






	// CRUD CUSTOMER
	public function customer()
	{
		$data['customer'] = $this->m_data->get_data('customer')->result();
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_customer',$data);
		$this->load->view('dashboard/v_footer');
	}

	public function customer_tambah()
	{
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_customer_tambah');
		$this->load->view('dashboard/v_footer');
	}

	public function customer_aksi()
	{
		$this->form_validation->set_rules('nama','Nama','required');
		$this->form_validation->set_rules('email','email','required');
		$this->form_validation->set_rules('hp','hp','required');
		$this->form_validation->set_rules('alamat','alamat','required');
		$this->form_validation->set_rules('memberstatus','memberstatus','required');
		$this->form_validation->set_rules('password','password','required');

		if($this->form_validation->run() != false){

			$nama = $this->input->post('nama');
			$email = $this->input->post('email');
			$hp = $this->input->post('hp');
			$alamat = $this->input->post('alamat');
			$memberstatus = $this->input->post('memberstatus');
			$password = $this->input->post('password');
			$joindate = date("Y-m-d");
			$expdate = date("Y-m-d", strtotime('+1 year'));

			$data = array(
				'customer_nama' => $nama,
				'customer_email' => $email,
				'customer_hp' => $hp,
				'customer_alamat' => $alamat,
				'customer_memberstatus' => $memberstatus,
				'customer_password' => md5($password),
				'customer_joindate' => $joindate,
				'customer_expdate' => $expdate,
			);

			$this->m_data->insert_data($data,'customer');

			redirect(base_url().'dashboard/customer');
			
		}else{
			$this->load->view('dashboard/v_header');
			$this->load->view('dashboard/v_customer_tambah');
			$this->load->view('dashboard/v_footer');
		}
	}

	public function customer_edit($id)
	{
		$where = array(
			'customer_id' => $id
		);
		$data['customer'] = $this->m_data->edit_data($where,'customer')->result();
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_customer_edit',$data);
		$this->load->view('dashboard/v_footer');
	}



	public function customer_update()
	{
		$this->form_validation->set_rules('nama','Nama','required');
		$this->form_validation->set_rules('email','email','required');
		$this->form_validation->set_rules('hp','hp','required');
		$this->form_validation->set_rules('alamat','alamat','required');
		$this->form_validation->set_rules('memberstatus','memberstatus','required');

		if($this->form_validation->run() != false){

			$id = $this->input->post('id');
			$nama = $this->input->post('nama');
			$email = $this->input->post('email');
			$hp = $this->input->post('hp');
			$alamat = $this->input->post('alamat');
			$memberstatus = $this->input->post('memberstatus');
			$password = $this->input->post('password');

			$where = array(
				'customer_id' => $id
			);

			$data = array(
				'customer_nama' => $nama,
				'customer_email' => $email,
				'customer_hp' => $hp,
				'customer_alamat' => $alamat,
				'customer_memberstatus' => $memberstatus,
				'customer_password' => md5($password),
			);

			$this->m_data->update_data($where, $data,'customer');

			redirect(base_url().'dashboard/customer');
			
		}else{

			$id = $this->input->post('id');
			$where = array(
				'customer_id' => $id
			);
			$data['customer'] = $this->m_data->edit_data($where,'customer')->result();
			$this->load->view('dashboard/v_header');
			$this->load->view('dashboard/v_customer_edit',$data);
			$this->load->view('dashboard/v_footer');
		}
	}


	public function customer_hapus($id)
	{
		$where = array(
			'customer_id' => $id
		);

		$this->m_data->delete_data($where,'customer');

		redirect(base_url().'dashboard/customer');
	}
	
	public function customer_member($id)
	{
		$this->load->library('pdfgenerator');
		$data['title_pdf'] = 'Kartu Member Customer';
		$file_pdf = 'Kartu Member Customer';
		$paper = 'A4';
		$orientation = "landscape";
		$data['data'] = $this->db->query("SELECT * FROM customer WHERE customer_id=$id")->result();
		$html = $this->load->view('dashboard/v_customer_membercard_pdf',$data, true);	
		$this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
	}

	public function customer_delcustexp()
	{
		$where = array(
			'date(customer_expdate) <' => date("Y-m-d")
		);
		//$this->m_data->where('date(customer_expdate) <', date("Y-m-d"));

		$this->m_data->delete_data($where, 'customer');

		redirect(base_url().'dashboard/customer');
	}
	// END CRUD CUSTOMER


	// CRUD Produk
	public function produk()
	{
		$data['produk'] = $this->db->query("SELECT * FROM produk,kategori where kategori_id=produk_kategori order by produk_id desc")->result();	
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_produk',$data);
		$this->load->view('dashboard/v_footer');
	}

	public function produk_tambah()
	{
		$data['kategori'] = $this->m_data->get_data('kategori')->result();
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_produk_tambah',$data);
		$this->load->view('dashboard/v_footer');
	}

	public function produk_aksi()
	{
		$this->form_validation->set_rules('nama','nama','required');
		$this->form_validation->set_rules('kategori','kategori','required');
		$this->form_validation->set_rules('harga','harga','required');
		$this->form_validation->set_rules('jumlah','jumlah','required');
		$this->form_validation->set_rules('berat','berat','required');
		$this->form_validation->set_rules('keterangan','keterangan','required');

		if($this->form_validation->run() != false){
			$config['encrypt_name'] = TRUE;
			$config['upload_path']   = './gambar/produk/';
			$config['allowed_types'] = 'gif|jpg|png';

			$this->load->library('upload', $config);

			if($this->upload->do_upload('foto1')){
				$foto1 = $this->upload->do_upload('foto1');
				$gambar1 = $this->upload->data();
				$foto1 = $gambar1['file_name'];
			}else{
				$foto1 = "";
			}

			if($this->upload->do_upload('foto2')){
				$foto2 = $this->upload->do_upload('foto2');
				$gambar1 = $this->upload->data();
				$foto2 = $gambar1['file_name'];
			}else{
				$foto2 = "";
			}

			if($this->upload->do_upload('foto3')){
				$foto3 = $this->upload->do_upload('foto3');
				$gambar1 = $this->upload->data();
				$foto3 = $gambar1['file_name'];
			}else{
				$foto3 = "";
			}

			$nama = $this->input->post('nama');
			$kategori = $this->input->post('kategori');
			$harga = $this->input->post('harga');
			$diskonharga = $this->input->post('diskonharga');
			$jumlah = $this->input->post('jumlah');
			$berat = $this->input->post('berat');
			$keterangan = $this->input->post('keterangan');


			$data = array(
				'produk_nama' => $nama,
				'produk_kategori' => $kategori,
				'produk_harga' => $harga,
				'produk_diskonharga' => $diskonharga,
				'produk_jumlah' => $jumlah,
				'produk_berat' => $berat,
				'produk_keterangan' => $keterangan,
				'produk_foto1' => $foto1,
				'produk_foto2' => $foto2,
				'produk_foto3' => $foto3,
			);

			$this->m_data->insert_data($data,'produk');

			redirect(base_url().'dashboard/produk');	

		}else{
			$data['kategori'] = $this->m_data->get_data('kategori')->result();
			$this->load->view('dashboard/v_header');
			$this->load->view('dashboard/v_produk_tambah',$data);
			$this->load->view('dashboard/v_footer');
		}
	}


	public function produk_edit($id)
	{
		$where = array(
			'produk_id' => $id
		);
		$data['produk'] = $this->m_data->edit_data($where,'produk')->result();
		$data['kategori'] = $this->m_data->get_data('kategori')->result();
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_produk_edit',$data);
		$this->load->view('dashboard/v_footer');
	}


	public function produk_update()
	{
		// Wajib isi judul,konten dan kategori
		$this->form_validation->set_rules('nama','nama','required');
		$this->form_validation->set_rules('kategori','kategori','required');
		$this->form_validation->set_rules('harga','harga','required');
		$this->form_validation->set_rules('jumlah','jumlah','required');
		$this->form_validation->set_rules('berat','berat','required');
		$this->form_validation->set_rules('keterangan','keterangan','required');

		if($this->form_validation->run() != false){

			$id = $this->input->post('id');

			$nama = $this->input->post('nama');
			$kategori = $this->input->post('kategori');
			$harga = $this->input->post('harga');
			$diskonharga = $this->input->post('diskonharga');
			$jumlah = $this->input->post('jumlah');
			$berat = $this->input->post('berat');
			$keterangan = $this->input->post('keterangan');

			$where = array(
				'produk_id' => $id
			);

			$data = array(
				'produk_nama' => $nama,
				'produk_kategori' => $kategori,
				'produk_harga' => $harga,
				'produk_diskonharga' => $diskonharga,
				'produk_jumlah' => $jumlah,
				'produk_berat' => $berat,
				'produk_keterangan' => $keterangan
			);

			$this->m_data->update_data($where,$data,'produk');

			$detail_produk = $this->m_data->edit_data($where,'produk')->row();

			$config['encrypt_name'] = TRUE;
			$config['upload_path']   = './gambar/produk/';
			$config['allowed_types'] = 'gif|jpg|png';

			if(!empty($_FILES['foto1']['name'])){
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('foto1')) {


					@chmod('./gambar/produk/'.$detail_produk->produk_foto1, 0777);
					@unlink('./gambar/produk/'.$detail_produk->produk_foto1);

					$gambar = $this->upload->data();
					$data = array(
						'produk_foto1' => $gambar['file_name'],
					);
					$this->m_data->update_data($where,$data,'produk');
				}
			}

			if(!empty($_FILES['foto2']['name'])){
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('foto2')) {

					@chmod('./gambar/produk/'.$detail_produk->produk_foto2, 0777);
					@unlink('./gambar/produk/'.$detail_produk->produk_foto2);

					$gambar = $this->upload->data();
					$data = array(
						'produk_foto2' => $gambar['file_name'],
					);
					$this->m_data->update_data($where,$data,'produk');
				}
			}

			if(!empty($_FILES['foto3']['name'])){

				$this->load->library('upload', $config);
				if ($this->upload->do_upload('foto3')) {

					@chmod('./gambar/produk/'.$detail_produk->produk_foto3, 0777);
					@unlink('./gambar/produk/'.$detail_produk->produk_foto3);

					$gambar = $this->upload->data();
					$data = array(
						'produk_foto3' => $gambar['file_name'],
					);
					$this->m_data->update_data($where,$data,'produk');
				}
			}

			redirect(base_url().'dashboard/produk');

		}else{
			$id = $this->input->post('id');
			$where = array(
				'produk_id' => $id
			);
			$data['produk'] = $this->m_data->edit_data($where,'produk')->result();
			$data['kategori'] = $this->m_data->get_data('kategori')->result();
			$this->load->view('dashboard/v_header');
			$this->load->view('dashboard/v_produk_edit',$data);
			$this->load->view('dashboard/v_footer');
		}
	}

	public function produk_hapus($id)
	{
		$where = array(
			'produk_id' => $id
		);

		$produk = $this->m_data->edit_data($where,'produk')->row();
		
		@chmod('./gambar/produk/'.$produk->produk_foto1, 0777);
		@unlink('./gambar/produk/'.$produk->produk_foto1);

		@chmod('./gambar/produk/'.$produk->produk_foto2, 0777);
		@unlink('./gambar/produk/'.$produk->produk_foto2);

		@chmod('./gambar/produk/'.$produk->produk_foto3, 0777);
		@unlink('./gambar/produk/'.$produk->produk_foto3);

		$this->m_data->delete_data($where,'produk');
		redirect(base_url().'dashboard/produk');
	}
	// end crud produk


	// CRUD transaksi
	public function transaksi()
	{
		$data['transaksi'] = $this->db->query('select * from invoice,customer where customer_id=invoice_customer order by invoice_id desc')->result();
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_transaksi',$data);
		$this->load->view('dashboard/v_footer');
	}

	public function transaksi_invoice($id_invoice)
	{
		$data['invoice'] = $this->db->query("select * from invoice where invoice_id='$id_invoice' order by invoice_id desc")->result();

		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_transaksi_invoice',$data);
		$this->load->view('dashboard/v_footer');
	}

	public function transaksi_invoice_cetak($id_invoice)
	{
		$data['invoice'] = $this->db->query("select * from invoice where invoice_id='$id_invoice' order by invoice_id desc")->result();

		$this->load->view('dashboard/v_transaksi_invoice_cetak',$data);
	}



	public function transaksi_status()
	{
		$invoice  = $this->input->post('invoice');
		$status  = $this->input->post('status');
		$where = array(
			'invoice_id' => $invoice
		);
		$data = array(
			'invoice_status' => $status
		);
		$this->m_data->update_data($where,$data,'invoice');
		redirect(base_url().'dashboard/transaksi');
	}


	public function transaksi_hapus($id)
	{

		$lama = $this->db->query("select * from invoice where invoice_id='$id'");
		$l = $lama->row();
		$foto = $l->invoice_bukti;

		@chmod('./gambar/bukti_pembayaran/'.$foto, 0777);
		@unlink('./gambar/bukti_pembayaran/'.$foto);

		$where = array(
			'invoice_id' => $id
		);

		$this->m_data->delete_data($where,'invoice');

		$where = array(
			'transaksi_invoice' => $id
		);

		$this->m_data->delete_data($where,'transaksi');

		redirect(base_url().'dashboard/transaksi');
	}
	// END CRUD transaksi


	public function pengunjung()
	{
		$data['transaksi'] = $this->db->query('select * from transaksi,produk where produk_id=transaksi_produk order by transaksi_produk desc')->result();
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_pengunjung',$data);
		$this->load->view('dashboard/v_footer');
	}




	public function laporan()
	{

		if(isset($_GET['tanggal_sampai']) && isset($_GET['tanggal_dari'])){

			$tgl_dari = $_GET['tanggal_dari'];
			$tgl_sampai = $_GET['tanggal_sampai'];
			$data['data'] = $this->db->query("SELECT * FROM invoice,customer WHERE invoice_customer=customer_id and date(invoice_tanggal) >= '$tgl_dari' AND date(invoice_tanggal) <= '$tgl_sampai'")->result();
			$this->load->view('dashboard/v_header');
			$this->load->view('dashboard/v_laporan',$data);
			$this->load->view('dashboard/v_footer');
		}else{
			$this->load->view('dashboard/v_header');
			$this->load->view('dashboard/v_laporan');
			$this->load->view('dashboard/v_footer');
		}

	}

	public function laporan_print()
	{

		if(isset($_GET['tanggal_sampai']) && isset($_GET['tanggal_dari'])){

			$tgl_dari = $_GET['tanggal_dari'];
			$tgl_sampai = $_GET['tanggal_sampai'];
			$data['data'] = $this->db->query("SELECT * FROM invoice,customer WHERE invoice_customer=customer_id and date(invoice_tanggal) >= '$tgl_dari' AND date(invoice_tanggal) <= '$tgl_sampai'")->result();
			$this->load->view('dashboard/v_laporan_print',$data);
		}else{
			$this->load->view('dashboard/v_laporan_print');
		}

	}


	public function laporan_pdf()
	{

		if(isset($_GET['tanggal_sampai']) && isset($_GET['tanggal_dari'])){
			$tgl_dari = $_GET['tanggal_dari'];
			$tgl_sampai = $_GET['tanggal_sampai'];

			$this->load->library('pdfgenerator');
			$data['title_pdf'] = 'Laporan Penjualan';
			$file_pdf = 'laporan_penjualan';
			$paper = 'A4';
			$orientation = "landscape";
			$data['data'] = $this->db->query("SELECT * FROM invoice,customer WHERE invoice_customer=customer_id and date(invoice_tanggal) >= '$tgl_dari' AND date(invoice_tanggal) <= '$tgl_sampai'")->result();
			$html = $this->load->view('dashboard/v_laporan_pdf',$data, true);	
			$this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
		}
	}




	// CRUD admin
	public function admin()
	{
		$data['admin'] = $this->m_data->get_data('admin')->result();	
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_admin',$data);
		$this->load->view('dashboard/v_footer');
	}

	public function admin_tambah()
	{
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_admin_tambah');
		$this->load->view('dashboard/v_footer');
	}

	public function admin_aksi()
	{
		// Wajib isi
		$this->form_validation->set_rules('nama','Nama admin','required');
		$this->form_validation->set_rules('username','Username admin','required');
		$this->form_validation->set_rules('password','Password admin','required|min_length[8]');

		if($this->form_validation->run() != false){

			$config['encrypt_name'] = TRUE;
			$config['upload_path']   = './gambar/user/';
			$config['allowed_types'] = 'gif|jpg|png';

			$this->load->library('upload', $config);

			if($this->upload->do_upload('foto')){
				$foto = $this->upload->do_upload('foto');
				$gambar1 = $this->upload->data();
				$foto = $gambar1['file_name'];
			}else{
				$foto = "";
			}

			$nama = $this->input->post('nama');
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));

			$data = array(
				'admin_nama' => $nama,
				'admin_username' => $username,
				'admin_password' => md5($password),
				'admin_foto' => $foto
			);

			$this->m_data->insert_data($data,'admin');

			redirect(base_url().'dashboard/admin');	

		}else{
			$this->load->view('dashboard/v_header');
			$this->load->view('dashboard/v_admin_tambah');
			$this->load->view('dashboard/v_footer');
		}
	}

	public function admin_edit($id)
	{
		$where = array(
			'admin_id' => $id
		);
		$data['admin'] = $this->m_data->edit_data($where,'admin')->result();
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_admin_edit',$data);
		$this->load->view('dashboard/v_footer');
	}


	public function admin_update()
	{
		// Wajib isi
		$this->form_validation->set_rules('nama','Nama admin','required');
		$this->form_validation->set_rules('username','Username admin','required');

		if($this->form_validation->run() != false){

			$config['encrypt_name'] = TRUE;
			$config['upload_path']   = './gambar/user/';
			$config['allowed_types'] = 'gif|jpg|png';

			$this->load->library('upload', $config);

			$id = $this->input->post('id');
			$nama = $this->input->post('nama');
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));

			$where = array(
				'admin_id' => $id
			);

			$detail_admin = $this->m_data->edit_data($where,'admin')->row();

			if(!empty($_FILES['foto']['name'])){

				$this->load->library('upload', $config);
				if ($this->upload->do_upload('foto')) {

					@chmod('./gambar/user/'.$detail_admin->admin_foto, 0777);
					@unlink('./gambar/user/'.$detail_admin->admin_foto);

					$gambar = $this->upload->data();
					$data = array(
						'admin_foto' => $gambar['file_name'],
					);
					$this->m_data->update_data($where,$data,'admin');
				}
			}

			if($this->input->post('password') == ""){
				$data = array(
					'admin_nama' => $nama,
					'admin_username' => $username
				);
			}else{
				$data = array(
					'admin_nama' => $nama,
					'admin_username' => $username,
					'admin_password' => $password
				);
			}


			$this->m_data->update_data($where,$data,'admin');

			redirect(base_url().'dashboard/admin');
		}else{
			$id = $this->input->post('id');
			$where = array(
				'admin_id' => $id
			);
			$data['admin'] = $this->m_data->edit_data($where,'admin')->result();
			$this->load->view('dashboard/v_header');
			$this->load->view('dashboard/v_admin_edit',$data);
			$this->load->view('dashboard/v_footer');
		}
	}


	public function admin_hapus($id)
	{
		$where = array(
			'admin_id' => $id
		);

		$detail_admin = $this->m_data->edit_data($where,'admin')->row();

		@chmod('./gambar/user/'.$detail_admin->admin_foto, 0777);
		@unlink('./gambar/user/'.$detail_admin->admin_foto);

		$this->m_data->delete_data($where,'admin');

		redirect(base_url().'dashboard/admin');
	}
	// end crud admin

	// Chat
		public function chat()
	{
		$this->load->view('dashboard/v_header');
		$this->load->view('dashboard/v_chat');
		$this->load->view('dashboard/v_footer');
	}

}
	