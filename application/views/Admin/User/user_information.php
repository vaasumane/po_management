<!DOCTYPE html>
<html>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
			<!-- Content Header (Page header) -->
				<section class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h4 class="mb-0">User</h4>
							</div>
							<!-- <div class="col-sm-6">
								<ol class="breadcrumb float-sm-right">
									<li class="breadcrumb-item"><?php if(isset($main_menu)){ echo $main_menu; } ?></li>
									<li class="breadcrumb-item active"><?php if(isset($sub_menu)){ echo $sub_menu; } ?></a></li>
								</ol>
							</div> -->
						</div>
					</div>
				</section>

				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<div class="card <?php if(!isset($update)){ echo 'collapsed-card'; } ?> card-default card_shadow">
									
									<div class="card-header">
										<h3 class="card-title pt-1"> <?php if(isset($update)){ echo 'Update'; } else{ echo 'Add New'; } ?> User</h3>
										<div class="card-tools">
											<?php if(!isset($update)){
												if($role_id == 1 || in_array("user2", $role_access)){
													echo '<button type="button" class="btn btn-sm btn-primary" data-card-widget="collapse">Add New</button>';
												}
											} else{
												echo '<a href="'.base_url().'User/user_information" class="btn btn-xs btn-outline-info px-4 mx-4">Cancel Edit</a>';
											} ?>
										</div>
									</div>
				
									<div class="card-body p-0" <?php if(isset($update)){ echo 'style="display: block;"'; } else{ echo 'style="display: none;"'; } ?>>
										<form class="input_form m-0 needs-validation" novalidate id="form_action" role="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
											<div class="row p-4">
												<div class="form-group col-md-6 row">
													<div class="form-group col-md-12 mb-1">
														<label>Name of User<span class="text-danger">*</span></label>
														<input type="text" class="form-control form-control-sm alphabet capitalize" name="user_name" id="user_name" value="<?php if(isset($user_info)){ echo $user_info['user_name']; } ?>" autocomplete="off" placeholder="Enter Name of User" required >
														<div class="invalid-feedback">
															Please enter User Name.
														</div>
													</div>
													<div class="form-group col-md-6 select_sm">
														<label>Select Role<span class="text-danger">*</span></label>
														<select class="form-control select2" name="role_id" id="role_id" data-placeholder="Select Role" required>
															<option value="">Select Role</option>
															<?php if(isset($role_list)){ foreach ($role_list as $list) { ?>
																<option value="<?php echo $list->role_id; ?>" <?php if(isset($user_info) && $user_info['role_id'] == $list->role_id){ echo 'selected'; } if($list->role_status == 0){ echo 'disabled'; } ?> ><?php echo $list->role_name; ?></option>
															<?php } } ?>
														</select>
														<div class="invalid-feedback">
															Please select Role.
														</div>
													</div>
													<div class="form-group col-md-6">
														<label>Username</label>
														<input type="text" class="form-control form-control-sm " name="user_username" id="user_username" value="<?php if(isset($user_info)){ echo $user_info['user_username']; } ?>"  placeholder="Enter Username"  >
														<div class="invalid-feedback">
															Please enter Username
														</div>
													</div>


												</div>
												<div class="form-group col-md-6">
													<label>Address</label>
													<textarea class="form-control form-control-sm" name="user_address" id="user_address" rows="4"><?php if(isset($user_info)){ echo $user_info['user_address']; } ?></textarea>
												</div>

												<!-- <div class="form-group col-md-3">
													<label>Gender: </label>
													<div class="row">
														<div class="form-check col-6 col-md-6">
															<input class="form-check-input ml-1" type="radio" name="user_gender" value="Male" <?php if(isset($user_info) && $user_info['user_gender'] == 'Male'){ echo 'checked'; } elseif(!isset($user_info)){ echo 'checked'; } ?>>
															<label class="form-check-label ml-4">Male</label>
														</div>
														<div class="form-check col-6 col-md-6">
															<input class="form-check-input" type="radio" name="user_gender" value="Female" <?php if(isset($user_info) && $user_info['user_gender'] == 'Female'){ echo 'checked'; } ?>>
															<label class="form-check-label">Female</label>
														</div>
													</div>
												</div> -->
											
												<!-- <div class="form-group col-md-12">
												<label>Address</label>
												<textarea class="form-control form-control-sm" name="user_address" id="user_address" rows="3"><?php if(isset($user_info)){ echo $user_info['user_address']; } ?></textarea>
												</div>
												<div class="form-group col-md-4 select_sm">
												<label>Select Country</label>
												<select class="form-control select2" name="country_id" id="country_id" data-placeholder="Select Country" required>
													<option value="">Select Country</option>
													<?php if(isset($country_list)){ foreach ($country_list as $list) { ?>
													<option value="<?php echo $list->country_id; ?>" <?php if(isset($user_info) && $user_info['country_id'] == $list->country_id){ echo 'selected'; } ?>><?php echo $list->country_name; ?></option>
													<?php } } ?>
												</select>
												</div>
												<div class="form-group col-md-4 select_sm">
												<label>Select State</label>
												<select class="form-control select2" name="state_id" id="state_id" data-placeholder="Select State" required>
													<option value="">Select State</option>
													<?php if(isset($state_list)){ foreach ($state_list as $list) { ?>
													<option value="<?php echo $list->state_id; ?>" <?php if(isset($user_info) && $user_info['state_id'] == $list->state_id){ echo 'selected'; } ?>><?php echo $list->state_name; ?></option>
													<?php } } ?>
												</select>
												</div>
												<div class="form-group col-md-4 select_sm">
												<label>Select City</label>
												<select class="form-control select2" name="city_id" id="city_id" data-placeholder="Select City" required>
													<option value="">Select City</option>
													<?php if(isset($city_list)){ foreach ($city_list as $list) { ?>
													<option value="<?php echo $list->city_id; ?>" <?php if(isset($user_info) && $user_info['city_id'] == $list->city_id){ echo 'selected'; } ?>><?php echo $list->city_name; ?></option>
													<?php } } ?>
												</select>
												</div>
												<div class="form-group col-md-4">
												<label>Pin Code.</label>
												<input type="number" min="1" step="1" class="form-control form-control-sm" name="user_pincode" id="user_pincode" value="<?php if(isset($user_info)){ echo $user_info['user_pincode']; } ?>"  placeholder="Enter Pin Code." required >
												</div> -->

												<!-- <div class="form-group col-md-3 select_sm">
												<label>Salary Type</label>
												<select class="form-control select2" name="user_salary_type" id="user_salary_type" data-placeholder="Select City" >
													<option value="">Select Salary Type</option>
													<option value="Monthly Basis" <?php if(isset($user_info) && $user_info['user_salary_type'] == 'Monthly Basis'){ echo 'selected'; } ?> >Monthly Basis</option>
													<option value="Daily Basis" <?php if(isset($user_info) && $user_info['user_salary_type'] == 'Daily Basis'){ echo 'selected'; } ?>>Daily Basis</option>
												</select>
												</div>
												<div class="form-group col-md-3">
												<label>Salary</label>
												<input type="number" min="0" class="form-control form-control-sm" name="user_salary" id="user_salary" value="<?php if(isset($user_info)){ echo $user_info['user_salary']; } ?>"  placeholder="Enter Salary"  >
												</div> -->

												<div class="form-group col-md-3">
													<label>Mobile No.<span class="text-danger">*</span></label>
													<input type="number" min="5000000000" max="9999999999" step="1" class="form-control form-control-sm mobile_no" name="user_mobile" id="user_mobile" value="<?php if(isset($user_info)){ echo $user_info['user_mobile']; } ?>"  placeholder="Enter Mobile No." required >
													<div class="invalid-feedback">
														Please enter Mobile No.
													</div>
												</div>
												<div class="form-group col-md-3">
													<label>Email Id</label>
													<input type="email" class="form-control form-control-sm email" name="user_email" id="user_email" value="<?php if(isset($user_info)){ echo $user_info['user_email']; } ?>"  placeholder="Enter Email Id"  >
													<div class="invalid-feedback">
														Please enter Email Id.
													</div>
												</div>

												<div class="form-group col-md-3 select_sm">
													<label>Process Type<span class="text-danger">*</span></label>
													<select class="form-control select2" name="process_type_id[]" multiple id="process_type_id" data-placeholder="Select Process Type" required>
														<option value="">Select Process Type</option>
														<?php if(isset($process_type_list)){ foreach ($process_type_list as $list) { ?>
													<option value="<?php echo $list->process_type_id; ?>"
<?php echo (isset($selected_process) && in_array($list->process_type_id, $selected_process)) ? 'selected' : ''; ?>><?php echo $list->process_type_name; ?></option>
														
														<?php } } ?>
													</select>
												</div>
												<div class="form-group col-md-3 select_sm">
													<label>Department<span class="text-danger">*</span></label>
													<select class="form-control select2" name="department_id[]" multiple id="department_id" data-placeholder="Select Department" required>
														<option value="">Select Department</option>
														<?php if(isset($department_list)){ foreach ($department_list as $list) { ?>
														<option value="<?php echo $list->department_id; ?>"
<?php echo (isset($selected_department) && in_array($list->department_id, $selected_department)) ? 'selected' : ''; ?>><?php echo $list->department_name; ?></option>
														<?php } } ?>
													</select>
												</div>

												<div class="form-group col-md-3">
													<label>Password<span class="text-danger">*</span></label>
													<input type="password" class="form-control form-control-sm password" name="user_password" id="user_password" value="<?php if(isset($user_info)){ echo $user_info['user_password']; } ?>"  placeholder="Enter Password" required >
													<div class="invalid-feedback">
														Please enter Password.
													</div>
												</div>
												<div class="form-group col-md-3">
													<label>Confirm Password<span class="text-danger">*</span></label>
													<input type="password" class="form-control form-control-sm con_password" id="user_password" value="<?php if(isset($user_info)){ echo $user_info['user_password']; } ?>"  placeholder="Confirm Password" required >
													<div class="invalid-feedback">
														Please enter Password.
													</div>
												</div>

												<div class="form-group col-md-3">
													<label>User Image</label>
													<input type="file" class="form-control form-control-sm valid_image" name="user_image" id="user_image" >
													<span class="f-12">Select jpg,jpeg,png file. Size less than 500kb.</span>
												</div>
												<div class="form-group col-md-3">
													<?php if(isset($user_info) && $user_info['user_image']){ ?>
														<label>Uploaded User Image</label><br>
														<img width="200px" src="<?php echo base_url() ?>assets/images/master/<?php echo $user_info['user_image'];  ?>" alt="Slider Image">
														<input type="hidden" name="old_user_image" value="<?php echo $user_info['user_image']; ?>">
													<?php } ?>
												</div>
											</div>
											<div class="card-footer clearfix" style="display: block;">
												<div class="row">
													<div class="col-md-6 text-left">
														<div class="custom-control custom-checkbox">
															<input class="custom-control-input" type="checkbox" name="user_status" id="user_status" value="0" <?php if(isset($user_info) && $user_info['user_status'] == 0){ echo 'checked'; } ?>>
															<label for="user_status" class="custom-control-label">Disable This User</label>
														</div>
													</div>
													<div class="col-md-6 text-right">
														<a href="<?php echo base_url(); ?>User/user_information" class="btn btn-sm btn-default px-4 mx-4">Cancel</a>
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
									<div class="card-header  ">
										<h3 class="card-title"><i class="fa fa-list"></i> List All User</h3>
									</div>
									<div class="card-body p-2 overflow_x_auto">
										<table id="example1" class="table table-bordered table-striped w-100">
											<thead>
												<tr>
													<th class="d-none">#</th>
													<th class="wt_50">Action</th>
													<th>User Name</th>
													<!-- <th>City</th> -->
													<th class="wt_100">Mobile No.</th>
													<th class="">Email</th>
													<th class="wt_75">Role</th>
													<th class="wt_75">Status</th>
												</tr>
											</thead>
											<tbody>
												<?php $i=0; foreach ($user_list as $list) { $i++;
												// $city_details = $this->Master_Model->get_info_arr_fields('city_name','city_id', $list->city_id, 'city');
												$role_details = $this->Master_Model->get_info_arr_fields('role_name','role_id', $list->role_id, 'admi_role');
												?>
													<tr>
														<td class="d-none"><?php echo $i; ?></td>
														<td>
														<div class="btn-group">
															<?php if($role_id == 1 || in_array("user3", $role_access)){ ?>
															<a href="<?php echo base_url() ?>User/edit_user/<?php echo $list->user_id; ?>" type="button" class="btn btn-sm btn-default"><i class="fa fa-edit text-primary"></i></a>
															<?php } if($role_id == 1 || in_array("user4", $role_access)){ ?>
															<a href="<?php echo base_url() ?>User/delete_user/<?php echo $list->user_id; ?>" type="button" class="btn btn-sm btn-default" onclick="return confirm('Delete this User');"><i class="fa fa-trash text-danger"></i></a>
															<?php } ?>
														</div>
														</td>
														<td><?php echo $list->user_name; ?></td>
														<!-- <td><?php if($city_details){ echo $city_details[0]['city_name']; } ?></td> -->
														<td><?php echo $list->user_mobile; ?></td>
														<td><?php echo $list->user_email; ?></td>
														<td><?php if($role_details){ echo $role_details[0]['role_name']; } ?></td>
														<td>
														<?php if($list->user_status == 0){ echo '<span class="text-danger">Inactive</span>'; }
															else{ echo '<span class="text-success">Active</span>'; } ?>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>

						</div>
					</div>
				</section>

			</div>
		</div>


	</body>
</html>


<script type="text/javascript">
	// Check Mobile Duplication..
	var user_mobile1 = $('#user_mobile').val();
	$('#user_mobile').on('change',function(){
		var user_mobile = $(this).val();
		$.ajax({
			url:'<?php echo base_url(); ?>Master/check_duplication',
			type: 'POST',
			data: {"column_name":"user_mobile",
			"column_val":user_mobile,
			"table_name":"admi_user"},
			context: this,
			success: function(result){
				if(result > 0){
					$('#user_mobile').val(user_mobile1);
					toastr.error(user_mobile+' Mobile No Exist.');
				}
			}
		});	
	});

	// get_item_list_by_party...
	$(document).on("change","#process_type_id", function(){
    // var process_type_id  =  $(this).find("option:selected").val();
    var process_type_id  =  $(this).val();
    $.ajax({
      url:'<?php echo base_url(); ?>Master/get_department_by_process_type',
      type: 'POST',
      data: {"process_type_id":process_type_id },
      context: this,
      success: function(result){
				$('#department_id').html(result);
      }
    });
  });
</script>
