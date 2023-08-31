<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Transaksi
      <small>Transaksi</small>
    </h1>
  </section>

  <section class="content">

    <div class="row">
      <div class="col-lg-12">


        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Transaksi</h3>
          </div>
          
          <div class="box-body">

           <?php 
           foreach($invoice as $i){
            ?>


            <div class="col-lg-12">

              <a href="<?php echo base_url('dashboard/transaksi') ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> KEMBALI</a>
              <a href="<?php echo base_url('dashboard/transaksi_invoice_cetak/') ?><?php echo $i->invoice_id ?>" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-print"></i> CETAK</a>

              <br/>
              <br/>

              <h4>INVOICE-00<?php echo $i->invoice_id ?></h4>

              <br/>
              <?php echo $i->invoice_nama; ?><br/>
              <?php echo $i->invoice_alamat; ?><br/>
              <?php echo $i->invoice_provinsi; ?><br/>
              <?php echo $i->invoice_kabupaten; ?><br/>
              Hp. <?php echo $i->invoice_hp; ?><br/>
              <br/>

              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="text-center" width="1%">NO</th>
                      <th colspan="2">Produk</th>
                      <th class="text-center">Harga</th>
                      <th class="text-center">Jumlah</th>
                      <th class="text-center">Total Harga</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no = 1;
                    $total = 0;
                    $id_invoice = $i->invoice_id;
                    $transaksi = $this->db->query("select * from transaksi,produk where transaksi_produk=produk_id and transaksi_invoice='$id_invoice'")->result();
                    foreach($transaksi as $d){
                      $total += ($d->transaksi_harga - $d->transaksi_diskonharga);
                      ?>
                      <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td>
                          <center>
                            <?php if($d->produk_foto1 == ""){ ?>
                              <img src="<?php echo base_url(); ?>gambar/sistem/produk.png" style="width: 50px;height: auto">
                            <?php }else{ ?>
                              <img src="<?php echo base_url(); ?>gambar/produk/<?php echo $d->produk_foto1 ?>" style="width: 50px;height: auto">
                            <?php } ?>
                          </center>
                        </td>
                        <td><?php echo $d->produk_nama; ?></td>
                        <td class="text-center">
                          <?php if( $d->transaksi_diskonharga > 0 ){ ?>
															<?php echo "Rp. ".number_format(($d->transaksi_harga - $d->transaksi_diskonharga)).",-"; ?> 
															<span class="price-before invprice"> <?php echo "Rp. ".number_format($d->transaksi_harga).",-"; ?> </span>
														<?php }else{ ?>
															<?php echo "Rp. ".number_format($d->transaksi_harga).",-"; ?> 
														<?php } ?>
                        </td>
                        <td class="text-center"><?php echo number_format($d->transaksi_jumlah); ?></td>
                        <td class="text-center"><?php echo "Rp. ".number_format($d->transaksi_jumlah * ($d->transaksi_harga - $d->transaksi_diskonharga) )." ,-"; ?></td>
                      </tr>
                      <?php 
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4" style="border: none"></td>
                      <th>Berat</th>
                      <td class="text-center"><?php echo number_format($i->invoice_berat); ?> gram</td>
                    </tr>
                    <tr>
                      <td colspan="4" style="border: none"></td>
                      <th>Total Belanja</th>
                      <td class="text-center"><?php echo "Rp. ".number_format($total)." ,-"; ?></td>
                    </tr>
                    <tr>
                      <td colspan="4" style="border: none"></td>
                      <th>Ongkir (<?php echo $i->invoice_kurir ?>)</th>
                      <td class="text-center"><?php echo "Rp. ".number_format($i->invoice_ongkir)." ,-"; ?></td>
                    </tr>
                    <tr>
                      <td colspan="4" style="border: none"></td>
                      <th>Total Bayar</th>
                      <td class="text-center"><?php echo "Rp. ".number_format($i->invoice_total_bayar)." ,-"; ?></td>
                    </tr>
                  </tfoot>
                </table>
              </div>


              <h5>STATUS :</h5> 
              <?php 
              if($i->invoice_status == 0){
                echo "<span class='label label-warning'>Menunggu Pembayaran</span>";
              }elseif($i->invoice_status == 1){
                echo "<span class='label label-default'>Menunggu Konfirmasi</span>";
              }elseif($i->invoice_status == 2){
                echo "<span class='label label-danger'>Ditolak</span>";
              }elseif($i->invoice_status == 3){
                echo "<span class='label label-primary'>Dikonfirmasi & Sedang Diproses</span>";
              }elseif($i->invoice_status == 4){
                echo "<span class='label label-warning'>Dikirim</span>";
              }elseif($i->invoice_status == 5){
                echo "<span class='label label-success'>Selesai</span>";
              }
              ?>

            </div>  


            <?php 
          }
          ?>

        </div>

      </div>

    </div>
  </div>

</section>

</div>