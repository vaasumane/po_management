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
            <h4>Item Group</h4>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">

        <?php if($role_id == 1 || in_array("item_group2", $role_access) || ( isset($update) && in_array("item_group3", $role_access) ) ){ ?>

          <div class="col-md-6">
            <div class="card card-info card_shadow <?php //if(!isset($update)){ echo 'collapsed-card'; } ?> card-default card_shadow">
              <div class="card-header">
                <h3 class="card-title"> <?php if(isset($update)){ echo 'Update'; } else{ echo 'Add New'; } ?> Item Group</h3>
                <div class="card-tools">
                  <?php if(!isset($update)){
										// if($role_id == 1 || in_array("item_group2", $role_access)){
                    // 	echo '<button type="button" class="btn btn-sm btn-primary" data-card-widget="collapse">Add New</button>';
										// }
                  } else{
                    echo '<a href="'.base_url().'Master/item_group" type="button" class="btn btn-xs btn-outline-secondary px-4 mx-4" >Cancel Edit</a>';
                  } ?>
                </div>
              </div>
              <!--  -->
							<div class="card-body px-0 py-0 " >
								<form class="input_form m-0 needs-validation" novalidate id="form_action" role="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
									<div class="row p-4">

										<div class="form-group col-md-12">
											<label>Item Group Name<span class="text-danger">*</span></label>
											<input type="text" class="form-control form-control-sm" name="item_group_name" id="item_group_name" value="<?php if(isset($item_group_info)){ echo $item_group_info['item_group_name']; } ?>" placeholder="Enter Item Group Name" required>
										</div>                     

										<div class="form-group col-md-12">
												<label>Description</label>
												<textarea class="form-control form-control-sm" rows="5" name="item_group_descr" id="item_group_descr" placeholder="Enter Item Group Description" ><?php if(isset($item_group_info)){ echo $item_group_info['item_group_descr']; } ?></textarea>
										</div>
									</div>
									<div class="card-footer clearfix" style="display: block;">
										<div class="row">
											<div class="col-md-4 text-left">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" type="checkbox" name="item_group_status" id="item_group_status" value="0" <?php if(isset($item_group_info) && $item_group_info['item_group_status'] == 0){ echo 'checked'; } ?>>
													<label for="item_group_status" class="custom-control-label">Disable This Item Group</label>
												</div>
											</div>
											<div class="col-md-8 text-right">
												<a href="<?= base_url(); ?>Master/item_group" class="btn btn-sm btn-default px-4 mx-4">Cancel</a>
												<?php if(isset($update)){
													if($role_id == 1 || in_array("item_group3", $role_access)){
														echo '<button class="btn btn-sm btn-primary float-right px-4">Update</button>';
													}
												} else{
													if($role_id == 1 || in_array("item_group2", $role_access)){
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
                <h3 class="card-title"> <i class="fa fa-list"></i> All Item Group List</h3>
              </div>
              <div class="card-body p-2 overflow_x_auto">
                <table id="example2" class="table table-bordered table-striped w-100">
                  <thead>
                    <tr>
                      <th class="d-none">#</th>
                      <th class="wt_50">Action</th>
                      <th>Item Group</th>
                      <th class="wt_50">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($item_group_list)){
                     $i=0; foreach ($item_group_list as $list) { $i++;
                    ?>
                    <tr>
                      <td class="d-none"><?php echo $i; ?></td>
                      <td class="text-center">
                        <div class="btn-group">
													<?php if($role_id == 1 || in_array("item_group3", $role_access)){ ?>  
														<a href="<?php echo base_url() ?>Master/edit_item_group/<?php echo $list->item_group_id; ?>" type="button" class="btn btn-sm btn-default"><i class="fa fa-edit text-primary" data-toggle="tooltip" data-placement="bottom" title="Edit"></i></a>
													<?php } if($role_id == 1 || in_array("item_group4", $role_access)){ ?>  
														<a href="<?php echo base_url() ?>Master/delete_item_group/<?php echo $list->item_group_id; ?>" type="button" class="btn btn-sm btn-default" onclick="return confirm('Delete this Item Group Information');" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash text-danger"></i></a>
													<?php } ?>
												</div>
                      </td>
                      <td><?php echo $list->item_group_name; ?></td>
                      <td>
                          <?php if($list->item_group_status == 0){ echo '<span class="text-danger">Inactive</span>'; }
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
	var item_group_name1 = $('#item_group_name').val();
	$('#item_group_name').on('change',function(){
		var item_group_name = $(this).val();
		$.ajax({
			url:'<?php echo base_url(); ?>Master/check_duplication',
			type: 'POST',
			data: {"column_name":"item_group_name",
			"column_val":item_group_name,
			"table_name":"admi_item_group"},
			context: this,
			success: function(result){
				if(result > 0){
					$('#item_group_name').val(item_group_name1);
					toastr.error(item_group_name+' Exist.');
				}
			}
		});	
	});
</script>
