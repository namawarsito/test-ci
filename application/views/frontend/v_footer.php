
<!-- FOOTER -->
<footer id="footer" class="section section-grey">
  <!-- container -->
  <div class="container">
    <!-- row -->
    <div class="row">
      <!-- footer widget -->
      <div class="col-md-3 col-sm-6 col-xs-6">
        <div class="footer">
          <!-- footer logo -->
          <div class="footer-logo">
            <a class="logo" href="#">
              <img src="<?php echo base_url() ?>gambar/sistem/logo2.png" alt="" height="">
            </a>
          
          <!-- /footer logo -->

          <p>Toko online penyedia Laptop beserta sparepart di Kota Surakarta.</p>
          </div>
        </div>
      </div>
      <!-- /footer widget -->

      <!-- footer widget -->
      <div class="col-md-3 col-sm-6 col-xs-6">
        <div class="footer">
          <h3 class="footer-header">My Account</h3>
          <ul class="list-links">
            <li><a href="<?php echo base_url('welcome/keranjang') ?>">Keranjang</a></li>
            <li><a href="<?php echo base_url('welcome/checkout') ?>">Checkout</a></li>
            <li><a href="<?php echo base_url('welcome/daftar') ?>">Daftar</a></li>
            <li><a href="<?php echo base_url('welcome/masuk') ?>">Login</a></li>
          </ul>
        </div>
      </div>
      <!-- /footer widget -->

      <div class="clearfix visible-sm visible-xs"></div>

      <!-- footer widget -->
      <div class="col-md-3 col-sm-6 col-xs-6">
        <div class="footer">
          <!--<h3 class="footer-header">Customer Service</h3>-->
          <!--<ul class="list-links">-->
          <!--  <li><a href="#">Tentang</a></li>-->
          <!--  <li><a href="#">Pengiriman</a></li>-->
          <!--  <li><a href="#">Tracking Resi</a></li>-->
          <!--</ul>-->
        </div>
      </div>
      <!-- /footer widget -->

      <!-- footer subscribe -->
      <div class="col-md-3 col-sm-6 col-xs-6">
        <div class="footer">
          <h3 class="footer-header">Stay Connected</h3>
          
          <p>Follow media sosial kami untuk lebih dekat dan mendapat informasi-informasi terbaru tentang toko kami.</p>
          
          <!-- footer social -->
          <ul class="footer-social">
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
          </ul>
          <!-- /footer social -->
        </div>
      </div>
      <!-- /footer subscribe -->
    </div>
    <!-- /row -->
    <hr>
    <!-- row -->
    <div class="row">
      <div class="col-md-8 col-md-offset-2 text-center">
        <!-- footer copyright -->
        <div class="footer-copyright">
          
          Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
          
        </div>
        <!-- /footer copyright -->
      </div>
    </div>
    <!-- /row -->
  </div>
  <!-- /container -->
</footer>
<!-- /FOOTER -->

<!-- jQuery Plugins -->
<script src="<?php echo base_url() ?>frontend/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>frontend/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>frontend/js/slick.min.js"></script>
<script src="<?php echo base_url() ?>frontend/js/nouislider.min.js"></script>
<script src="<?php echo base_url() ?>frontend/js/jquery.zoom.min.js"></script>
<script src="<?php echo base_url() ?>frontend/js/main.js"></script>

</body>

<script>

  $(document).ready(function(){

    function numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $('.jumlah').on("keyup",function(){
      var nomor = $(this).attr('nomor');

      var jumlah = $(this).val();

      var harga = $("#harga_"+nomor).val();

      var total = jumlah*harga;

      var t = numberWithCommas(total);

      $("#total_"+nomor).text("Rp. "+t+" ,-");
    });
  });



  $(document).ready(function(){
    $('#provinsi').change(function(){
      var prov = $('#provinsi').val();


      var provinsi = $("#provinsi :selected").text();

      $.ajax({
        type : 'GET',
        url : '<?php echo base_url() ?>welcome/rajaongkir_cek_kabupaten',
        data :  'prov_id=' + prov,
        success: function (data) {
          $("#kabupaten").html(data);
          $("#provinsi2").val(provinsi);
          console.log(data);
        }
      });
    });

    $(document).on("change","#kabupaten",function(){

      var asal = 152;
      var kab = $('#kabupaten').val();
      var kurir = "a";
      var berat = $('#berat2').val();

      var kabupaten = $("#kabupaten :selected").text();

      $.ajax({
        type : 'POST',
        url : '<?php echo base_url() ?>welcome/rajaongkir_cek_ongkir',
        data :  {'kab_id' : kab, 'kurir' : kurir, 'asal' : asal, 'berat' : berat},
        success: function (data) {
          $("#ongkir").html(data);
          // alert(data);

          // $("#provinsi").val(prov);
          $("#kabupaten2").val(kabupaten);

        }
      });
    });

    function format_angka(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(document).on("change", '.pilih-kurir', function(event) { 
      // alert("new link clicked!");
      var kurir = $(this).attr("kurir");
      var service = $(this).attr("service");
      var ongkir = $(this).attr("harga");
      var total_bayar = $("#total_bayar").val();

      $("#kurir").val(kurir);
      $("#service").val(service);
      $("#ongkir2").val(ongkir);
      var total = parseInt(total_bayar) + parseInt(ongkir);
      $("#tampil_ongkir").text("Rp. "+ format_angka(ongkir) +" ,-");
      $("#tampil_total").text("Rp. "+ format_angka(total) +" ,-");
    });


  });
  

  var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
  (function(){
  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
  s1.async=true;
  s1.src='https://embed.tawk.to/64c5ccf4cc26a871b02c0f12/1h6iah7fn';
  s1.charset='UTF-8';
  s1.setAttribute('crossorigin','*');
  s0.parentNode.insertBefore(s1,s0);
  })();

</script>

</html>