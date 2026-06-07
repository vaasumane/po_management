<!DOCTYPE html>
<html>
<style media="screen">
.form-group {
  margin-bottom: 0.5rem !important;
}
</style>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header pt-0 pb-2">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12 text-left mt-2">
            <h4>Purchase Order</h4>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card <?php if(!isset($update)){ echo 'collapsed-card'; } ?> card-default">
              <div class="card-header">
                <h3 class="card-title"> <?php if(isset($update)){ echo 'Update'; } else{ echo 'Add New'; } ?> Purchase Order</h3>
                <div class="card-tools">
                  <?php if(!isset($update)){
                    echo '<button type="button" class="btn btn-sm btn-primary" data-card-widget="collapse">Add New</button>';
                  } else{ ?>
                    <a href="<?php echo base_url(); ?>Transaction/purchase_order" class="btn btn-xs btn-outline-secondary px-4 mx-4">Cancel Edit</a>
                  <?php } ?>
                </div>
              </div>
              <!--  -->
              <div class="card-body px-0 py-0" <?php if(isset($update)){ echo 'style="display: block;"'; } else{ echo 'style="display: none;"'; } ?>>
                <form class="input_form m-0 needs-validation" novalidate id="form_action" role="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                  <div class="row p-4">

                    <div class="form-group col-md-4 offset-md-2">
                      <label>PO Date<span class="text-danger">*</span></label>
											<div class="input-group date" id="date1" data-target-input="nearest">
												<input type="text" class="form-control form-control-sm datetimepicker-input" name="purchase_order_date" id="date1" value="<?php if(isset($purchase_order_info)){ echo $purchase_order_info['purchase_order_date']; } ?>" data-target="#date1" data-toggle="datetimepicker" required>
											</div>
                    </div>
										<div class="form-group col-md-4 select_sm">
											<label>Terms<span class="text-danger">*</span></label>
											<select class="form-control select2" name="purchase_order_term" id="purchase_order_term" data-placeholder="Select Terms" required>
                        <option value="">Select Terms</option>
												<option value="Cash" <?php if(isset($purchase_order_info) && $purchase_order_info['purchase_order_term'] == 'Cash'){ echo 'selected'; }  ?>>Cash</option>
												<option value="Credit" <?php if(isset($purchase_order_info) && $purchase_order_info['purchase_order_term'] == 'Credit'){ echo 'selected'; }  ?>>Credit</option>
                      </select>
										</div>
										<div class="form-group col-md-4 offset-md-2 select_sm">
											<label>Party<span class="text-danger">*</span></label>
											<select class="form-control select2" name="party_id" id="party_id" data-placeholder="Select Party" required>
                        <option value="">Select Party</option>
                        <?php if(isset($party_list)){ foreach ($party_list as $list) { ?>
                        <option value="<?php echo $list->party_id; ?>" <?php if(isset($purchase_order_info) && $purchase_order_info['party_id'] == $list->party_id){ echo 'selected'; } if($list->party_status == '0'){ echo ' disabled'; } ?>><?php echo $list->party_name; ?></option>
                        <?php } } ?>
                      </select>
										</div>
										<div class="form-group col-md-4">
											<label>PO No.<span class="text-danger">*</span></label>
											<input type="text" class="form-control form-control-sm" name="purchase_order_no" id="purchase_order_no" value="<?php if(isset($purchase_order_info)){ echo $purchase_order_info['purchase_order_no']; } ?>" placeholder="Enter PO No." required>
										</div>

                    <div class="form-group col-md-12">
                      <hr>
                      <div class="row">
                        <div class="col-md-6">
                          <p class="f-16"><b>Purchase Order Details</b></p>
                        </div>
                        <div class="col-md-6 text-right">
                          <button type="button" id="add_row1" class="btn btn-sm btn-info mb-3 mr-1" width="150px">Add Row</button>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12"  >
                      <style media="screen">
                        #myTable1 td{
                          padding: 0.25rem !important;
                        }
												.dropdown-menu{
													z-index:1200 !important;
												}
                      </style>
                      <div class="" >
                        <table id="myTable1" class="table table-bordered tbl_list" >
                          <thead>
                          <tr>
                            <th class="f-14 wtm_150">Drawing No</th>
                            <th class="f-14 wtm_150">Process Type</th>
                            <th class="f-14 wtm_100">Description</th>
                            <th class="f-14 wtm_100">Grade</th>
                            <th class="f-14 ">Sr. No.</th>
                            <th class="f-14 wtm_100">Due Date</th>
                            <th class="f-14 ">Casting DRG No</th>
                            <th class="f-14 ">PO Qty</th>
                            <th class="f-14 ">Add Qty</th>
                            <th class="f-14 wt_50"></th>
                          </tr>
                          </thead>
                          <tbody>
                            <?php if(isset($po_item_list)){ $i = 0; foreach ($po_item_list as $list) { 
															$item_data = $this->Master_Model->get_data('admi_item','process_type_id,grade_id',['item_id'=>$list->item_id],'`item_id` ASC','row_array');
															$process_type_list = $this->Master_Model->get_data('admi_process_type','*',['process_type_id'=>$item_data['process_type_id']],'`process_type_id` ASC','result');
															$grade_list = $this->Master_Model->get_data('admi_grade','*',['grade_id'=>$item_data['grade_id']],'`grade_id` ASC','result');
														?>														

                              <input type="hidden" name="input[<?php echo $i; ?>][po_item_id]" value="<?php echo $list->po_item_id; ?>">
                              <tr>
																<td class="select_sm wtm_150">
                                  <select class="form-control select2 form-control-sm item_id w-100" name="input[<?php echo $i; ?>][item_id]" data-placeholder="Select DRG No" required>
                                    <option value="">Select DRG No</option>
                                    <?php if(isset($item_list)){ foreach ($item_list as $item_list2) { ?>
                                    <option value="<?php echo $item_list2->item_id; ?>" <?php if($list->item_id == $item_list2->item_id){ echo ' selected'; } if($item_list2->item_status == 0){ echo ' disabled'; } ?> ><?php echo $item_list2->item_finished_drw_no; ?></option>
                                    <?php } } ?>
                                  </select>
                                </td>
																<td class="select_sm wtm_150">
                                  <select class="form-control select2 form-control-sm process_type_id w-100" name="input[<?php echo $i; ?>][process_type_id]" data-placeholder="Select Process Type" required>
                                    <option value="">Select Process Type</option>
                                    <?php if(isset($process_type_list)){ foreach ($process_type_list as $process_type_list2) { ?>
                                    <option value="<?php echo $process_type_list2->process_type_id; ?>" <?php  if($list->process_type_id == $process_type_list2->process_type_id){ echo ' selected'; } if($process_type_list2->process_type_status == 0){ echo ' disabled'; } ?> ><?php echo $process_type_list2->process_type_name; ?></option>
                                    <?php } } ?>
                                  </select>
                                </td>
                                <td class="wtm_100">
                                  <input type="text" class="form-control form-control-sm po_item_descr" name="input[<?php echo $i; ?>][po_item_descr]" value="<?= $list->po_item_descr; ?>" required>
                                </td>
																<td class="select_sm wtm_100">
                                  <select class="form-control select2 form-control-sm grade_id" name="input[<?php echo $i; ?>][grade_id]" data-placeholder="Select Grade" required>
                                    <option value="">Select Grade</option>
                                    <?php if(isset($grade_list)){ foreach ($grade_list as $grade_list2) { ?>
                                    <option value="<?php echo $grade_list2->grade_id; ?>" <?php if($list->grade_id == $grade_list2->grade_id){ echo ' selected'; } if($grade_list2->grade_status == 0){ echo ' disabled'; } ?> ><?php echo $grade_list2->grade_name; ?></option>
                                    <?php } } ?>
                                  </select>
                                </td>
                                <td class="wtm_100">
                                  <input type="text" class="form-control form-control-sm po_item_sr_no" name="input[<?php echo $i; ?>][po_item_sr_no]" value="<?= $list->po_item_sr_no; ?>" required>
                                </td>
                                <td class="wtm_100">
																	<div class="input-group date" id="po_item_due_date<?= $i; ?>" data-target-input="nearest">
																		<input type="text" class="form-control form-control-sm datetimepicker-input" name="input[<?php echo $i; ?>][po_item_due_date]" value="<?= $list->po_item_due_date; ?>" data-target="#po_item_due_date<?= $i; ?>" data-toggle="datetimepicker" required>
																	</div>
                                </td>
                                <td class="wtm_100">
                                  <input type="text" class="form-control form-control-sm po_item_casting_drg_no" name="input[<?php echo $i; ?>][po_item_casting_drg_no]" value="<?= $list->po_item_casting_drg_no; ?>" required>
                                </td>
                                <td class="">
                                  <input type="number" min="1" step="0.01" class="form-control form-control-sm po_item_qty" name="input[<?php echo $i; ?>][po_item_qty]"  value="<?= $list->po_item_qty; ?>" required>
                                </td>
                                <td class="">
                                  <input type="number" min="1" step="0.01" class="form-control form-control-sm po_item_add_qty" name="input[<?php echo $i; ?>][po_item_add_qty]" value="<?= $list->po_item_add_qty; ?>" required>
                                </td>
                                <td class="wt_50">
                                  <?php if($i > 0){ ?><a class="rem_row"><i class="fa fa-trash text-danger"></i></a><?php } ?>
                                </td>
                              </tr>
                            <?php $i++;  } } else{ ?>
                              <tr>
																<td class="select_sm wtm_150">
                                  <select class="form-control select2 form-control-sm item_id w-100" name="input[0][item_id]" data-placeholder="Select DRG No" required>
                                    <option value="">Select DRG No</option>
                                    <?php if(isset($item_list)){ foreach ($item_list as $item_list2) { ?>
                                    <option value="<?php echo $item_list2->item_id; ?>" <?php if($item_list2->item_status == 0){ echo ' disabled'; } ?> ><?php echo $item_list2->item_finished_drw_no; ?></option>
                                    <?php } } ?>
                                  </select>
                                </td>
																<td class="select_sm wtm_150">
                                  <select class="form-control select2 form-control-sm process_type_id w-100" name="input[0][process_type_id]" data-placeholder="Select Process Type" required>
                                    <option value="">Select Process Type</option>
                                    <?php if(isset($process_type_list)){ foreach ($process_type_list as $process_type_list2) { ?>
                                    <option value="<?php echo $process_type_list2->process_type_id; ?>" <?php if($process_type_list2->process_type_status == 0){ echo ' disabled'; } ?> ><?php echo $process_type_list2->process_type_name; ?></option>
                                    <?php } } ?>
                                  </select>
                                </td>
                                <td class="wtm_100">
                                  <input type="text" class="form-control form-control-sm po_item_descr" name="input[0][po_item_descr]" required>
                                </td>
																<td class="select_sm wtm_100">
                                  <select class="form-control select2 form-control-sm grade_id" name="input[0][grade_id]" data-placeholder="Select Grade" required>
                                    <option value="">Select Grade</option>
                                    <?php if(isset($grade_list)){ foreach ($grade_list as $grade_list2) { ?>
                                    <option value="<?php echo $grade_list2->grade_id; ?>" <?php if($grade_list2->grade_status == 0){ echo ' disabled'; } ?> ><?php echo $grade_list2->grade_name; ?></option>
                                    <?php } } ?>
                                  </select>
                                </td>
                                <td class="wtm_100">
                                  <input type="text" class="form-control form-control-sm po_item_sr_no" name="input[0][po_item_sr_no]" required>
                                </td>
                                <td class="wtm_100">
																	<div class="input-group date" id="date2" data-target-input="nearest">
																		<input type="text" class="form-control form-control-sm datetimepicker-input" name="input[0][po_item_due_date]" value="" data-target="#date2" data-toggle="datetimepicker" required>
																	</div>
                                </td>
                                <td class="wtm_100">
                                  <input type="text" class="form-control form-control-sm po_item_casting_drg_no" name="input[0][po_item_casting_drg_no]" required>
                                </td>
                                <td class="">
                                  <input type="number" min="1" step="0.01" class="form-control form-control-sm po_item_qty" name="input[0][po_item_qty]" required>
                                </td>
                                <td class="">
                                  <input type="number" min="1" step="0.01" class="form-control form-control-sm po_item_add_qty" name="input[0][po_item_add_qty]" required>
                                </td>
                                <td class="wt_50"></td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                      <hr>
                    </div>

                    <div class="col-md-8 offset-md-2 pr-3">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="">Notes</label>
                            <textarea class="form-control form-control-sm " rows="4" name="purchase_order_note" id="purchase_order_note" rows="6"><?php if(isset($purchase_order_info)){ echo $purchase_order_info['purchase_order_note']; } ?></textarea>
                          </div>
                        </div>

                      </div>
                    </div>
                    
                  </div>
                  <div class="card-footer clearfix" style="display: block;">
                    <div class="row">
                      <div class="col-md-6 text-left">
                        <!-- <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" name="customer_status" id="customer_status" value="0" <?php if(isset($purchase_order_info) && $purchase_order_info['customer_status'] == 0){ echo 'checked'; } ?>>
                          <label for="customer_status" class="custom-control-label">Disable This Purchase Order</label>
                        </div> -->
                      </div>
                      <div class="col-md-6 text-right">
                        <a href="<?php echo base_url(); ?>Transaction/purchase_order" class="btn btn-sm btn-default px-4 mx-4">Cancel</a>
                        <?php if(isset($update)){
                          echo '<button class="btn btn-sm btn-primary float-right px-4">Update</button>';
                        } else{
                          echo '<button class="btn btn-sm btn-success float-right px-4">Save</button>';
                        } ?>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Purchase Order List</h3>
              </div>
              <div class="card-body p-2" style="overflow-x: auto">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th class="d-none">#</th>
                    <th class="wtm_50">Action</th>
                    <th class="">Party</th>
                    <th class="wt_100">PO Number</th>
                    <th class="wt_100">PO Date</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($purchase_order_list)){
                      $m=0; foreach ($purchase_order_list as $list) { $m++;
												$party_data = $this->Master_Model->get_data('admi_party','party_name',['party_id'=>$list->party_id],'`party_id` DESC','row_array');
                        // $city_info = $this->Master_Model->get_info_arr_fields3('city_name', '', 'city_id', $list->city_id, '', '', '', '', 'city');
                    ?>
                      <tr>
                        <td class="d-none"><?php echo $m; ?></td>
                        <td class="text-center">
                          <div class="btn-group">
														<a href="<?php echo base_url() ?>Transaction/edit_purchase_order/<?php echo $list->purchase_order_id; ?>" type="button" class="btn btn-sm btn-default"><i class="fa fa-edit text-primary"></i></a>
														<a href="<?php echo base_url() ?>Transaction/delete_purchase_order/<?php echo $list->purchase_order_id; ?>" type="button" class="btn btn-sm btn-default" onclick="return confirm('Delete this Purchase Order');"><i class="fa fa-trash text-danger"></i></a>
														<!-- <a target="_blank" href="<?php echo base_url() ?>Transaction/purchase_order_print/<?php echo $list->purchase_order_id; ?>" type="button" class="btn btn-sm btn-default" ><i class="fa fa-print text-info"></i></a> -->
                          </div>
                        </td>
                        <td><?php if($party_data){ echo $party_data['party_name'];  } ?></td>
                        <td><?php echo $list->purchase_order_date; ?></td>
                        <td><?php echo $list->purchase_order_no; ?></td>
                      </tr>
                    <?php } } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Sale Status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="update_purchase_order_status" method="post">
          <div class="modal-body">
            <input type="hidden" name="purchase_order_id" id="modal_purchase_order_id2">
            <input type="hidden" name="customer_id" id="modal_customer_id2">
            <label for="">Select Status</label>
            <select class="form-control" name="purchase_order_status" id="purchase_order_status">
              <option value="1">Delivered</option>
              <option value="2">Cancelled</option>
              <option value="0">Pending</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit"  class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</body>
