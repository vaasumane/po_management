<!DOCTYPE html>
<html>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header pt-0 pb-2">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12 text-left mt-2">
            <h4>Party</h4>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card_shadow <?php if(!isset($update)){ echo 'collapsed-card'; } ?> card-default">
              <div class="card-header">
                <h3 class="card-title"> <?php if(isset($update)){ echo 'Update'; } else{ echo 'Add New'; } ?> Party</h3>
                <div class="card-tools">
                  <?php if(!isset($update)){
										if($role_id == 1 || in_array("party2", $role_access)){
                    	echo '<button type="button" class="btn btn-sm btn-primary" data-card-widget="collapse">Add New</button>';
										}
                  } else{
										echo '<a href="'.base_url().'Master/party" type="button" class="btn btn-xs btn-outline-secondary px-4 mx-4" >Cancel Edit</a>';
									} ?>
                </div>
              </div>
              <!--  -->
              <div class="card-body p-0" <?php if(isset($update)){ echo 'style="display: block;"'; } else{ echo 'style="display: none;"'; } ?>>
                <form class="input_form m-0 needs-validation" novalidate id="form_action" role="form" action="" method="post" enctype="multipart/form-data">
                  <div class="row p-4">

                    <div class="form-group col-md-6 row">
											<!-- <div class="form-group col-md-12 select_sm mb-1">
												<label>party Type<span class="text-danger">*</span></label>
												<select class="form-control select2" name="party_type" id="party_type" data-placeholder="Select party Type" required>
													<option value="">Select party Type</option>
													<option value="1" <?php if(isset($party_info) && $party_info['party_type'] == '1'){ echo 'selected'; } ?>>Sales Person</option>
													<option value="2" <?php if(isset($party_info) && $party_info['party_type'] == '2'){ echo 'selected'; } ?>>party</option>
												</select>
											</div> -->
											<div class="form-group col-md-12 mb-2">
												<label>Party Name<span class="text-danger">*</span></label>
												<input type="text" class="form-control form-control-sm alphabet" name="party_name" id="party_name" value="<?php if(isset($party_info)){ echo $party_info['party_name']; } ?>"  placeholder="Enter Name of Party" required >
												<div class="invalid-feedback">
													Please enter Party Name.
												</div>
											</div>
											<div class="form-group col-md-6 select_sm mb-1">
												<label>Party Group<span class="text-danger">*</span></label>
												<select class="form-control select2" name="party_group_id" id="party_group_id" data-placeholder="Select Party Group" required>
													<option value="">Select Party Group</option>
													<option value="1" <?php if(isset($party_info) && $party_info['party_group_id'] == '1'){ echo 'selected'; } ?>>Customer</option>
													<option value="2" <?php if(isset($party_info) && $party_info['party_group_id'] == '2'){ echo 'selected'; } ?>>Vendor</option>
												</select>
											</div>
											<div class="form-group col-md-6 mb-1">
												<label>Vendor Code</label>
												<input type="number" class="form-control form-control-sm " name="party_code" id="party_code" value="<?php if(isset($party_info)){ echo $party_info['party_code']; } ?>" placeholder="Enter Vendor Code" >
												<div class="invalid-feedback">
													Please enter Vendor Code
												</div>
											</div>
											
                    </div>
                    <div class="form-group col-md-6">
                      <label>Address<span class="text-danger">*</span></label>
                      <textarea class="form-control form-control-sm" rows="4" name="party_address" id="party_address" placeholder="Enter Address" required><?php if(isset($party_info)){ echo $party_info['party_address']; } ?></textarea>
											<div class="invalid-feedback">
												Please enter Address
											</div>
										</div>

										<div class="form-group col-md-3 select_sm">
											<label>Country<span class="text-danger">*</span></label>
											<select class="form-control select2" name="country_id" id="country_id" data-placeholder="Select Country" required>
												<option value="">Select Country</option>
												<?php if(isset($country_list)){ foreach ($country_list as $list) { ?>
												<option value="<?php echo $list->country_id; ?>" <?php if(isset($party_info) && $party_info['country_id'] == $list->country_id){ echo 'selected'; } ?>><?php echo $list->country_name; ?></option>
												<?php } } ?>
											</select>
											<div class="invalid-feedback">
												Please select Country
											</div>
										</div>

										<div class="form-group col-md-3 select_sm">
                      <label>State<span class="text-danger">*</span></label>
                      <select class="form-control select2" name="state_id" id="state_id" data-placeholder="Select State" required>
                        <option value="">Select State</option>
                        <?php if(isset($state_list)){ foreach ($state_list as $list) { ?>
                        <option value="<?php echo $list->state_id; ?>" <?php if(isset($party_info) && $party_info['state_id'] == $list->state_id){ echo 'selected'; } ?>><?php echo $list->state_name; ?></option>
                        <?php } } ?>
                      </select>
											<div class="invalid-feedback">
												Please select State
											</div>
                    </div>
										<div class="form-group col-md-3 select_sm">
                      <label>City<span class="text-danger">*</span></label>
                      <select class="form-control select2" name="city_id" id="city_id" data-placeholder="Select City" required>
                        <option value="">Select City</option>
                        <?php if(isset($city_list)){ foreach ($city_list as $list) { ?>
                        <option value="<?php echo $list->city_id; ?>" <?php if(isset($party_info) && $party_info['city_id'] == $list->city_id){ echo 'selected'; } ?>><?php echo $list->city_name; ?></option>
                        <?php } } ?>
                      </select>
											<div class="invalid-feedback">
												Please select City
											</div>
                    </div>
										<div class="form-group col-md-3">
											<label>Pincode</label>
											<input type="number" class="form-control form-control-sm pincode_no" name="party_pincode" id="party_pincode" value="<?php if(isset($party_info)){ echo $party_info['party_pincode']; } ?>" placeholder="Enter Pincode" >
										</div>

										<div class="form-group col-md-3">
											<label>GST No.</label>
											<input type="text" class="form-control form-control-sm gst_no" name="party_gst_no" id="party_gst_no" value="<?php if(isset($party_info)){ echo $party_info['party_gst_no']; } ?>" placeholder="Enter GST No.">
										</div>
										<div class="form-group col-md-3">
											<label>PAN No.</label>
											<input type="text" class="form-control form-control-sm pan_no" name="party_pan_no" id="party_pan_no" value="<?php if(isset($party_info)){ echo $party_info['party_pan_no']; } ?>" placeholder="Enter Pan No.">
										</div>

										<div class="form-group col-md-3 select_sm">
											<label>TCS Applicable<span class="text-danger">*</span></label>
											<select class="form-control select2" name="party_tcs_applicable" id="party_tcs_applicable" data-placeholder="TCS Applicable" required>
												<option value="">TCS Applicable</option>
												<option value="1" <?php if(isset($party_info) && $party_info['party_tcs_applicable'] == '1'){ echo 'selected'; } ?> >Yes</option>
												<option value="0" <?php if(isset($party_info) && $party_info['party_tcs_applicable'] == '0'){ echo 'selected'; } ?> >No</option>
											</select>
											<div class="invalid-feedback">
												Please select Value.
											</div>
										</div>
										<div class="form-group col-md-3">
											<label>TAN No.</label>
											<input type="text" class="form-control form-control-sm " name="party_tan_no" id="party_tan_no" value="<?php if(isset($party_info)){ echo $party_info['party_tan_no']; } ?>" placeholder="Enter TAN No.">
										</div>

										<div class="form-group col-md-3">
											<label>Mobile No. 1<span class="text-danger">*</span></label>
											<input type="number" class="form-control form-control-sm mobile_no" name="party_mobile" id="party_mobile" value="<?php if(isset($party_info)){ echo $party_info['party_mobile']; } ?>" placeholder="Enter Mobile No. 1" required>
											<div class="invalid-feedback">
												Please enter Mobile No.
											</div>
										</div>
										<div class="form-group col-md-3">
											<label>Mobile No. 2</label>
											<input type="number" class="form-control form-control-sm mobile_no" name="party_mobile2" id="party_mobile2" value="<?php if(isset($party_info)){ echo $party_info['party_mobile2']; } ?>" placeholder="Enter Mobile No. 2" >
										</div>										
										<div class="form-group col-md-3">
											<label>Email</label>
											<input type="email" class="form-control form-control-sm email" name="party_email" id="party_email" value="<?php if(isset($party_info)){ echo $party_info['party_email']; } ?>" placeholder="Enter Email" >
										</div>
										<div class="form-group col-md-3">
											<label>Website</label>
											<input type="text" class="form-control form-control-sm" name="party_website" id="party_website" value="<?php if(isset($party_info)){ echo $party_info['party_website']; } ?>" placeholder="Enter Website">
										</div>	
										<div class="form-group col-md-3">
											<label>DL No. 1</label>
											<input type="text" class="form-control form-control-sm" name="party_lic1" id="party_lic1" value="<?php if(isset($party_info)){ echo $party_info['party_lic1']; } ?>" placeholder="Enter DL No. 1">
										</div>
										<div class="form-group col-md-3">
											<label>DL No. 2</label>
											<input type="text" class="form-control form-control-sm" name="party_lic2" id="party_lic2" value="<?php if(isset($party_info)){ echo $party_info['party_lic2']; } ?>" placeholder="Enter Licence No. 2">
										</div>
												
										<div class="form-group col-md-12 mb-2">
											<hr class="m-0">
										</div>
										
										<div class="form-group col-md-6">
											<label>Bank Name</label>
											<input type="text" class="form-control form-control-sm" name="bank_name" id="bank_name" value="<?php if(isset($party_info)){ echo $party_info['bank_name']; } ?>" placeholder="Enter Bank Name">
										</div>
										<div class="form-group col-md-6">
											<label>Bank Branch Name</label>
											<input type="text" class="form-control form-control-sm" name="bank_branch" id="bank_branch" value="<?php if(isset($party_info)){ echo $party_info['bank_branch']; } ?>" placeholder="Enter Bank Branch Name">
										</div>

										<div class="form-group col-md-6">
											<label>Bank Account Number</label>
											<input type="number" step="1" class="form-control form-control-sm" name="bank_acc_no" id="bank_acc_no" value="<?php if(isset($party_info)){ echo $party_info['bank_acc_no']; } ?>" placeholder="Enter Bank Account Number">
										</div>
										<div class="form-group col-md-6">
											<label>IFSC Number</label>
											<input type="text" class="form-control form-control-sm" name="bank_ifsc_no" id="bank_ifsc_no" value="<?php if(isset($party_info)){ echo $party_info['bank_ifsc_no']; } ?>" placeholder="Enter IFSC Number">
										</div>
                    

										<!-- <div class="form-group col-md-3">
											<label>Password<span class="text-danger">*</span></label>
											<input type="password" class="form-control form-control-sm password" name="party_password" id="party_password" value="<?php if(isset($party_info)){ echo $party_info['party_password']; } ?>"  placeholder="Enter Password" required >
											<div class="invalid-feedback">
												Please enter Password
											</div>
										</div>
										<div class="form-group col-md-3">
											<label>Confirm Password<span class="text-danger">*</span></label>
											<input type="password" class="form-control form-control-sm con_password" id="party_password" value="<?php if(isset($party_info)){ echo $party_info['party_password']; } ?>"  placeholder="Confirm Password" required >
											<div class="invalid-feedback">
												Please Confirm Password
											</div>
										</div>

                    <div class="form-group col-md-3">
                      <label>party Image</label>
                      <input type="file" class="form-control form-control-sm valid_image" name="party_image" id="party_image">
                      <span class="f-12">.jpg, .jpeg, .png file & size must be less than 500kb</span>
                    </div>
                    <?php if(isset($party_info) && $party_info['party_image']){ ?>
                      <div class="form-group col-md-3">
                        <label>party Image</label><br>
                        <input type="hidden" name="old_party_image" value="<?php echo $party_info['party_image']; ?>">
                        <img width="150" src="<?php echo base_url(); ?>assets/images/party/<?php echo $party_info['party_image']; ?>" alt="">
                      </div>
                    <?php } ?> -->
                  </div>
                  <div class="card-footer clearfix" style="display: block;">
                    <div class="row">
                      <div class="col-md-6 text-left">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" name="party_status" id="party_status" value="0" <?php if(isset($party_info) && $party_info['party_status'] == 0){ echo 'checked'; } ?>>
                          <label for="party_status" class="custom-control-label">Disable This party</label>
                        </div>
                      </div>
                      <div class="col-md-6 text-right">
                        <a href="<?= base_url(); ?>Master/party" class="btn btn-sm btn-default px-4 mx-4">Cancel</a>
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
            <div class="card card-info card_shadow">
              <div class="card-header border-transparent">
                <h3 class="card-title"> <i class="fa fa-list"></i> List All Party</h3>
              </div>
              <div class="card-body p-2 overflow_x_auto">
                <table id="example1" class="table table-bordered table-striped w-100">
                  <thead>
										<tr>
											<th class="d-none">#</th>
											<th class="wt_50">Action</th>
											<th class="wt_75">Party Group</th>
											<th><i class="fa fa-user"></i> Party Name</th>
											<th class="wt_75"><i class="fa fa-mobile-alt"></i> Mobile</th>
											<th class="wt_50"><i class="fa fa-city"></i> City</th>
											<!-- <th class="wt_50">Image</th> -->
											<th class="wt_50">Status</th>
										</tr>
                  </thead>
                  <tbody>
                    <?php if(isset($party_list)){
                      $i=0; foreach ($party_list as $list) { $i++;
                        // $party_category_info = $this->Master_Model->get_info_arr_fields3('party_category_name', '', 'party_category_id', $list->party_category_id, '', '', '', '', 'admi_party_category');
												$city_info = $this->Master_Model->get_data('city','*',['city_id'=>$list->city_id],'`city_name` ASC','row_array');
                    ?>
                      <tr>
                        <td class="d-none"><?php echo $i; ?></td>
                        <td class="text-center">
                          <div class="btn-group">
														<?php if($role_id == 1 || in_array("party3", $role_access)){ ?>
															<a href="<?php echo base_url() ?>Master/edit_party/<?php echo $list->party_id; ?>" type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit text-primary"></i></a>
														<?php } if($role_id == 1 || in_array("party4", $role_access)){ ?>  
															<a href="<?php echo base_url() ?>Master/delete_party/<?php echo $list->party_id; ?>" type="button" class="btn btn-sm btn-default" onclick="return confirm('Delete this party');" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash text-danger"></i></a>
														<?php } ?>														
													</div>
                        </td>
												<td><?php 
													if($list->party_group_id == '1'){ echo 'Customer'; }
													elseif($list->party_group_id == '2'){ echo 'Vendor'; }
												?></td>
                        <td><?php echo $list->party_name; ?></td>
                        <td><?php echo $list->party_mobile; ?></td>
                        <td><?php if($city_info){ echo $city_info['city_name']; } ?></td>
                        <!-- <td><img width="50px" src="<?php echo base_url() ?>assets/images/party/<?php echo $list->party_image;  ?>" alt="party Image"> -->
												<td>
                          <?php if($list->party_status == 0){ echo '<span class="text-danger">Inactive</span>'; }
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


<script type="text/javascript">
	// Check Mobile Duplication..
	var party_mobile1 = $('#party_mobile').val();
	$('#party_mobile').on('change',function(){
		var party_mobile = $(this).val();
		$.ajax({
			url:'<?php echo base_url(); ?>Master/check_duplication',
			type: 'POST',
			data: {"column_name":"party_mobile",
			"column_val":party_mobile,
			"table_name":"admi_party"},
			context: this,
			success: function(result){
				if(result > 0){
					$('#party_mobile').val(party_mobile1);
					toastr.error(party_mobile+' Mobile No Exist.');
				}
			}
		});	
	});

	$("#country_id").on("change", function(){
    var country_id =  $('#country_id').find("option:selected").val();
    $.ajax({
      url:'<?php echo base_url(); ?>Master/get_state_by_country',
      type: 'POST',
      data: {"country_id":country_id},
      context: this,
      success: function(result){
        $('#state_id').html(result);
      }
    });
  });

  $("#state_id").on("change", function(){
    var state_id =  $('#state_id').find("option:selected").val();
    $.ajax({
      url:'<?php echo base_url(); ?>Master/get_city_by_state',
      type: 'POST',
      data: {"state_id":state_id},
      context: this,
      success: function(result){
        $('#city_id').html(result);
      }
    });
  });
</script>
