<?php
    $CI =& get_instance();

    if(!function_exists('counter_view_product')) {
        function counter_view_product($produk_id = null) {
            global $CI;
            $now = strtotime(date('d-m-Y'));
            $from = strtotime('now');
            $to = strtotime("+1 days");
            $user_ip = $CI->input->ip_address();
            $cek = $CI->db->query("SELECT * FROM visitor_produk WHERE produk_id='$produk_id' AND user_ip='$user_ip' AND created_at >= $now AND created_at < $to");

            if ($cek->num_rows() == 0) {
                $data = array(
                    'produk_id' => $produk_id,
                    'user_ip' => $user_ip,
                    'created_at' => $from,
                );
                $CI->m_data->insert_data($data,"visitor_produk");
            }
        }
       
    }

?>