</html>

<script>
	// get_item_list_by_party...
	$("#party_id").on("change", function(){
    var party_id =  $('#party_id').find("option:selected").val();
    $.ajax({
      url:'<?php echo base_url(); ?>Master/get_item_list_by_party',
      type: 'POST',
      data: {"party_id":party_id},
      context: this,
      success: function(result){
        $('.item_id').html(result);
      }
    });
  });

	// get_process_type_list_by_item...
	$(document).on("change", ".item_id", function(){
    var item_id =  $(this).find("option:selected").val();
    $.ajax({
      url:'<?php echo base_url(); ?>Master/get_process_type_list_by_item',
      type: 'POST',
      data: {"item_id":item_id},
      context: this,
      success: function(result){
				$(this).closest('tr').find('.process_type_id').html(result);
				var process_type_id =  $(this).closest('tr').find('.process_type_id').val();

				var po_item_descr = $(this).closest('tr').find('.process_type_id').find("option:selected").attr('po_item_descr');
				var po_item_casting_drg_no = $(this).closest('tr').find('.process_type_id').find("option:selected").attr('po_item_casting_drg_no');

				$(this).closest('tr').find('.po_item_descr').val(po_item_descr);
				$(this).closest('tr').find('.po_item_casting_drg_no').val(po_item_casting_drg_no);
				// alert(po_item_descr);
      }
    });

		$.ajax({
      url:'<?php echo base_url(); ?>Master/get_grade_list_by_item',
      type: 'POST',
      data: {"item_id":item_id},
      context: this,
      success: function(result2){
				$('.grade_id').html(result2);
      }
    });
  });
