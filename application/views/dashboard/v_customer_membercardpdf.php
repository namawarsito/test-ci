<?php // cara include file dompdf
//require_once '../../vendor/dompdf/dompdf_config.inc.php';

// memanggil file koneksi
//include 'config.php';

// perintah sql query
//$sql = mysqli_query($conn, "SELECT * FROM ed_users WHERE id_user ='".$_GET['id']."' ");
//$user = mysqli_fetch_array($sql);

// membuat variable penampung
$name = "Budi";
$gen = "Laki laki";

$html = 
		'<html><body>'.
		'<center>Customer - Kartu Member</center><br>'.
		'Nama : '.$name.'<br>'.
		'Gender : '.$gen.
		'</body></html>';

$pdf = new dompdf();
$pdf->load_html($html);

// untuk mengconvert ke PDF
$pdf->render();

// menyimpan ke file pdf dan fungsi attachment agar bisa ditampilkan kedalam pdf apabila nilai nol(0)
$pdf->stream('File.pdf', array("Attachemnt"=>0));
?>
