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
            <h4>Manufacturer</h4>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">

        <?php if($role_id == 1 || in_array("manufacturer2", $role_access) || ( isset($update) && in_array("manufacturer3", $role_access) ) ){ ?>

          <div class="col-md-6">
            <div class="card card-info card_shadow <?php //if(!isset($update)){ echo 'collapsed-card'; } ?> card-default card_shadow">
              <div class="card-header">
                <h3 class="card-title"> <?php if(isset($update)){ echo 'Update'; } else{ echo 'Add New'; } ?> Manufacturer</h3>
                <div class="card-tools">
                  <?php if(!isset($update)){
										// if($role_id == 1 || in_array("manufacturer2", $role_access)){
                    // 	echo '<button type="button" class="btn btn-sm btn-primary" data-card-widget="collapse">Add New</button>';
										// }
                  } else{
                    echo '<a href="'.base_url().'Master/manufacturer" type="button" class="btn btn-xs btn-outline-secondary px-4 mx-4" >Cancel Edit</a>';
                  } ?>
                </div>
              </div>
              <!--  -->
                <div class="card-body px-0 py-0 " >
                  <form class="input_form m-0 needs-validation" novalidate id="form_action" role="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                    <div class="row p-4">

                        <div class="form-group col-md-12">
													<label>Manufacturer Name<span class="text-danger">*</span></label>
													<input type="text" class="form-control form-control-sm" name="manufacturer_name" id="manufacturer_name" value="<?php if(isset($manufacturer_info)){ echo $manufacturer_info['manufacturer_name']; } ?>" placeholder="Enter Manufacturer Name" required>
                        </div>                     

                        <div class="form-group col-md-12">
                            <label>Description</label>
                            <textarea class="form-control form-control-sm" rows="5" name="manufacturer_descr" id="manufacturer_descr" placeholder="Enter Manufacturer Description" ><?php if(isset($manufacturer_info)){ echo $manufacturer_info['manufacturer_descr']; } ?></textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Manufacturer Image</label>
                            <input type="file" class="form-control form-control-sm valid_image" name="manufacturer_image" id="manufacturer_image" >
                            <label>.jpg/.jpeg/.png file. Size less than 500kb.</label>
                        </div>
                        <div class="form-group col-md-6">
                            <?php if(isset($manufacturer_info) && $manufacturer_info['manufacturer_image']){ ?>
                            <img width="150px" src="<?php echo base_url() ?>assets/images/manufacturer/<?php echo $manufacturer_info['manufacturer_image'];  ?>" alt="Manufacturer Image">
                            <input type="hidden" name="old_manufacturer_image" value="<?php echo $manufacturer_info['manufacturer_image']; ?>">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card-footer clearfix" style="display: block;">
                      <div class="row">
                        <div class="col-md-4 text-left">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="manufacturer_status" id="manufacturer_status" value="0" <?php if(isset($manufacturer_info) && $manufacturer_info['manufacturer_status'] == 0){ echo 'checked'; } ?>>
                            <label for="manufacturer_status" class="custom-control-label">Disable This Manufacturer</label>
                          </div>
                        </div>
                        <div class="col-md-8 text-right">
                          <a href="<?= base_url(); ?>Master/manufacturer" class="btn btn-sm btn-default px-4 mx-4">Cancel</a>
                          <?php if(isset($update)){
														if($role_id == 1 || in_array("manufacturer3", $role_access)){
															echo '<button class="btn btn-sm btn-primary float-right px-4">Update</button>';
														}
													} else{
														if($role_id == 1 || in_array("manufacturer2", $role_access)){
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
                <h3 class="card-title"> <i class="fa fa-list"></i> All Manufacturer List</h3>
              </div>
              <div class="card-body p-2 overflow_x_auto">
                <table id="example2" class="table table-bordered table-striped w-100">
                  <thead>
                    <tr>
                      <th class="d-none">#</th>
                      <th class="wt_50">Action</th>
                      <th>Manufacturer</th>
                      <th class="wt_50">Image</th>
                      <th class="wt_50">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($manufacturer_list)){
                     $i=0; foreach ($manufacturer_list as $list) { $i++;
                    ?>
                    <tr>
                      <td class="d-none"><?php echo $i; ?></td>
                      <td class="text-center">
                        <div class="btn-group">
													<?php if($role_id == 1 || in_array("manufacturer3", $role_access)){ ?>  
														<a href="<?php echo base_url() ?>Master/edit_manufacturer/<?php echo $list->manufacturer_id; ?>" type="button" class="btn btn-sm btn-default"><i class="fa fa-edit text-primary" data-toggle="tooltip" data-placement="bottom" title="Edit"></i></a>
													<?php } if($role_id == 1 || in_array("manufacturer4", $role_access)){ ?>  
														<a href="<?php echo base_url() ?>Master/delete_manufacturer/<?php echo $list->manufacturer_id; ?>" type="button" class="btn btn-sm btn-default" onclick="return confirm('Delete this Manufacturer Information');" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash text-danger"></i></a>
													<?php } ?>
												</div>
                      </td>
                      <td><?php echo $list->manufacturer_name; ?></td>
                      <td class="text-center"><img width="50px" src="<?php echo base_url() ?>assets/images/manufacturer/<?php echo $list->manufacturer_image;  ?>" alt="Manufacturer Image"></td>
                      <td>
                          <?php if($list->manufacturer_status == 0){ echo '<span class="text-danger">Inactive</span>'; }
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
	var manufacturer_name1 = $('#manufacturer_name').val();
	$('#manufacturer_name').on('change',function(){
		var manufacturer_name = $(this).val();
		$.ajax({
			url:'<?php echo base_url(); ?>Master/check_duplication',
			type: 'POST',
			data: {"column_name":"manufacturer_name",
			"column_val":manufacturer_name,
			"table_name":"admi_manufacturer"},
			context: this,
			success: function(result){
				if(result > 0){
					$('#manufacturer_name').val(manufacturer_name1);
					toastr.error(manufacturer_name+' Exist.');
				}
			}
		});	
	});
</script>