</script>

<script>
  // Add Row...  Jewellery
  <?php if(isset($update)){ ?>
  var i = <?php echo $i-1; ?>
  <?php } else { ?>
  var i = 0;
  <?php } ?>

  $(document).on('click', '#add_row1', function(){
    i++;
    var row = ''+
    '<tr>'+
			'<td class="select_sm wtm_150">'+
				'<select class="form-control search_select1 form-control-sm item_id w-100" id="item_id_'+i+'" name="input['+i+'][item_id]" data-placeholder="Select DRG No" required>'+
					'<option value="">Select DRG No</option>'+
					'<?php if(isset($item_list)){ foreach ($item_list as $item_list2) { ?>'+
					'<option value="<?php echo $item_list2->item_id; ?>" <?php if($item_list2->item_status == 0){ echo ' disabled'; } ?> ><?php echo $item_list2->item_finished_drw_no; ?></option>'+
					'<?php } } ?>'+
				'</select>'+
			'</td>'+
			'<td class="select_sm wtm_150">'+
				'<select class="form-control search_select1 form-control-sm process_type_id w-100" name="input['+i+'][process_type_id]" data-placeholder="Select Process Type" required>'+
					'<option value="">Select Process Type</option>'+
					'<?php if(isset($process_type_list)){ foreach ($process_type_list as $process_type_list2) { ?>'+
					'<option value="<?php echo $process_type_list2->process_type_id; ?>" <?php if($process_type_list2->process_type_status == 0){ echo ' disabled'; } ?> ><?php echo $process_type_list2->process_type_name; ?></option>'+
					'<?php } } ?>'+
				'</select>'+
			'</td>'+
			'<td class="wtm_100">'+
				'<input type="text" class="form-control form-control-sm po_item_descr" name="input['+i+'][po_item_descr]" required>'+
			'</td>'+
			'<td class="select_sm wtm_100">'+
				'<select class="form-control search_select1 form-control-sm grade_id" name="input['+i+'][grade_id]" data-placeholder="Select Grade" required>'+
					'<option value="">Select Grade</option>'+
					'<?php if(isset($grade_list)){ foreach ($grade_list as $grade_list2) { ?>'+
					'<option value="<?php echo $grade_list2->grade_id; ?>" <?php if($grade_list2->grade_status == 0){ echo ' disabled'; } ?> ><?php echo $grade_list2->grade_name; ?></option>'+
					'<?php } } ?>'+
				'</select>'+
			'</td>'+
			'<td class="wtm_100">'+
				'<input type="text" class="form-control form-control-sm po_item_sr_no" name="input['+i+'][po_item_sr_no]" required>'+
			'</td>'+
			'<td class="wtm_100">'+
				'<div class="input-group date" id="po_item_due_date_'+i+'" data-target-input="nearest">'+
					'<input type="text" class="form-control form-control-sm datetimepicker-input" name="input['+i+'][po_item_due_date]" value="" data-target="#po_item_due_date_'+i+'" data-toggle="datetimepicker" required>'+
				'</div>'+
			'</td>'+
			'<td class="">'+
				'<input type="text" class="form-control form-control-sm po_item_casting_drg_no" name="input['+i+'][po_item_casting_drg_no]" required>'+
			'</td>'+
			'<td class="">'+
				'<input type="number" min="1" step="0.01" class="form-control form-control-sm po_item_qty" name="input['+i+'][po_item_qty]" required>'+
			'</td>'+
			'<td class="">'+
				'<input type="number" min="1" step="0.01" class="form-control form-control-sm po_item_add_qty" name="input['+i+'][po_item_add_qty]" required>'+
			'</td>'+
      '<td class="wt_50"><a class="rem_row"><i class="fa fa-trash text-danger"></i></a></td>'+
    '</tr>';
    $('#myTable1').append(row);
    $('.search_select1').select2();

		$('#po_item_due_date_'+i+'').datetimepicker({
			format: 'DD-MM-Y'
		});

		var party_id =  $('#party_id').find("option:selected").val();
    $.ajax({
      url:'<?php echo base_url(); ?>Master/get_item_list_by_party',
      type: 'POST',
      data: {"party_id":party_id},
      context: this,
      success: function(result){
        $('#item_id_'+i+'').html(result);
      }
    });
  });

  $('#myTable1').on('click', '.rem_row', function () {
    $(this).closest('tr').remove();
    final_calculation();
  });


	


</script>
