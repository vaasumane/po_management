<!DOCTYPE html>
<html>
<body class="sidebar-mini layout-fixed ">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" >
    <!-- Content Header (Page header) -->

    <section class="content-header pt-0 pb-2">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12 text-left mt-2">
            <h4>Report</h4>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row"> 

					<div class="col-md-12">
						<div class="card card_shadow  card-default">
							<div class="card-header">
								<h3 class="card-title"> Report</h3>
								<div class="card-tools">
								</div>
							</div>
							<!--  -->
							<div class="card-body p-0" >
								<form class="input_form m-0 needs-validation" novalidate id="form_action" role="form" action="" method="post" enctype="multipart/form-data">
									<div class="row p-4">
										<div class="form-group col-md-3 ">
											<label>From Date<span class="text-danger">*</span></label>
											<div class="input-group date" id="date1" data-target-input="nearest">
												<input type="text" class="form-control form-control-sm datetimepicker-input" name="from_date" id="from_date" value="<?php if(isset($from_date)){ echo $from_date; } ?>" data-target="#date1" data-toggle="datetimepicker"  required >
											</div>
										</div>
										<div class="form-group col-md-3 ">
											<label>To Date<span class="text-danger">*</span></label>
											<div class="input-group date" id="date2" data-target-input="nearest">
												<input type="text" class="form-control form-control-sm datetimepicker-input" name="to_date" id="to_date" value="<?php if(isset($to_date)){ echo $to_date; } ?>" data-target="#date2" data-toggle="datetimepicker"  required >
											</div>
										</div>

										<div class="form-group col-md-3 select_sm">
											<label>Customer</label>
											<select class="form-control select2" name="party_id" id="party_id" data-placeholder="Select Customer" >
                        <option value="">Select Customer</option>
												<option value="0">All</option>
                        <?php if(isset($party_list)){ foreach ($party_list as $list) { ?>
                        <option value="<?php echo $list->party_id; ?>" <?php if(isset($dispatch_info) && $dispatch_info['party_id'] == $list->party_id){ echo 'selected'; } if($list->party_status == '0'){ echo ' disabled'; } ?>><?php echo $list->party_name; ?></option>
                        <?php } } ?>
                      </select>
										</div>

										<div class="form-group col-md-3 select_sm">
											<label>Finish Drawing No</label>
											<select class="form-control select2" name="item_id" id="item_id" data-placeholder="Select Finish Drawing No" >
                        <option value="">Select Finish Drawing No</option>												
												<option value="0">All</option>
                        <?php if(isset($item_list)){ foreach ($item_list as $list) { ?>
                        <option value="<?php echo $list->item_id; ?>" <?php if(isset($dispatch_info) && $dispatch_info['item_id'] == $list->item_id){ echo 'selected'; } if($list->item_status == '0'){ echo ' disabled'; } ?>><?php echo $list->item_finished_drw_no; ?></option>
                        <?php } } ?>
                      </select>
										</div>

										<!-- <div class="form-group col-md-3 select_sm">
											<label>Grade</label>
											<select class="form-control select2" name="grade_id" id="grade_id" data-placeholder="Select Grade" >
												<option value="">Select Grade</option>
												<?php if(isset($grade_list)){ foreach ($grade_list as $list) { ?>
													<option value="<?php echo $list->grade_id; ?>" <?php if($list->grade_status == '0'){ echo ' disabled'; } ?> ><?php echo $list->grade_name; ?></option>
												<?php } } ?>
											</select>
										</div>
										<div class="form-group col-md-3 select_sm">
											<label>Process Type<span class="text-danger">*</span></label>
											<select class="form-control select2" name="process_type_id" id="process_type_id" data-placeholder="Select Process Type" required>
												<option value="">Select Process Type</option>
												<?php if(isset($process_type_list)){ foreach ($process_type_list as $list) { ?>
													<option value="<?php echo $list->process_type_id; ?>" <?php if($list->process_type_status == '0'){ echo ' disabled'; } ?> ><?php echo $list->process_type_name; ?></option>
												<?php } } ?>
											</select>
										</div> -->

									</div>
									<div class="card-footer clearfix" style="display: block;">
										<div class="row">
											<div class="col-md-6 text-left">
											</div>
											<div class="col-md-6 text-right">
												<a href="<?= base_url(); ?>Transaction/receipt_list" class="btn btn-sm btn-default px-4 mx-4">Cancel</a>
												<button class="btn btn-sm btn-success float-right px-4">Submit</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
          
				<?php if(isset($report)){ ?>
					<div class="col-md-12 ">
						<div class="card card-info card_shadow">
							<div class="card-header">
								<h3 class="card-title"> <i class="fa fa-list"></i> Report List</h3>
							</div>
							<div class="card-body p-2">

							<?php 
							// print_r($report_list);
							// echo '<br><br>';
							$cnt = 0;
							foreach($report_list as $report_list1){
								// print_r($report_list[$cnt]['po_report_list']);
								$po_report_list = $report_list[$cnt]['po_report_list'];
								$process_type_id = $report_list[$cnt]['process_type_id'];
								$process_type_name = $report_list[$cnt]['process_type_name'];
								if($po_report_list){
							?>								
								<div class="overflow_x_auto">
									<h5>Process Type - <?= $process_type_name; ?></h5>
									<table id="exp_tbl_<?= $cnt; ?>" class="table table-bordered table-striped w-100">
										<thead>
											<tr>
												<th>Cust. name</th>
												<th class="wt_100">PO No.</th>
												<th class="wt_100">Sr. No.</th>
												<th class="wt_100">PO Date</th>
												<th class="wt_100">Due Date</th>
												<th class="wt_100">Process Type</th>
												<th class="wt_100">Discription</th>
												<th class="wt_100">Casting DRG No</th>
												<th class="wt_100">Finish DRG No</th>
												<th class="wt_100">Material/Grade</th>
												<th class="wt_100">PO Qty</th>
												<th class="wt_100">Disp Qty</th>
												<th class="wt_100">Pen. Qty</th>

												<?php 
													$department_list = $this->Master_Model->get_data('admi_department','department_id,department_name',['process_type_id'=>$process_type_id],'`department_id` ASC','result');
													foreach($department_list as $department_list1){
												?>
													<th class="wt_100"><?= $department_list1->department_name ?></th>
												<?php	} ?>
											</tr>
										</thead>
										<tbody>

											<?php $i=0; foreach($po_report_list as $list){ $i++; 
												$purchase_order_id = $list->purchase_order_id;
												$item_id = $list->item_id;

												$po_item_id = $list->po_item_id;
												$party_id = $list->party_id;

												$dispatch_qty = 0;
												$dispatch_qty_info = $this->Master_Model->get_data('admi_dispatch_item','SUM(dispatch_item_qty) as dispatch_qty',['purchase_order_id'=>$purchase_order_id, 'item_id'=>$item_id],'`item_id` ASC','row_array');
												if($dispatch_qty_info && $dispatch_qty_info['dispatch_qty']){ $dispatch_qty = $dispatch_qty_info['dispatch_qty'];  }

												$job_item_id = 0;
												$job_item_info = $this->Master_Model->get_data('admi_job_item','*',['po_item_id'=>$po_item_id, 'item_id'=>$item_id, 'party_id'=>$party_id],'`po_item_id` ASC','row_array');
												if($job_item_info){ $job_item_id = $job_item_info['job_item_id']; }
											?>
												<tr>
													<td><?php echo $list->party_name; ?></td>
													<td><?php echo $list->purchase_order_no; ?></td>
													<td><?php echo $list->po_item_sr_no; ?></td>
													<td><?php echo $list->purchase_order_date; ?></td>
													<td><?php echo $list->po_item_due_date; ?></td>
													<td><?php echo $list->process_type_name; ?></td>
													<td><?php echo $list->po_item_descr; ?></td>
													<td><?php echo $list->item_casting_drw_no; ?></td>
													<td><?php echo $list->item_finished_drw_no; ?></td>
													<td><?php echo $list->grade_name; ?></td>
													<td><?php echo $list->po_item_qty; ?></td>
													<td><?php echo $dispatch_qty; ?></td>
													<td><?php echo $list->po_item_qty - $dispatch_qty; ?></td>
													<?php 
														$department_list = $this->Master_Model->get_data('admi_department','department_id,department_name',['process_type_id'=>$process_type_id],'`department_id` ASC','result');
														foreach($department_list as $department_list2){
															$department_id = $department_list2->department_id;

															$tot_added_qty = 0;
															$tot_used_qty = 0;

															$tot_added = $this->Master_Model->get_data('admi_dep_qty','SUM(dep_qty) as tot_added_qty',['department_id'=>$department_id,'item_id'=>$item_id,'job_item_id'=>$job_item_id,'dep_qty_entry_type'=>'1'],'`dep_qty_id` ASC','row_array');
															$tot_used = $this->Master_Model->get_data('admi_dep_qty','SUM(dep_qty) as tot_used_qty',['department_id'=>$department_id,'item_id'=>$item_id,'job_item_id'=>$job_item_id,'dep_qty_entry_type'=>'2'],'`dep_qty_id` ASC','row_array');

															if($tot_added && $tot_added['tot_added_qty'] > 0){ $tot_added_qty = $tot_added['tot_added_qty']; }
															if($tot_used && $tot_used['tot_used_qty'] > 0){ $tot_used_qty = $tot_used['tot_used_qty']; }

															$tot_balance_qty = $tot_added_qty - $tot_used_qty;
													?>
														<td class="wt_100"><?= $tot_balance_qty; ?></td>
													<?php	} ?>
												</tr>
											<?php }  ?>

										</tbody>
									</table>
									<button name="export" id="export_excel_<?= $cnt; ?>" onclick="Export_<?= $cnt; ?>()" class="btn btn-sm btn-info my-4 " >Export to Excel</button>				
									
									<hr>
								
								</div>
							<?php }	$cnt++; } ?>
							</div>
						</div>						
					</div>
				<?php } ?>

			</div>
		</div>
	</section>
</div>	

</body>
</html>

<script src="<?php echo base_url(); ?>assets/js/table2excel.js"></script>
<?php if(isset($report_list)){ $src = 0; foreach($report_list as $report_list1){ ?>
	<script>
		function Export_<?= $src; ?>() {		
			$("#exp_tbl_<?= $src; ?>").table2excel({
				filename: "Report_<?php echo date('dmy_His'); ?>.xls"
			});
		}
	</script>
<?php $src++; } } ?>

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
        $('#item_id').html(result);
      }
    });
  });

	$(document).on("change", "#item_id,#party_id", function(){
    var item_id =  $('#item_id').find("option:selected").val();
    $.ajax({
      url:'<?php echo base_url(); ?>Master/get_process_type_list_by_item',
      type: 'POST',
      data: {"item_id":item_id},
      context: this,
      success: function(result){
				$('#process_type_id').html(result);
      }
    });
  });
</script>


