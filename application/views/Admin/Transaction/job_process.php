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
            <h4>Job Process Issue</h4>
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
                <h3 class="card-title"> <?php if(isset($update)){ echo 'Update'; } else{ echo 'Add New'; } ?> Job Process Issue</h3>
                <div class="card-tools">
                  <?php if(!isset($update)){
                    echo '<button type="button" class="btn btn-sm btn-primary" data-card-widget="collapse">Add New</button>';
                  } else{ ?>
                    <a href="<?php echo base_url(); ?>Transaction/job_process" class="btn btn-xs btn-outline-secondary px-4 mx-4">Cancel Edit</a>
                  <?php } ?>
                </div>
              </div>
              <!--  -->
              <div class="card-body px-0 py-0" <?php if(isset($update)){ echo 'style="display: block;"'; } else{ echo 'style="display: none;"'; } ?>>
                <form class="input_form m-0 needs-validation" novalidate id="form_action" role="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="tran_type" id="tran_type" value="1">
                  <div class="row p-4">

                    <div class="form-group col-md-4 offset-md-2">
                      <label>Date<span class="text-danger">*</span></label>
											<div class="input-group date" id="date1" data-target-input="nearest">
												<input type="text" class="form-control form-control-sm datetimepicker-input" name="job_process_date" id="date1" value="<?php if(isset($job_process_info)){ echo $job_process_info['job_process_date']; } ?>" data-target="#date1" data-toggle="datetimepicker" required>
											</div>
                    </div>
										<div class="form-group col-md-4">
											<label>VCH No.<span class="text-danger">*</span></label>
											<input type="text" class="form-control form-control-sm" name="job_process_no" id="job_process_no" value="<?php if(isset($job_process_info)){ echo $job_process_info['job_process_no']; } else{ echo $job_process_no; } ?>" placeholder="Enter VCH No." readonly required>
										</div>

										<div class="form-group col-md-4 offset-md-2 select_sm">
											<label>Customer<span class="text-danger">*</span></label>
											<select class="form-control select2" name="party_id" id="party_id" data-placeholder="Select Customer" required>
                        <option value="">Select Customer</option>
                        <?php if(isset($party_list)){ foreach ($party_list as $list) { ?>
                        <option value="<?php echo $list->party_id; ?>" <?php if(isset($job_process_info) && $job_process_info['party_id'] == $list->party_id){ echo 'selected'; } if($list->party_status == '0'){ echo ' disabled'; } ?>><?php echo $list->party_name; ?></option>
                        <?php } } ?>
                      </select>
										</div>
										<div class="form-group col-md-4 select_sm">
											<label>Finish Drawing No<span class="text-danger">*</span></label>
											<select class="form-control select2" name="item_id" id="item_id" data-placeholder="Select Finish Drawing No" required>
                        <option value="">Select Finish Drawing No</option>
                        <?php if(isset($item_list)){ foreach ($item_list as $list) { ?>
                        <option value="<?php echo $list->item_id; ?>" <?php if(isset($job_process_info) && $job_process_info['item_id'] == $list->item_id){ echo 'selected'; } if($list->item_status == '0'){ echo ' disabled'; } ?>><?php echo $list->item_finished_drw_no; ?></option>
                        <?php } } ?>
                      </select>
										</div>

                    <div class="form-group col-md-12">
                      <hr>
                      <div class="row">
                        <div class="col-md-6">
                          <p class="f-16"><b>Job Process Issue Details</b></p>
                        </div>
                        <div class="col-md-6 text-right">
                          <!-- <button type="button" id="add_row1" class="btn btn-sm btn-info mb-3 mr-1" width="150px">Add Row</button> -->
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
                          <!-- <thead>
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
                          </thead> -->
                          <tbody>
                            <?php if(isset($job_item_list)){ $i = 0; foreach ($job_item_list as $list) { ?>
															<input type="hidden" name="input[<?php echo $i; ?>][job_item_id]" value="<?php echo $list->job_item_id; ?>">
															<tr>
																<input type="hidden" class="job_item_id" value="<?php echo $list->job_item_id; ?>">
																
																<td class="">
																	<div class="row">
																		<?php
																			$item_id = $job_process_info['item_id'];
																			$party_id = $job_process_info['party_id'];																	
																			$po_item_list = $this->Master_Model->get_data('admi_po_item','*',['item_id'=>$item_id, 'party_id'=>$party_id ],'`po_item_id` ASC','result');																			
																		?>
																		<div class="form-group col-md-3 select_sm">
																			<label>PO No.<span class="text-danger">*</span></label>
																			<select class="form-control select2 form-control-sm w-100 po_item_id" name="input[<?php echo $i; ?>][po_item_id]" data-placeholder="Select PO No." required>
																				<option value="">Select PO No.</option>
																				<?php if(isset($po_item_list)){ foreach ($po_item_list as $po_item_list2) {
																					$purchase_order_id = $po_item_list2->purchase_order_id;
																					$purchase_order_data = $this->Master_Model->get_data('admi_purchase_order','purchase_order_no',['purchase_order_id'=>$purchase_order_id],'`purchase_order_id` ASC','row_array');
																				?>
																				<option value="<?= $po_item_list2->po_item_id; ?>" <?php if($po_item_list2->po_item_id == $list->po_item_id){ echo ' selected'; } if($po_item_list2->po_item_status == 0){ echo ' disabled'; } ?> ><?= $purchase_order_data['purchase_order_no']; ?></option>
																				<?php } } ?>
																			</select>
																		</div>
																		<div class="form-group col-md-2">
																			<label>Sr. No.<span class="text-danger">*</span></label>
																			<input type="text" class="form-control form-control-sm job_item_sr_no" name="input[<?php echo $i; ?>][job_item_sr_no]" value="<?= $list->job_item_sr_no ?>" readonly required>
																		</div>
																		<div class="form-group col-md-2">
																			<label>PO. Date.<span class="text-danger">*</span></label>
																			<div class="input-group date" id="date2" data-target-input="nearest">
																				<input type="text" class="form-control form-control-sm datetimepicker-input job_item_po_date" name="input[<?php echo $i; ?>][job_item_po_date]" value="<?= $list->job_item_po_date ?>" data-target="#date2" data-toggle="datetimepicker" readonly required>
																			</div>
																		</div>
																		<div class="form-group col-md-2">
																			<label>Due Date.<span class="text-danger">*</span></label>
																			<div class="input-group date" id="date3" data-target-input="nearest">
																				<input type="text" class="form-control form-control-sm datetimepicker-input job_item_due_date" name="input[<?php echo $i; ?>][job_item_due_date]" value="<?= $list->job_item_due_date ?>" data-target="#date3" data-toggle="datetimepicker" readonly required>
																			</div>
																		</div>
																		<div class="form-group col-md-3 select_sm">
																			<label>Grade<span class="text-danger">*</span></label>
																			<select class="form-control select2 form-control-sm w-100 grade_id" name="input[<?php echo $i; ?>][grade_id]" data-placeholder="Select Grade" required>
																				<option value="">Select Grade</option>
																				<?php if(isset($grade_list)){ foreach ($grade_list as $grade_list2) { ?>
																				<option value="<?php echo $grade_list2->grade_id; ?>" <?php if($grade_list2->grade_id == $list->grade_id){ echo ' selected'; } if($grade_list2->grade_status == 0){ echo ' disabled'; } ?> ><?php echo $grade_list2->grade_name; ?></option>
																				<?php } } ?>
																			</select>
																		</div>
																		<div class="form-group col-md-3">
																			<label>PO Qty<span class="text-danger">*</span></label>
																			<input type="text" class="form-control form-control-sm job_item_po_qty" name="input[<?php echo $i; ?>][job_item_po_qty]" value="<?= $list->job_item_po_qty; ?>" readonly required>
																			<input type="hidden" class="form-control form-control-sm job_item_po_add_qty" name="input[<?php echo $i; ?>][job_item_po_add_qty]" value="<?= $list->job_item_po_add_qty; ?>" >
																		</div>
																		<div class="form-group col-md-3 select_sm">
																			
																			<?php 
																				$item_data = $this->Master_Model->get_data('admi_item','process_type_id',['item_id'=>$job_process_info['item_id']],'`item_id` ASC','row_array');
																				$process_type_list = $this->Master_Model->get_data('admi_process_type','*',['process_type_id'=>$item_data['process_type_id']],'`process_type_id` ASC','result');
																			?>		
																			<label>Process Type<span class="text-danger">*</span></label>
																			<select class="form-control select2 form-control-sm w-100 process_type_id" name="input[<?php echo $i; ?>][process_type_id]" data-placeholder="Select Process Type" required>
																				<option value="">Select Process Type</option>
																				<?php if(isset($process_type_list)){ foreach ($process_type_list as $process_type_list2) { ?>
																				<option value="<?php echo $process_type_list2->process_type_id; ?>" <?php if($process_type_list2->process_type_id == $list->process_type_id){ echo ' selected'; } if($process_type_list2->process_type_status == 0){ echo ' disabled'; } ?> ><?php echo $process_type_list2->process_type_name; ?></option>
																				<?php } } ?>
																			</select>
																		</div>
																		<div class="form-group col-md-3 select_sm">	
																			<?php $department_list = $this->Master_Model->get_data('admi_department','*',['process_type_id'=>$list->process_type_id],'`department_id` ASC','result'); ?>																	

																			<label>Current Department<span class="text-danger">*</span></label>
																			<select class="form-control select2 form-control-sm w-100 department_id" name="input[<?php echo $i; ?>][department_id]" data-placeholder="Select Department" required>
																				<option value="">Select Department</option>
																				<?php if(isset($department_list)){ foreach ($department_list as $department_list2) { ?>
																				<option value="<?php echo $department_list2->department_id; ?>" <?php if($department_list2->department_id == $list->department_id){ echo ' selected'; } if($department_list2->department_status == 0){ echo ' disabled'; } ?> ><?php echo $department_list2->department_name; ?></option>
																				<?php } } ?>
																			</select>
																		</div>
																		<div class="form-group col-md-3">
																			<!-- <label>Total Qty<span class="text-danger">*</span></label>
																			<input type="text" class="form-control form-control-sm job_item_total_qty" name="input[<?php echo $i; ?>][job_item_total_qty]" value="<?= $list->job_item_total_qty; ?>" readonly required> -->
																		</div>
																		<div class="form-group col-md-3"></div>

																		<div class="form-group col-md-3 ">
																			<label>OK Qty<span class="text-danger">*</span></label>
																			<input type="text" class="form-control form-control-sm job_item_ok_qty" name="input[<?php echo $i; ?>][job_item_ok_qty]" value="<?= $list->job_item_ok_qty; ?>" required>
																		</div>
																		<div class="form-group col-md-3 select_sm">
																			<label>Next Department<span class="text-danger">*</span></label>
																			<select class="form-control select2 form-control-sm w-100 ok_department_id" name="input[<?php echo $i; ?>][ok_department_id]" data-placeholder="Select Department" required>
																				<option value="">Select Department</option>
																				<?php if(isset($department_list)){ foreach ($department_list as $department_list2) { ?>
																				<option value="<?php echo $department_list2->department_id; ?>" <?php if($department_list2->department_id == $list->ok_department_id){ echo ' selected'; } if($department_list2->department_status == 0){ echo ' disabled'; } ?> ><?php echo $department_list2->department_name; ?></option>
																				<?php } } ?>
																			</select>
																		</div>
																		<div class="form-group col-md-3"></div>

																		<!-- <div class="form-group col-md-3 offset-md-3">
																			<label>Rejected Qty</label>
																			<input type="text" class="form-control form-control-sm job_item_reject_qty" name="input[<?php echo $i; ?>][job_item_reject_qty]" value="<?= $list->job_item_reject_qty; ?>" >
																		</div>
																		<div class="form-group col-md-3 select_sm">
																			<label>Department</label>
																			<select class="form-control select2 form-control-sm w-100 rejected_department_id" name="input[<?php echo $i; ?>][rejected_department_id]" data-placeholder="Select Department" >
																				<option value="">Select Department</option>
																				<?php if(isset($department_list)){ foreach ($department_list as $department_list2) { ?>
																				<option value="<?php echo $department_list2->department_id; ?>" <?php if($department_list2->department_id == $list->rejected_department_id){ echo ' selected'; } if($department_list2->department_status == 0){ echo ' disabled'; } ?> ><?php echo $department_list2->department_name; ?></option>
																				<?php } } ?>
																			</select>
																		</div> -->
																		<div class="form-group col-md-3"></div>

																		<!-- <div class="form-group col-md-3 offset-md-3">
																			<label>Rework Qty</label>
																			<input type="text" class="form-control form-control-sm job_item_rework_qty" name="input[<?php echo $i; ?>][job_item_rework_qty]" value="<?= $list->job_item_rework_qty; ?>" >
																		</div> -->
																		<!-- <div class="form-group col-md-3 select_sm">
																			<label>Department</label>
																			<select class="form-control select2 form-control-sm w-100 rework_department_id" name="input[<?php echo $i; ?>][rework_department_id]" data-placeholder="Select Department" >
																				<option value="">Select Department</option>
																				<?php if(isset($department_list)){ foreach ($department_list as $department_list2) { ?>
																				<option value="<?php echo $department_list2->department_id; ?>" <?php if($department_list2->department_id == $list->rework_department_id){ echo ' selected'; } if($department_list2->department_status == 0){ echo ' disabled'; } ?> ><?php echo $department_list2->department_name; ?></option>
																				<?php } } ?>
																			</select>
																		</div> -->
																		<!-- <div class="form-group col-md-3"></div> -->

																		<div class="form-group col-md-3 offset-md-3">
																			<label>Pending Qty<span class="text-danger">*</span></label>
																			<input type="text" class="form-control form-control-sm job_item_pending_qty" name="input[<?php echo $i; ?>][job_item_pending_qty]" value="<?= $list->job_item_pending_qty; ?>" required readonly>
																		</div>
																		<?php if($i > 0){ ?>
																			<div class="form-group col-md-3 pt-2">
																				<a class="rem_row"><i class="fa fa-trash text-danger f-20"></i></a>
																			</div>
																		<?php } ?>
																	</div>
                                </td>
                              </tr>
                            <?php $i++;  } } else{ ?>
                              <tr>
																<td class="">
																	<div class="row">
																		<div class="form-group col-md-3 select_sm">
																			<label>PO No.<span class="text-danger">*</span></label>
																			<select class="form-control select2 form-control-sm w-100 po_item_id" name="input[0][po_item_id]" data-placeholder="Select PO No." required>
																				<option value="">Select PO No.</option>
																				<?php if(isset($po_item_list)){ foreach ($po_item_list as $po_item_list2) { ?>
																				<option value="<?php echo $po_item_list2->po_item_id; ?>" <?php if($po_item_list2->po_item_status == 0){ echo ' disabled'; } ?> ><?php echo $po_item_list2->po_item_no; ?></option>
																				<?php } } ?>
																			</select>
																		</div>
																		<div class="form-group col-md-2">
																			<label>Sr. No.<span class="text-danger">*</span></label>
																			<input type="text" class="form-control form-control-sm job_item_sr_no" name="input[0][job_item_sr_no]" readonly required>
																		</div>
																		<div class="form-group col-md-2">
																			<label>PO. Date.<span class="text-danger">*</span></label>
																			<div class="input-group date" id="date2" data-target-input="nearest">
																				<input type="text" class="form-control form-control-sm datetimepicker-input job_item_po_date" name="input[0][job_item_po_date]" value="" data-target="#date2" data-toggle="datetimepicker" readonly required>
																			</div>
																		</div>
																		<div class="form-group col-md-2">
																			<label>Due Date.<span class="text-danger">*</span></label>
																			<div class="input-group date" id="date3" data-target-input="nearest">
																				<input type="text" class="form-control form-control-sm datetimepicker-input job_item_due_date" name="input[0][job_item_due_date]" value="" data-target="#date3" data-toggle="datetimepicker" readonly required>
																			</div>
																		</div>
																		<div class="form-group col-md-3 select_sm">
																			<label>Grade<span class="text-danger">*</span></label>
																			<select class="form-control select2 form-control-sm w-100 grade_id" name="input[0][grade_id]" data-placeholder="Select Grade" required>
																				<option value="">Select Grade</option>
																				<?php if(isset($grade_list)){ foreach ($grade_list as $grade_list2) { ?>
																				<option value="<?php echo $grade_list2->grade_id; ?>" <?php if($grade_list2->grade_status == 0){ echo ' disabled'; } ?> ><?php echo $grade_list2->grade_name; ?></option>
																				<?php } } ?>
																			</select>
																		</div>
																		<div class="form-group col-md-3">
																			<label>PO Qty<span class="text-danger">*</span></label>
																			<input type="text" class="form-control form-control-sm job_item_po_qty" name="input[0][job_item_po_qty]" readonly required>
																			<input type="hidden" class="form-control form-control-sm job_item_po_add_qty" name="input[0][job_item_po_add_qty]" >
																		</div>
																		<div class="form-group col-md-3 select_sm">
																			<label>Process Type<span class="text-danger">*</span></label>
																			<select class="form-control select2 form-control-sm w-100 process_type_id" name="input[0][process_type_id]" data-placeholder="Select Process Type" required>
																				<option value="">Select Process Type</option>
																				<?php if(isset($process_type_list)){ foreach ($process_type_list as $process_type_list2) { ?>
																				<option value="<?php echo $process_type_list2->process_type_id; ?>" <?php if($process_type_list2->process_type_status == 0){ echo ' disabled'; } ?> ><?php echo $process_type_list2->process_type_name; ?></option>
																				<?php } } ?>
																			</select>
																		</div>
																		<div class="form-group col-md-3 select_sm">
																			<label>Currenct Department<span class="text-danger">*</span></label>
																			<select class="form-control select2 form-control-sm w-100 department_id" name="input[0][department_id]" data-placeholder="Select Department" required>
																				<option value="">Select Department</option>
																				<?php if(isset($department_list)){ foreach ($department_list as $department_list2) { ?>
																				<option value="<?php echo $department_list2->department_id; ?>" <?php if($department_list2->department_status == 0){ echo ' disabled'; } ?> ><?php echo $department_list2->department_name; ?></option>
																				<?php } } ?>
																			</select>
																		</div>
																		<div class="form-group col-md-3">
																			<!-- <label>Total Qty<span class="text-danger">*</span></label>
																			<input type="text" class="form-control form-control-sm job_item_total_qty" name="input[0][job_item_total_qty]" readonly required> -->
																		</div>
																		<div class="form-group col-md-3"></div>


																		<div class="form-group col-md-3 ">
																			<label>OK Qty<span class="text-danger">*</span></label>
																			<input type="text" class="form-control form-control-sm job_item_ok_qty" name="input[0][job_item_ok_qty]" required>
																		</div>
																		<div class="form-group col-md-3 select_sm">
																			<label>Next Department<span class="text-danger">*</span></label>
																			<select class="form-control select2 form-control-sm w-100 ok_department_id" name="input[0][ok_department_id]" data-placeholder="Select Department" required>
																				<option value="">Select Department</option>
																				<?php if(isset($department_list)){ foreach ($department_list as $department_list2) { ?>
																				<option value="<?php echo $department_list2->department_id; ?>" <?php if($department_list2->department_status == 0){ echo ' disabled'; } ?> ><?php echo $department_list2->department_name; ?></option>
																				<?php } } ?>
																			</select>
																		</div>
																		<div class="form-group col-md-3"></div>

																		<!-- <div class="form-group col-md-3 offset-md-3">
																			<label>Rejected Qty</label>
																			<input type="text" class="form-control form-control-sm job_item_reject_qty" name="input[0][job_item_reject_qty]" >
																		</div>
																		<div class="form-group col-md-3 select_sm">
																			<label>Department</label>
																			<select class="form-control select2 form-control-sm w-100 rejected_department_id" name="input[0][rejected_department_id]" data-placeholder="Select Department" >
																				<option value="">Select Department</option>
																				<?php if(isset($department_list)){ foreach ($department_list as $department_list2) { ?>
																				<option value="<?php echo $department_list2->department_id; ?>" <?php if($department_list2->department_status == 0){ echo ' disabled'; } ?> ><?php echo $department_list2->department_name; ?></option>
																				<?php } } ?>
																			</select>
																		</div> -->
																		<!-- <div class="form-group col-md-3"></div> -->

																		<!-- <div class="form-group col-md-3 offset-md-3">
																			<label>Rework Qty</label>
																			<input type="text" class="form-control form-control-sm job_item_rework_qty" name="input[0][job_item_rework_qty]" >
																		</div>
																		<div class="form-group col-md-3 select_sm">
																			<label>Department</label>
																			<select class="form-control select2 form-control-sm w-100 rework_department_id" name="input[0][rework_department_id]" data-placeholder="Select Department" >
																				<option value="">Select Department</option>
																				<?php if(isset($department_list)){ foreach ($department_list as $department_list2) { ?>
																				<option value="<?php echo $department_list2->department_id; ?>" <?php if($department_list2->department_status == 0){ echo ' disabled'; } ?> ><?php echo $department_list2->department_name; ?></option>
																				<?php } } ?>
																			</select>
																		</div> -->
																		<!-- <div class="form-group col-md-3"></div> -->

																		<div class="form-group col-md-3 offset-md-3">
																			<label>Pending Qty<span class="text-danger">*</span></label>
																			<input type="text" class="form-control form-control-sm job_item_pending_qty" name="input[0][job_item_pending_qty]" required readonly>
																		</div>
																	</div>
                                </td>
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
                          <div class="form-group select_sm">
                            <label class="">Remark<span class="text-danger">*</span></label>

														<!-- <select class="form-control select2 form-control-sm" multiple name="product_id[]" id="product_id[]" data-placeholder="Select Product" required>
															<option value="">Select Product</option>
															<?php if(isset($product_list)){ foreach ($product_list as $list) { ?>
															<option value="<?php echo $list->product_id; ?>"
																<?php if(isset($best_value_info)) {
																	$str_arr = explode (",", $best_value_info['product_id']);
																	foreach ($str_arr as $x) {
																		if($x == $list->product_id) { echo "selected"; }
																	}
																} ?>
															><?php echo $list->product_name; ?></option>
															<?php } } ?>
														</select> -->


                            <select class="form-control select2" multiple required name="remark_id[]" id="remark_id[]" data-placeholder="Select Remark" >
															<option value="">Select Remark</option>
															<?php if(isset($remark_list)){ foreach ($remark_list as $list) { ?>
																<option value="<?php echo $list->remark_id; ?>"
																	<?php if(isset($job_process_info)) {
																		$str_arr = explode (",", $job_process_info['remark_id']);
																		foreach ($str_arr as $x) {
																			if($x == $list->remark_id) { echo "selected"; }
																		}
																	} ?>
																><?php echo $list->remark_name; ?></option>
															<!-- <option value="<?php echo $list->remark_id; ?>" <?php if(isset($job_process_info) && $job_process_info['remark_id'] == $list->remark_id){ echo 'selected'; } if($list->remark_status == '0'){ echo ' disabled'; } ?>><?php echo $list->remark_name; ?></option> -->
															<?php } } ?>
														</select>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="">Notes</label>
                            <textarea class="form-control form-control-sm " rows="4" name="job_process_note" id="job_process_note" rows="6"><?php if(isset($job_process_info)){ echo $job_process_info['job_process_note']; } ?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                  <div class="card-footer clearfix" style="display: block;">
                    <div class="row">
                      <div class="col-md-6 text-left">
                        <!-- <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" name="customer_status" id="customer_status" value="0" <?php if(isset($job_process_info) && $job_process_info['customer_status'] == 0){ echo 'checked'; } ?>>
                          <label for="customer_status" class="custom-control-label">Disable This Job Process Issue</label>
                        </div> -->
                      </div>
                      <div class="col-md-6 text-right">
                        <a href="<?php echo base_url(); ?>Transaction/job_process" class="btn btn-sm btn-default px-4 mx-4">Cancel</a>
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
                <h3 class="card-title">Job Process Issue List</h3>
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
                    <?php if(isset($job_process_list)){
                      $m=0; foreach ($job_process_list as $list) { $m++;
												$party_data = $this->Master_Model->get_data('admi_party','party_name',['party_id'=>$list->party_id],'`party_id` DESC','row_array');
                        // $city_info = $this->Master_Model->get_info_arr_fields3('city_name', '', 'city_id', $list->city_id, '', '', '', '', 'city');
                    ?>
                      <tr>
                        <td class="d-none"><?php echo $m; ?></td>
                        <td class="text-center">
                          <div class="btn-group">
														<?php if($role_id == 1 || in_array("job_process3", $role_access)){ ?>
															<a href="<?php echo base_url() ?>Transaction/edit_job_process/<?php echo $list->job_process_id; ?>" type="button" class="btn btn-sm btn-default"><i class="fa fa-edit text-primary"></i></a>
														<?php } if($role_id == 1 || in_array("job_process4", $role_access)){ ?>  
															<a href="<?php echo base_url() ?>Transaction/delete_job_process/<?php echo $list->job_process_id; ?>" type="button" class="btn btn-sm btn-default" onclick="return confirm('Delete this Job Process Issue');"><i class="fa fa-trash text-danger"></i></a>
														<?php } ?>
															<!-- <a target="_blank" href="<?php echo base_url() ?>Transaction/job_process_print/<?php echo $list->job_process_id; ?>" type="button" class="btn btn-sm btn-default" ><i class="fa fa-print text-info"></i></a> -->
                          </div>
                        </td>
                        <td><?php if($party_data){ echo $party_data['party_name'];  } ?></td>
                        <td><?php echo $list->job_process_no; ?></td>
                        <td><?php echo $list->job_process_date; ?></td>
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
        <form action="update_job_process_status" method="post">
          <div class="modal-body">
            <input type="hidden" name="job_process_id" id="modal_job_process_id2">
            <input type="hidden" name="customer_id" id="modal_customer_id2">
            <label for="">Select Status</label>
            <select class="form-control" name="job_process_status" id="job_process_status">
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
        $('#item_id').html(result);
      }
    });
  });

	// get_purchase_order_list_by_item...  
	$(document).on("change", "#item_id,#party_id", function(){
    var item_id =  $('#item_id').find("option:selected").val();
    var party_id =  $('#party_id').find("option:selected").val();
    $.ajax({
      url:'<?php echo base_url(); ?>Master/get_purchase_order_list_by_item',
      type: 'POST',
      data: {"item_id":item_id, "party_id":party_id},
      context: this,
      success: function(result){
				$('.po_item_id').html(result);
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

	// get_po_details_by_po_item_id...
	$(document).on("change", ".po_item_id", function(){
    var po_item_id =  $(this).find("option:selected").val();
    $.ajax({
      url:'<?php echo base_url(); ?>Transaction/get_po_details_by_po_item_id',
      type: 'POST',
      data: {"po_item_id":po_item_id},
      context: this,
      success: function(result){
				var data = JSON.parse(result);
				$(this).closest('tr').find('.job_item_sr_no').val(data['po_item_info']['po_item_sr_no']);
				$(this).closest('tr').find('.job_item_po_date').val(data['po_item_info']['purchase_order_date']);
				$(this).closest('tr').find('.job_item_due_date').val(data['po_item_info']['po_item_due_date']);
				$(this).closest('tr').find('.job_item_po_qty').val(data['po_item_info']['po_item_qty']);
				$(this).closest('tr').find('.job_item_po_add_qty').val(data['po_item_info']['po_item_add_qty']);


				// alert(data['po_item_info']['po_item_id']);
				// $(this).closest('tr').find('.process_type_id').html(result);
      }
    });

		var item_id =  $('#item_id').find("option:selected").val();
    $.ajax({
      url:'<?php echo base_url(); ?>Master/get_process_type_list_by_item',
      type: 'POST',
      data: {"item_id":item_id},
      context: this,
      success: function(result){
				$(this).closest('tr').find('.process_type_id').html(result);

				// get_department_by_process_type
				var process_type_id = $(this).closest('tr').find('.process_type_id').find("option:selected").val();
				var this_row = $(this);

				department_by_process(process_type_id,this_row);	
      }
    });
  });

	// get_department_by_process_type.... common function...
	function department_by_process(process_type_id,this_row){
		$.ajax({
      url:'<?php echo base_url(); ?>Master/get_department_by_process_type',
      type: 'POST',
      data: {"process_type_id":process_type_id },
      context: this,
      success: function(result){
				// $(this).closest('tr').find('.department_id').html(result);
				this_row.closest('tr').find('.ok_department_id').html(result);
				this_row.closest('tr').find('.rejected_department_id').html(result);
				this_row.closest('tr').find('.rework_department_id').html(result);				
        // $('#item_id').html(result);
      }
    });

		$.ajax({
      url:'<?php echo base_url(); ?>Master/get_department_by_process_type_user',
      type: 'POST',
      data: {"process_type_id":process_type_id },
      context: this,
      success: function(result){
				this_row.closest('tr').find('.department_id').html(result);
				// $(this).closest('tr').find('.ok_department_id').html(result);
				// $(this).closest('tr').find('.rejected_department_id').html(result);
				// $(this).closest('tr').find('.rework_department_id').html(result);				
        // $('#item_id').html(result);
      }
    });
	}

	// get_process_type_list_by_item2...
	$(document).on("change", "#item_id,#party_id", function(){
    var item_id =  $('#item_id').find("option:selected").val();
    $.ajax({
      url:'<?php echo base_url(); ?>Master/get_process_type_list_by_item2',
      type: 'POST',
      data: {"item_id":item_id},
      context: this,
      success: function(result){
				$('.process_type_id').html(result);
      }
    });
  });

	// get_department_by_process_type...
	$(document).on("change",".process_type_id", function(){
    var process_type_id  =  $(this).find("option:selected").val();
		var this_row = $(this);
		department_by_process(process_type_id,this_row);
  });


	// get_total_bal_by_department...
	$(document).on("change",".department_id, .job_item_po_qty", function(){
    var department_id  =  $(this).find("option:selected").val();
    var item_id =  $('#item_id').find("option:selected").val();
    var po_item_id  =  $(this).closest('tr').find('.po_item_id').val();

		var job_item_id = $(this).closest('tr').find('.job_item_id').val();
		if(!job_item_id){ var job_item_id = 0; }

    $.ajax({
      url:'<?php echo base_url(); ?>Transaction/get_total_bal_by_department',
      type: 'POST',
      data: {"department_id":department_id,"item_id":item_id, "job_item_id":job_item_id, "po_item_id":po_item_id },
      context: this,
      success: function(result){
				var job_item_po_qty = $(this).closest('tr').find('.job_item_po_qty').val();
				if(job_item_po_qty == ''){ var job_item_po_qty = 0; }
    		var job_item_po_qty = parseFloat(job_item_po_qty);

				var job_item_po_add_qty = $(this).closest('tr').find('.job_item_po_add_qty').val();
				if(job_item_po_add_qty == ''){ var job_item_po_add_qty = 0; }
    		var job_item_po_add_qty = parseFloat(job_item_po_add_qty);

				var data = JSON.parse(result);
				var exist = data['exist'];
				var tot_balance_qty = data['tot_balance_qty'];
				if(tot_balance_qty == ''){ var tot_balance_qty = 0; }
    		var tot_balance_qty = parseFloat(tot_balance_qty);

				if(exist == 0){
					var job_item_total_qty = job_item_po_qty + job_item_po_add_qty;
				} else{
					var job_item_total_qty = tot_balance_qty;
				}
				// var job_item_total_qty = result + job_item_po_qty;
				// var job_item_total_qty = exist;
				$(this).closest('tr').find('.job_item_total_qty').val(job_item_total_qty);
      }
    });

		$(this).closest('tr').find('.job_item_ok_qty').val('');
		$(this).closest('tr').find('.job_item_reject_qty').val('');
		$(this).closest('tr').find('.job_item_rework_qty').val('');
		$(this).closest('tr').find('.job_item_pending_qty').val(0);
  });


	$(document).on("keyup",".job_item_ok_qty, .job_item_reject_qty, .job_item_rework_qty", function(){
		// var job_item_total_qty = $(this).closest('tr').find('.job_item_total_qty').val();
		// if(job_item_total_qty == ''){ var job_item_total_qty = 0; }
		// var job_item_total_qty = parseFloat(job_item_total_qty);
		var job_item_total_qty = $(this).closest('tr').find('.job_item_po_qty').val();
		if(job_item_total_qty == ''){ var job_item_total_qty = 0; }
		var job_item_total_qty = parseFloat(job_item_total_qty);

		var job_item_ok_qty = $(this).closest('tr').find('.job_item_ok_qty').val();
		if(job_item_ok_qty == ''){ var job_item_ok_qty = 0; }
		var job_item_ok_qty = parseFloat(job_item_ok_qty);

		var job_item_reject_qty = $(this).closest('tr').find('.job_item_reject_qty').val();
		if(job_item_reject_qty == ''){ var job_item_reject_qty = 0; }
		var job_item_reject_qty = parseFloat(job_item_reject_qty);

		var job_item_rework_qty = $(this).closest('tr').find('.job_item_rework_qty').val();
		if(job_item_rework_qty == ''){ var job_item_rework_qty = 0; }
		var job_item_rework_qty = parseFloat(job_item_rework_qty);

		// var job_item_pending_qty = job_item_total_qty - (job_item_ok_qty + job_item_reject_qty + job_item_rework_qty);		
		var job_item_pending_qty = job_item_total_qty - (job_item_ok_qty);		
console.log(job_item_pending_qty);

		if(job_item_pending_qty < 0){
			toastr.error('Invalid Quantity Entered');
			$(this).closest('tr').find('.job_item_ok_qty').val('');
			$(this).closest('tr').find('.job_item_reject_qty').val('');
			$(this).closest('tr').find('.job_item_rework_qty').val('');
			$(this).closest('tr').find('.job_item_pending_qty').val('');
		} else{
			$(this).closest('tr').find('.job_item_pending_qty').val(job_item_pending_qty);
		}
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
			'<td class="">'+
				'<div class="row">'+
					'<div class="form-group col-md-3 select_sm">'+
						'<label>PO No.<span class="text-danger">*</span></label>'+
						'<select class="form-control select2 form-control-sm w-100 po_item_id" id="po_item_id_'+i+'" name="input['+i+'][po_item_id]" data-placeholder="Select PO No." required>'+
							'<option value="">Select PO No.</option>'+
						'</select>'+
					'</div>'+
					'<div class="form-group col-md-2">'+
						'<label>Sr. No.<span class="text-danger">*</span></label>'+
						'<input type="text" class="form-control form-control-sm job_item_sr_no" name="input['+i+'][job_item_sr_no]" readonly required>'+
					'</div>'+
					'<div class="form-group col-md-2">'+
						'<label>PO. Date.<span class="text-danger">*</span></label>'+
						'<div class="input-group date" id="date2" data-target-input="nearest">'+
							'<input type="text" class="form-control form-control-sm datetimepicker-input job_item_po_date" id="job_item_po_date'+i+'" name="input['+i+'][job_item_po_date]" value="" data-target="#date2" data-toggle="datetimepicker" readonly required>'+
						'</div>'+
					'</div>'+
					'<div class="form-group col-md-2">'+
						'<label>Due Date.<span class="text-danger">*</span></label>'+
						'<div class="input-group date" id="date3" data-target-input="nearest">'+
							'<input type="text" class="form-control form-control-sm datetimepicker-input job_item_due_date" id="job_item_due_date'+i+'" name="input['+i+'][job_item_due_date]" value="" data-target="#date3" data-toggle="datetimepicker" readonly required>'+
						'</div>'+
					'</div>'+
					'<div class="form-group col-md-3 select_sm">'+
						'<label>Grade<span class="text-danger">*</span></label>'+
						'<select class="form-control select2 form-control-sm w-100 grade_id" name="input['+i+'][grade_id]" data-placeholder="Select Grade" required>'+
							'<option value="">Select Grade</option>'+
							'<?php if(isset($grade_list)){ foreach ($grade_list as $grade_list2) { ?>'+
							'<option value="<?php echo $grade_list2->grade_id; ?>" <?php if($grade_list2->grade_status == 0){ echo ' disabled'; } ?> ><?php echo $grade_list2->grade_name; ?></option>'+
							'<?php } } ?>'+
						'</select>'+
					'</div>'+
					'<div class="form-group col-md-3">'+
						'<label>PO Qty<span class="text-danger">*</span></label>'+
						'<input type="text" class="form-control form-control-sm job_item_po_qty" name="input['+i+'][job_item_po_qty]" readonly required>'+
						'<input type="hidden" class="form-control form-control-sm job_item_po_add_qty" name="input['+i+'][job_item_po_add_qty]" >'+
					'</div>'+
					'<div class="form-group col-md-3 select_sm">'+
						'<label>Process Type<span class="text-danger">*</span></label>'+
						'<select class="form-control select2 form-control-sm w-100 process_type_id" name="input['+i+'][process_type_id]" data-placeholder="Select Process Type" required>'+
							'<option value="">Select Process Type</option>'+
							'<?php if(isset($process_type_list)){ foreach ($process_type_list as $process_type_list2) { ?>'+
							'<option value="<?php echo $process_type_list2->process_type_id; ?>" <?php if($process_type_list2->process_type_status == 0){ echo ' disabled'; } ?> ><?php echo $process_type_list2->process_type_name; ?></option>'+
							'<?php } } ?>'+
						'</select>'+
					'</div>'+
					'<div class="form-group col-md-3 select_sm">'+
						'<label>Current Department<span class="text-danger">*</span></label>'+
						'<select class="form-control select2 form-control-sm w-100 department_id" name="input['+i+'][department_id]" data-placeholder="Select Department" required>'+
							'<option value="">Select Department</option>'+
							'<?php if(isset($department_list)){ foreach ($department_list as $department_list2) { ?>'+
							'<option value="<?php echo $department_list2->department_id; ?>" <?php if($department_list2->department_status == 0){ echo ' disabled'; } ?> ><?php echo $department_list2->department_name; ?></option>'+
							'<?php } } ?>'+
						'</select>'+
					'</div>'+
					'<div class="form-group col-md-3">'+
						// '<label>Total Qty<span class="text-danger">*</span></label>'+
						// '<input type="text" class="form-control form-control-sm job_item_total_qty" name="input['+i+'][job_item_total_qty]" readonly required>'+
					'</div>'+
					
																		'<div class="form-group col-md-3"></div><div class="form-group col-md-3 ">'+
						'<label>OK Qty<span class="text-danger">*</span></label>'+
						'<input type="text" class="form-control form-control-sm job_item_ok_qty" name="input['+i+'][job_item_ok_qty]" required>'+
					'</div>'+
					'<div class="form-group col-md-3 select_sm">'+
						'<label>Next Department<span class="text-danger">*</span></label>'+
						'<select class="form-control select2 form-control-sm w-100 ok_department_id" name="input['+i+'][ok_department_id]" data-placeholder="Select Department" required>'+
							'<option value="">Select Department</option>'+
							'<?php if(isset($department_list)){ foreach ($department_list as $department_list2) { ?>'+
							'<option value="<?php echo $department_list2->department_id; ?>" <?php if($department_list2->department_status == 0){ echo ' disabled'; } ?> ><?php echo $department_list2->department_name; ?></option>'+
							'<?php } } ?>'+
						'</select>'+
					'</div>'+
					// '<div class="form-group col-md-3"></div>'+
					// '<div class="form-group col-md-3 offset-md-3">'+
					// 	'<label>Rejected Qty</label>'+
					// 	'<input type="text" class="form-control form-control-sm job_item_reject_qty" name="input['+i+'][job_item_reject_qty]" >'+
					// '</div>'+
					// '<div class="form-group col-md-3 select_sm">'+
					// 	'<label>Department</label>'+
					// 	'<select class="form-control select2 form-control-sm w-100 rejected_department_id" name="input['+i+'][rejected_department_id]" data-placeholder="Select Department" >'+
					// 		'<option value="">Select Department</option>'+
					// 		'<?php if(isset($department_list)){ foreach ($department_list as $department_list2) { ?>'+
					// 		'<option value="<?php echo $department_list2->department_id; ?>" <?php if($department_list2->department_status == 0){ echo ' disabled'; } ?> ><?php echo $department_list2->department_name; ?></option>'+
					// 		'<?php } } ?>'+
					// 	'</select>'+
					// '</div>'
					
					// '<div class="form-group col-md-3"></div>'+
					// '<div class="form-group col-md-3 offset-md-3">'+
					// 	'<label>Rework Qty</label>'+
					// 	'<input type="text" class="form-control form-control-sm job_item_rework_qty" name="input['+i+'][job_item_rework_qty]" >'+
					// '</div>'+
					// '<div class="form-group col-md-3 select_sm">'+
					// 	'<label>Department</label>'+
					// 	'<select class="form-control select2 form-control-sm w-100 rework_department_id" name="input['+i+'][rework_department_id]" data-placeholder="Select Department" >'+
					// 		'<option value="">Select Department</option>'+
					// 		'<?php if(isset($department_list)){ foreach ($department_list as $department_list2) { ?>'+
					// 		'<option value="<?php echo $department_list2->department_id; ?>" <?php if($department_list2->department_status == 0){ echo ' disabled'; } ?> ><?php echo $department_list2->department_name; ?></option>'+
					// 		'<?php } } ?>'+
					// 	'</select>'+
					// '</div>'+
					+'<div class="form-group col-md-3"></div>'+
					'<div class="form-group col-md-3 offset-md-3">'+
						'<label>Pending Qty<span class="text-danger">*</span></label>'+
						'<input type="text" class="form-control form-control-sm job_item_pending_qty" name="input['+i+'][job_item_pending_qty]" required readonly>'+
					'</div>'+
					'<div class="form-group col-md-3 pt-2">'+
						'<a class="rem_row"><i class="fa fa-trash text-danger f-20"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
    '</tr>';
    $('#myTable1').append(row);
    $('.select2').select2();

		$('#job_item_po_date'+i+'').datetimepicker({
			format: 'DD-MM-Y'
		});
		$('#job_item_due_date'+i+'').datetimepicker({
			format: 'DD-MM-Y'
		});

		// get_purchase_order_list_by_item...
		var item_id =  $('#item_id').find("option:selected").val();
		var party_id =  $('#party_id').find("option:selected").val();
		$.ajax({
			url:'<?php echo base_url(); ?>Master/get_purchase_order_list_by_item',
			type: 'POST',
			data: {"item_id":item_id, "party_id":party_id},
			context: this,
			success: function(result){
				$('#po_item_id_'+i+'').html(result);
			}
		});

  });

  $('#myTable1').on('click', '.rem_row', function () {
    $(this).closest('tr').remove();
    final_calculation();
  });


	


</script>
