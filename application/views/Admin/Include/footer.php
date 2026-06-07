	<?php
		$company_info = $this->Master_Model->get_info_arr_fields('company_name, company_shortname, company_fevicon','company_id', $sess_user_data['company_id'], 'company');
	?>

	<footer class="main-footer f-14">
		<strong>Copyright &copy;<?php echo date('Y'); ?>-<?php echo date('Y')+1; ?> <a href="<?php echo base_url(); ?>"><?php echo $company_info[0]['company_name']; ?></a>.</strong>
		All rights reserved.
		<div class="float-right d-none d-sm-inline-block">
			<b>Version</b> 1.0
		</div>
	</footer>
</div>
<!-- ./wrapper -->

<!-- Loader Modal -->
<div class="modal fade" id="loader_form_submit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document" style="height:100vh !important;">
		<div class="loader m-auto"></div> 
	</div>
</div>


<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url(); ?>assets_lte/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets_lte/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets_lte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets_lte/dist/js/adminlte.js"></script>
<!-- Bootstrap Switch -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets_lte/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- Button datatable -->
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/summernote/summernote-bs4.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?php echo base_url(); ?>assets_lte/dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets_lte/dist/js/demo.js"></script>
<!-- sweetalert & toster -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets_lte/plugins/toastr/toastr.min.js"></script>
<!-- Manual Validation -->
<script src="<?php echo base_url(); ?>assets/js/my_validation.js"></script>





<!-- page script -->

<!--**************** Form Field Required Validation  **********************-->
<script>
	(function() {
		'use strict';
		window.addEventListener('load', function() {
			var forms = document.getElementsByClassName('needs-validation');
			var validation = Array.prototype.filter.call(forms, function(form) {
				form.addEventListener('submit', function(event) {
					if (form.checkValidity() === false) {
						event.preventDefault();
						event.stopPropagation();
						toastr.error('*Fields Required');
					} else{
						$('#loader_form_submit').modal({backdrop: 'static', keyboard: false});
					}
					form.classList.add('was-validated');
				}, false);
			});
		}, false);
	})();
</script>



<!-- Toast Msg -->
<script type="text/javascript">
  // Msg After Redirect...
  <?php if($this->session->flashdata('flash_msg')){ ?>
    $(document).ready(function(){
      toastr.<?= $this->session->flashdata('class'); ?>('<?= $this->session->flashdata('flash_msg'); ?>');
    });
  <?php } ?>
  // Only Msg...
  <?php if($this->session->flashdata('flash_msg1')){ ?>
    $(document).ready(function(){
      toastr.<?= $this->session->flashdata('flash_class1'); ?>('<?= $this->session->flashdata('flash_msg1'); ?>');
    });
  <?php } ?>
  <?php if($this->session->flashdata('flash_msg2')){ ?>
    $(document).ready(function(){
      toastr.<?= $this->session->flashdata('flash_class2'); ?>('<?= $this->session->flashdata('flash_msg2'); ?>');
    });
  <?php } ?>
  <?php if($this->session->flashdata('flash_msg3')){ ?>
    $(document).ready(function(){
      toastr.<?= $this->session->flashdata('flash_class3'); ?>('<?= $this->session->flashdata('flash_msg3'); ?>');
    });
  <?php } ?>
</script>

<!-- DateTime Picker -->
<script type="text/javascript">
  // DatePicker...
  $('#date1').datetimepicker({
    format: 'DD-MM-Y'
  });
  $('#date2').datetimepicker({
    format: 'DD-MM-Y'
  });
  $('#date3').datetimepicker({
    format: 'DD-MM-Y'
  })
  $('#date4').datetimepicker({
    format: 'DD-MM-Y'
  })
  $('#date5').datetimepicker({
    format: 'DD-MM-Y'
  })
  $('#date6').datetimepicker({
    format: 'DD-MM-Y'
  })
  $('#date7').datetimepicker({
    format: 'DD-MM-Y'
  })
  $('#date8').datetimepicker({
    format: 'DD-MM-Y'
  })
  $('#date9').datetimepicker({
    format: 'DD-MM-Y'
  })
  $('#date10').datetimepicker({
    format: 'DD-MM-Y'
  })

	$('#po_item_due_date0').datetimepicker({
		format: 'DD-MM-Y'
	});
	$('#po_item_due_date1').datetimepicker({
		format: 'DD-MM-Y'
	});
	$('#po_item_due_date2').datetimepicker({
		format: 'DD-MM-Y'
	});
	$('#po_item_due_date3').datetimepicker({
		format: 'DD-MM-Y'
	});
	$('#po_item_due_date4').datetimepicker({
		format: 'DD-MM-Y'
	});
	$('#po_item_due_date5').datetimepicker({
		format: 'DD-MM-Y'
	});
	$('#po_item_due_date6').datetimepicker({
		format: 'DD-MM-Y'
	});
	$('#po_item_due_date7').datetimepicker({
		format: 'DD-MM-Y'
	});
	$('#po_item_due_date8').datetimepicker({
		format: 'DD-MM-Y'
	});
	$('#po_item_due_date9').datetimepicker({
		format: 'DD-MM-Y'
	});
	$('#po_item_due_date10').datetimepicker({
		format: 'DD-MM-Y'
	});
	$('#po_item_due_date11').datetimepicker({
		format: 'DD-MM-Y'
	});
	$('#po_item_due_date12').datetimepicker({
		format: 'DD-MM-Y'
	});

  //Timepicker
  $('#time1').datetimepicker({
    format: 'LT'
  });
  $('#time2').datetimepicker({
    format: 'LT'
  });
  $('#time3').datetimepicker({
    format: 'LT'
  });
  $('#time4').datetimepicker({
    format: 'LT'
  });
  $('#time5').datetimepicker({
    format: 'LT'
  });
  $('#time6').datetimepicker({
    format: 'LT'
  });

