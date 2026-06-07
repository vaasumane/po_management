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
            <h4>Remark</h4>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">

        <?php if($role_id == 1 || in_array("remark2", $role_access) || ( isset($update) && in_array("remark3", $role_access) ) ){ ?>

          <div class="col-md-6">
            <div class="card card-info card_shadow <?php //if(!isset($update)){ echo 'collapsed-card'; } ?> card-default card_shadow">
              <div class="card-header">
                <h3 class="card-title"> <?php if(isset($update)){ echo 'Update'; } else{ echo 'Add New'; } ?> Remark</h3>
                <div class="card-tools">
                  <?php if(!isset($update)){
										// if($role_id == 1 || in_array("remark2", $role_access)){
                    // 	echo '<button type="button" class="btn btn-sm btn-primary" data-card-widget="collapse">Add New</button>';
										// }
                  } else{
                    echo '<a href="'.base_url().'Master/remark" type="button" class="btn btn-xs btn-outline-secondary px-4 mx-4" >Cancel Edit</a>';
                  } ?>
                </div>
              </div>
              <!--  -->
							<div class="card-body px-0 py-0 " >
								<form class="input_form m-0 needs-validation" novalidate id="form_action" role="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
									<div class="row p-4">
										<div class="form-group col-md-12">
											<label>Remark Name<span class="text-danger">*</span></label>
											<input type="text" class="form-control form-control-sm" name="remark_name" id="remark_name" value="<?php if(isset($remark_info)){ echo $remark_info['remark_name']; } ?>" placeholder="Enter Remark Name" required>
										</div>
										<div class="form-group col-md-12">
											<label>Description</label>
											<textarea class="form-control form-control-sm" rows="5" name="remark_descr" id="remark_descr" placeholder="Enter Remark Description" ><?php if(isset($remark_info)){ echo $remark_info['remark_descr']; } ?></textarea>
										</div>
									</div>
									<div class="card-footer clearfix" style="display: block;">
										<div class="row">
											<div class="col-md-6 text-left">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" type="checkbox" name="remark_status" id="remark_status" value="0" <?php if(isset($remark_info) && $remark_info['remark_status'] == 0){ echo 'checked'; } ?>>
													<label for="remark_status" class="custom-control-label">Disable This Remark</label>
												</div>
											</div>
											<div class="col-md-6 text-right">
												<a href="<?= base_url(); ?>Master/remark" class="btn btn-sm btn-default px-4 mx-1">Cancel</a>
												<?php if(isset($update)){
													if($role_id == 1 || in_array("remark3", $role_access)){
														echo '<button class="btn btn-sm btn-primary float-right px-4">Update</button>';
													}
												} else{
													if($role_id == 1 || in_array("remark2", $role_access)){
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
				<?php } ?>


          <div class="col-md-6 ">
            <div class="card card-info card_shadow">
              <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-list"></i> All Remark List</h3>
              </div>
              <div class="card-body p-2 overflow_x_auto">
                <table id="example2" class="table table-bordered table-striped w-100">
                  <thead>
                    <tr>
                      <th class="d-none">#</th>
                      <th class="wt_50">Action</th>
                      <th>Remark</th>
                      <th class="wt_50">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($remark_list)){
                     $i=0; foreach ($remark_list as $list) { $i++;
                    ?>
                    <tr>
                      <td class="d-none"><?php echo $i; ?></td>
                      <td class="text-center">
                        <div class="btn-group">
													<?php if($role_id == 1 || in_array("remark3", $role_access)){ ?>  
														<a href="<?php echo base_url() ?>Master/edit_remark/<?php echo $list->remark_id; ?>" type="button" class="btn btn-sm btn-default"><i class="fa fa-edit text-primary" data-toggle="tooltip" data-placement="bottom" title="Edit"></i></a>
													<?php } if($role_id == 1 || in_array("remark4", $role_access)){ ?>  
														<a href="<?php echo base_url() ?>Master/delete_remark/<?php echo $list->remark_id; ?>" type="button" class="btn btn-sm btn-default" onclick="return confirm('Delete this Remark Information');" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash text-danger"></i></a>
													<?php } ?>
												</div>
                      </td>
                      <td><?php echo $list->remark_name; ?></td>
                      <td>
                          <?php if($list->remark_status == 0){ echo '<span class="text-danger">Inactive</span>'; }
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
	var remark_name1 = $('#remark_name').val();
	$('#remark_name').on('change',function(){
		var remark_name = $(this).val();
		$.ajax({
			url:'<?php echo base_url(); ?>Master/check_duplication',
			type: 'POST',
			data: {"column_name":"remark_name",
			"column_val":remark_name,
			"table_name":"admi_remark"},
			context: this,
			success: function(result){
				if(result > 0){
					$('#remark_name').val(remark_name1);
					toastr.error(remark_name+' Exist.');
				}
			}
		});	
	});
</script>
