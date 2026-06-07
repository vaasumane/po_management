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
            <h4>Item</h4>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">

        

          <div class="col-md-12">
            <div class="card card_shadow <?php if(!isset($update)){ echo 'collapsed-card'; } ?> card-default card_shadow">
              <div class="card-header">
                <h3 class="card-title"> <?php if(isset($update)){ echo 'Update'; } else{ echo 'Add New'; } ?> Item</h3>
                <div class="card-tools">
                  <?php if(!isset($update)){
										if($role_id == 1 || in_array("item2", $role_access)){
                    	echo '<button type="button" class="btn btn-sm btn-primary" data-card-widget="collapse">Add New</button>';
										}
                  } else{
                    echo '<a href="'.base_url().'Master/item" type="button" class="btn btn-xs btn-outline-secondary px-4 mx-4" >Cancel Edit</a>';
                  } ?>
                </div>
              </div>

							<div class="card-body px-0 py-0 " >
								<form class="input_form m-0 needs-validation" novalidate id="form_action" role="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
									<div class="row p-4">
										<div class="form-group col-md-8 offset-md-2 select_sm">
											<label>Party<span class="text-danger">*</span></label>
											<select class="form-control select2" name="party_id" id="party_id" data-placeholder="Select Party" required>
                        <option value="">Select Party</option>
                        <?php if(isset($party_list)){ foreach ($party_list as $list) { ?>
                        <option value="<?php echo $list->party_id; ?>" <?php if(isset($item_info) && $item_info['party_id'] == $list->party_id){ echo 'selected'; } if($list->party_status == '0'){ echo ' disabled'; } ?>><?php echo $list->party_name; ?></option>
                        <?php } } ?>
                      </select>
										</div>
										<div class="form-group col-md-4 offset-md-2 select_sm">
											<label>Item Group<span class="text-danger">*</span></label>
											<select class="form-control select2" name="item_group_id" id="item_group_id" data-placeholder="Select Item Group" required>
                        <option value="">Select Item Group</option>
                        <?php if(isset($item_group_list)){ foreach ($item_group_list as $list) { ?>
                        <option value="<?php echo $list->item_group_id; ?>" <?php if(isset($item_info) && $item_info['item_group_id'] == $list->item_group_id){ echo 'selected'; } if($list->item_group_status == '0'){ echo ' disabled'; } ?>><?php echo $list->item_group_name; ?></option>
                        <?php } } ?>
                      </select>
										</div>
										<div class="form-group col-md-4 select_sm">
											<label>Process Type<span class="text-danger">*</span></label>
											<select class="form-control select2" name="process_type_id" id="process_type_id" data-placeholder="Select Process Type" required>
                        <option value="">Select Process Type</option>
                        <?php if(isset($process_type_list)){ foreach ($process_type_list as $list) { ?>
                        <option value="<?php echo $list->process_type_id; ?>" <?php if(isset($item_info) && $item_info['process_type_id'] == $list->process_type_id){ echo 'selected'; } if($list->process_type_status == '0'){ echo ' disabled'; } ?>><?php echo $list->process_type_name; ?></option>
                        <?php } } ?>
                      </select>
										</div>
										<div class="form-group col-md-4 offset-md-2">
											<label>Casting Drawing No.<span class="text-danger">*</span></label>
											<input type="text" class="form-control form-control-sm" name="item_casting_drw_no" id="item_casting_drw_no" value="<?php if(isset($item_info)){ echo $item_info['item_casting_drw_no']; } ?>" placeholder="Enter Casting Drawing No." required>
										</div>
										<div class="form-group col-md-4">
											<label>Finished Drawing No.<span class="text-danger">*</span></label>
											<input type="text" class="form-control form-control-sm" name="item_finished_drw_no" id="item_finished_drw_no" value="<?php if(isset($item_info)){ echo $item_info['item_finished_drw_no']; } ?>" placeholder="Enter Finished Drawing No." required>
										</div>

										<div class="form-group col-md-4 offset-md-2 select_sm">
											<label>Grade<span class="text-danger">*</span></label>
											<select class="form-control select2" name="grade_id" id="grade_id" data-placeholder="Select Grade" required>
                        <option value="">Select Grade</option>
                        <?php if(isset($grade_list)){ foreach ($grade_list as $list) { ?>
                        <option value="<?php echo $list->grade_id; ?>" <?php if(isset($item_info) && $item_info['grade_id'] == $list->grade_id){ echo 'selected'; } if($list->grade_status == '0'){ echo ' disabled'; } ?>><?php echo $list->grade_name; ?></option>
                        <?php } } ?>
                      </select>
										</div>
										<div class="form-group col-md-4">
											<label>HSN Code<span class="text-danger">*</span></label>
											<input type="text" class="form-control form-control-sm" name="item_hsn_code" id="item_hsn_code" value="<?php if(isset($item_info)){ echo $item_info['item_hsn_code']; } ?>" placeholder="Enter HSN Code" required>
										</div>
										<div class="form-group col-md-8 offset-md-2">
											<label>Description</label>
											<textarea class="form-control form-control-sm" rows="5" name="item_descr" id="item_descr" placeholder="Enter Item Description" ><?php if(isset($item_info)){ echo $item_info['item_descr']; } ?></textarea>
										</div>
										<div class="form-group col-md-4 offset-md-2 select_sm">
											<label>Unit<span class="text-danger">*</span></label>
											<select class="form-control select2" name="unit_id" id="unit_id" data-placeholder="Select Unit" required>
                        <option value="">Select Unit</option>
                        <?php if(isset($unit_list)){ foreach ($unit_list as $list) { ?>
                        <option value="<?php echo $list->unit_id; ?>" <?php if(isset($item_info) && $item_info['unit_id'] == $list->unit_id){ echo 'selected'; } if($list->unit_status == '0'){ echo ' disabled'; } ?>><?php echo $list->unit_name; ?></option>
                        <?php } } ?>
                      </select>
										</div>
										<div class="form-group col-md-4 select_sm">
											<label>GST<span class="text-danger">*</span></label>
											<select class="form-control select2" name="tax_rate_id" id="tax_rate_id" data-placeholder="Select GST" required>
                        <option value="">Select GST</option>
                        <?php if(isset($tax_rate_list)){ foreach ($tax_rate_list as $list) { ?>
                        <option value="<?php echo $list->tax_rate_id; ?>" <?php if(isset($item_info) && $item_info['tax_rate_id'] == $list->tax_rate_id){ echo 'selected'; } if($list->tax_rate_status == '0'){ echo ' disabled'; } ?>><?php echo $list->tax_rate_name; ?></option>
                        <?php } } ?>
                      </select>
										</div>
										
									</div>
									<div class="card-footer clearfix" style="display: block;">
										<div class="row">
											<div class="col-md-6 text-left">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" type="checkbox" name="item_status" id="item_status" value="0" <?php if(isset($item_info) && $item_info['item_status'] == 0){ echo 'checked'; } ?>>
													<label for="item_status" class="custom-control-label">Disable This Item</label>
												</div>
											</div>
											<div class="col-md-6 text-right">
												<a href="<?= base_url(); ?>Master/item" class="btn btn-sm btn-default px-4 mx-1">Cancel</a>
												<?php if(isset($update)){
													if($role_id == 1 || in_array("item3", $role_access)){
														echo '<button class="btn btn-sm btn-primary float-right px-4">Update</button>';
													}
												} else{
													if($role_id == 1 || in_array("item2", $role_access)){
														echo '<button class="btn btn-sm btn-success float-right px-4">Save</button>';
													}
												} ?>
											</div>
										</div>
									</div>
								</form>
							</div>
            </div>
          </div>


          <div class="col-md-12 ">
            <div class="card card-info card_shadow">
              <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-list"></i> All Item List</h3>
              </div>
              <div class="card-body p-2 overflow_x_auto">
                <table id="example2" class="table table-bordered table-striped w-100">
                  <thead>
                    <tr>
                      <th class="d-none">#</th>
                      <th class="wt_30">Action</th>
                      <th>Party</th>
                      <th>Item Group</th>
                      <th>Process Type</th>
                      <th>Casting Drawing No.</th>
                      <th>Finished Drawing No</th>
                      <th>Grade</th>
                      <th class="wt_30">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($item_list)){
                     $i=0; foreach ($item_list as $list) { $i++;
											$party_info = $this->Master_Model->get_data('admi_party','party_name',['party_id'=>$list->party_id],'`party_name` ASC','row_array');
											$item_group_info = $this->Master_Model->get_data('admi_item_group','item_group_name',['item_group_id'=>$list->item_group_id],'`item_group_name` ASC','row_array');
											$process_type_info = $this->Master_Model->get_data('admi_process_type','process_type_name',['process_type_id'=>$list->process_type_id],'`process_type_name` ASC','row_array');
											$grade_info = $this->Master_Model->get_data('admi_grade','grade_name',['grade_id'=>$list->grade_id],'`grade_name` ASC','row_array');
                    ?>
                    <tr>
                      <td class="d-none"><?php echo $i; ?></td>
                      <td class="text-center">
                        <div class="btn-group">
													<?php if($role_id == 1 || in_array("item3", $role_access)){ ?>  
														<a href="<?php echo base_url() ?>Master/edit_item/<?php echo $list->item_id; ?>" type="button" class="btn btn-sm btn-default"><i class="fa fa-edit text-primary" data-toggle="tooltip" data-placement="bottom" title="Edit"></i></a>
													<?php } if($role_id == 1 || in_array("item4", $role_access)){ ?>  
														<a href="<?php echo base_url() ?>Master/delete_item/<?php echo $list->item_id; ?>" type="button" class="btn btn-sm btn-default" onclick="return confirm('Delete this Item Information');" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash text-danger"></i></a>
													<?php } ?>
												</div>
                      </td>
                      <td><?php if($party_info){ echo $party_info['party_name']; } ?></td>
                      <td><?php if($item_group_info){ echo $item_group_info['item_group_name']; } ?></td>
                      <td><?php if($process_type_info){ echo $process_type_info['process_type_name']; } ?></td>
											<td><?= $list->item_casting_drw_no; ?></td>
											<td><?= $list->item_finished_drw_no; ?></td>
                      <td><?php if($grade_info){ echo $grade_info['grade_name']; } ?></td>
                      <!--  -->
                      <td>
                          <?php if($list->item_status == 0){ echo '<span class="text-danger">Inactive</span>'; }
                          else{ echo '<span class="text-success">Active</span>'; } ?>
                      </td>
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

</body>
</html>

<script>
	// get_department_by_process_type...
	$("#process_type_id").on("change", function(){
    var process_type_id =  $('#process_type_id').find("option:selected").val();
    $.ajax({
      url:'<?php echo base_url(); ?>Master/get_department_by_process_type',
      type: 'POST',
      data: {"process_type_id":process_type_id},
      context: this,
      success: function(result){
        $('#department_id').html(result);
      }
    });
  });
</script>


<!-- <script type="text/javascript">
	// Check Mobile Duplication..
	var item_name1 = $('#item_name').val();
	$('#item_name').on('change',function(){
		var item_name = $(this).val();
		$.ajax({
			url:'<?php echo base_url(); ?>Master/check_duplication',
			type: 'POST',
			data: {"column_name":"item_name",
			"column_val":item_name,
			"table_name":"admi_item"},
			context: this,
			success: function(result){
				if(result > 0){
					$('#item_name').val(item_name1);
					toastr.error(item_name+' Exist.');
				}
			}
		});	
	});
</script> -->
