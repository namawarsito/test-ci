        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Grafik Chart Menggunakan Amcharts</h1>
            </section>

           <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title"><i class="fa fa-line-chart"></i> Grafik </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                            <?php 
                   $data_peminjaman_buku = $this->db->query("SELECT COUNT(transaksi_produk) AS jumlah FROM transaksi")->result();
                    foreach ($data_peminjaman_buku as $pinjam => $p_buku) {
                       $data_pinjam[]=['y'=>$p_buku->jumlah];
                    } ?>
                    <div id="data_peminjaman" style="height: 370px; width: 100%;"></div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>