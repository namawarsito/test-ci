<?php 
function create_slug($name,$table)
{
    $ci =& get_instance();
    $count = 0;
    $name = strtolower(url_title($name));
    $slug_name = $name;
    while(true) 
    {
        $ci->db->select($table.'_id');
        $ci->db->where($table.'_slug', $slug_name);   // Test temp name
        $query = $ci->db->get($table);
        if ($query->num_rows() == 0) break;
        $slug_name = $name . '-' . (++$count);  // Recreate new temp name
    }
    return $slug_name;      // Return temp name
}

function update_slug($id, $name, $table)
{
    $ci =& get_instance();
    $count = 0;
    $name = strtolower(url_title($name));
    $slug_name = $name;
    while(true) 
    {
        $ci->db->select($table.'_id');
        $ci->db->where($table.'_id !=', $id);
        $ci->db->where($table.'_slug', $slug_name);   // Test temp name
        $query = $ci->db->get($table);
        if ($query->num_rows() == 0) break;
        $slug_name = $name . '-' . (++$count);  // Recreate new temp name
    }
    return $slug_name;      // Return temp name
}
// Monthly Sales
function monthly_sales_data($bulan,$tahun,$tipe="totalbayar"){
	$ci =& get_instance();
	$awal_bulan = $tahun."/".$bulan."/1";
	$akhir_bulan = $tahun."/".($bulan+1)."/1";
	if( $tipe == "jumlahinv" ){
		$tipe_val = " COUNT(invoice_id) ";
	}else{
		$tipe_val = " COALESCE(SUM(invoice_total_bayar),0) ";
	}

	$query = $ci->db->query("SELECT $tipe_val AS totalval FROM invoice WHERE date(invoice_tanggal) >= '$awal_bulan' AND date(invoice_tanggal) < '$akhir_bulan' AND invoice_status IN ('3', '4', '5')")->row();
	return $query->totalval;
}

?>
