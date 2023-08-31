<?php 



// Model yang terstruktur. agar bisa digunakan berulang kali untuk membuat CRUD. 

// Sehingga proses pembuatan CRUD menjadi lebih cepat dan efisien.



class M_data extends CI_Model{

	

	function cek_login($table,$where){

		return $this->db->get_where($table,$where);

	}

	

	// FUNGSI CRUD

	// fungsi untuk mengambil data dari database

	function get_data($table){

		return $this->db->get($table);

	}



	// fungsi untuk menginput data ke database

	function insert_data($data,$table){

		$this->db->insert($table,$data);

	}



	// fungsi untuk mengedit data

	function edit_data($where,$table){

		return $this->db->get_where($table,$where);

	}



	// fungsi untuk mengupdate atau mengubah data di database

	function update_data($where,$data,$table){

		$this->db->where($where);

		$this->db->update($table,$data);

	}



	// fungsi untuk menghapus data dari database

	// function delete_data($where,$table){

	// 	$this->db->delete($table,$where);

	// }
	function delete_data($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}

	function get_data_grafik_pembelian_custamer() {
        $query = $this->db->select('customer.customer_nama, SUM(invoice.invoice_total_bayar) as total_purchase')
            ->from('customer')
            ->join('invoice', 'customer.customer_id = invoice.invoice_customer')
			->where('YEAR(invoice_tanggal)', date('Y'))
            ->group_by('customer.customer_nama')
            ->order_by('total_purchase', 'desc')
            ->limit(10)
            ->get();

        return $query->result();
    }

	// AKHIR FUNGSI CRUD





}



?>