// DateTimePicker
  $('#datetime1').datetimepicker({
    format: 'DD-MM-Y LT'
  });
  $('#datetime2').datetimepicker({
    format: 'DD-MM-Y LT'
  });
  $('#datetime3').datetimepicker({
    format: 'DD-MM-Y LT'
  });
  $('#datetime4').datetimepicker({
    format: 'DD-MM-Y LT'
  });
  $('#datetime5').datetimepicker({
    format: 'DD-MM-Y LT'
  });

	// Toottip
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});
</script>

<!-- DataTable -->
<script>
  $(function () {
		// Button DataTable
    var time = '<?php echo  date('YmdHis'); ?>';
    $('#datatable_btn1').DataTable( {
        dom: 'lfrtBip',
        buttons: [
          {
            extend: 'pdf',
            className: 'btn btn-secondary btn-sm',
            exportOptions: {
              columns: [ 2, 3, 4, 5 ]
            },
            title: 'UserList_'+time
        },
        {
          extend: 'excel',
          className: 'btn btn-secondary btn-sm',
          exportOptions: {
            columns: [ 2, 3, 4, 5 ]
          },
          title: 'UserList_'+time
        },
        {
          extend: 'csv',
          className: 'btn btn-secondary btn-sm',
          exportOptions: {
            columns: [ 2, 3, 4, 5 ]
          },
          title: 'UserList_'+time
        },
        {
          extend: 'print',
          className: 'btn btn-secondary btn-sm',
          exportOptions: {
            columns: [ 2, 3, 4, 5 ]
          },
          title: 'UserList_'+time
        }
      ],
      initComplete: function () {
        var btns = $('.dt-button');
        var datatable_btn1_wrapper = $('#datatable_btn1_wrapper');
        btns.removeClass('dt-button');
        datatable_btn1_wrapper.addClass('row p-2');
        datatable_btn1_wrapper.find('#datatable_btn1_length').addClass('col-12 col-md-6');
        datatable_btn1_wrapper.find('.dt-buttons').addClass('col-12 col-md-4 pt-2');
        datatable_btn1_wrapper.find('#datatable_btn1_filter').addClass('col-12 col-md-6');
        datatable_btn1_wrapper.find('#datatable_btn1_info').addClass('col-12 col-md-4 text-center');
        datatable_btn1_wrapper.find('#datatable_btn1_paginate').addClass('col-12 col-md-4');
      }
        // buttons: [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ],
    } );

		// DataTable...
    $("#example1").DataTable();
    $("#example2").DataTable();
    $("#example3").DataTable();
    $("#example4").DataTable();
    $("#example5").DataTable();
    $('#example6').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>

<!-- Select -->
<script>
  $(function () {
    // Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });
    //Initialize Select2 Elements
    $('.select2').select2();
    // $('.search_select1').select2();
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox();
  });
</script>

<!-- Textarea... -->
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  });
</script>

<!-- Menu Active -->
<!-- <script type="text/javascript">
  $(document).ready(function() {
    var url = window.location.href;
    var activePage = url;
    $('.nav-link').removeClass('active');
    $('.has-treeview').removeClass('menu-open');
    $('.nav-treeview').css("display", "none");
    $('.nav-link').each(function () {
      var linkPage = this.href;
      if (activePage == linkPage) {
        $(this).closest(".nav-link").addClass("active");
        $(this).closest(".has-treeview").addClass("menu-open");
        $(this).closest(".has-treeview").find(".nav-treeview").css("display", "block");
        $(this).closest(".has-treeview").find(".head").addClass("active");
      }
    });
  });
</script> -->