	<footer class="main-footer">
		<div class="pull-right hidden-xs">
			<b>B-One</b> Computer
		</div>
		<strong>Website Toko B-One Computer</strong> . All rights reserved.
	</footer>
</div>

<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script>
	$.widget.bridge('uibutton', $.ui.button);
</script>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/morris.js/morris.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script>

<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/pages/chart.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
<script src="<?php echo base_url() ?>assets/bower_components/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url() ?>assets/bower_components/chart.js/Chart.min.js"></script>
<script>
	$(function () {
		CKEDITOR.replace('editor')
	});
</script>


<script>
	$(document).ready(function(){

		
		$('#table-datatable').DataTable({
			'paging'      : true,
			'lengthChange': false,
			'searching'   : true,
			'ordering'    : false,
			'info'        : true,
			'autoWidth'   : true,
			"pageLength": 50
		});



	});

	$('#datepicker').datepicker({
		autoclose: true,
		format: 'dd/mm/yyyy',
	}).datepicker("setDate", new Date());

	$('.datepicker2').datepicker({
		autoclose: true,
		format: 'yyyy/mm/dd',
	});


	$(document).ready(function(){
		$("#pesan_pilih_tujuan").on("change",function(){
			var pilih = $(this).val();
			var data = "tujuan="+pilih;
			if(pilih.length > 0){
				$.ajax({
					url: "pesan_ajax_pilih_tujuan.php",
					method: "POST", 
					data:data,
					success: function(result){
						$(".tampil_tujuan").html(result);
					}});
			}

		});
	});




</script>

<script src="<?php echo base_url() ?>assets/canvasjs/js/canvasjs.min.js"></script>
<script type="text/javascript">
                        window.onload = function (){
                    
                            var chart1 = new CanvasJS.Chart("data_peminjaman",{
                                theme: "light1",
                                animationEnabled: true,
                                title:{
                                    text: "Jumlah Pepenjualan"

                                },
                                axisY:[{
                               title: "Jumlah Penjualan",       
                              }],
                                data: [
                                {
                                    type: "column",
                                    dataPoints: 
                                   
                                   <?=json_encode($data_pinjam,JSON_NUMERIC_CHECK);?>
                                    
                                }
                                ]
                            });
                            chart1.render();
                        }
                    </script>
</body>
</html>
