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
            <h4>Slider</h4>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">

        <?php if($role_id == 1 || in_array("slider2", $role_access) || ( isset($update) && in_array("slider3", $role_access) ) ){ ?>

          <div class="col-md-6">
            <div class="card card-info card_shadow <?php //if(!isset($update)){ echo 'collapsed-card'; } ?> card-default card_shadow">
              <div class="card-header">
                <h3 class="card-title"> <?php if(isset($update)){ echo 'Update'; } else{ echo 'Add New'; } ?> Slider</h3>
                <div class="card-tools">
                  <?php if(!isset($update)){
										// if($role_id == 1 || in_array("slider2", $role_access)){
                    // 	echo '<button type="button" class="btn btn-sm btn-primary" data-card-widget="collapse">Add New</button>';
										// }
                  } else{
                    echo '<a href="'.base_url().'Master/slider" type="button" class="btn btn-xs btn-outline-secondary px-4 mx-4" >Cancel Edit</a>';
                  } ?>
                </div>
              </div>
              <!--  -->
                <div class="card-body px-0 py-0 " >
                  <form class="input_form m-0 needs-validation" novalidate id="form_action" role="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                    <div class="row p-4">     
												
												<!-- <div class="form-group col-md-12 select_sm">
													<label>Slider Possition<span class="text-danger">*</span></label>
													<select class="form-control select2" name="slider_possition" id="slider_possition" data-placeholder="Select Slider Possition" required>
														<option value="">Select Slider Possition</option>
														<option value="1" <?php if(isset($slider_info) && $slider_info['slider_possition'] == '1'){ echo 'selected'; } ?>>Top Slider</option>
														<option value="2" <?php if(isset($slider_info) && $slider_info['slider_possition'] == '2'){ echo 'selected'; } ?>>Index Page - Middle</option>
														<option value="3" <?php if(isset($slider_info) && $slider_info['slider_possition'] == '3'){ echo 'selected'; } ?>>Index Page - Bottom</option>
													</select>
                        </div> -->

                        <div class="form-group col-md-12">
													<label>Slider Title<span class="text-danger">*</span></label>
													<input type="text" class="form-control form-control-sm" name="slider_name" id="slider_name" value="<?php if(isset($slider_info)){ echo $slider_info['slider_name']; } ?>" placeholder="Enter Slider Title" required>
													<div class="invalid-feedback">
														Please enter Slider Title.
													</div>
												</div>

                        <div class="form-group col-md-6">
                            <label>Slider Image<span class="text-danger">*</span></label>
                            <input type="file" class="form-control form-control-sm valid_image" name="slider_image" id="slider_image" <?php if(!isset($slider_info)){ echo ' required'; } ?> >
                            <label>.jpg/.jpeg/.png file. Size less than 500kb.</label>
                        </div>
                        <div class="form-group col-md-6">
                            <?php if(isset($slider_info) && $slider_info['slider_image']){ ?>
                            <img width="150px" src="<?php echo base_url() ?>assets/images/slider/<?php echo $slider_info['slider_image'];  ?>" alt="Slider Image">
                            <input type="hidden" name="old_slider_image" value="<?php echo $slider_info['slider_image']; ?>">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card-footer clearfix" style="display: block;">
                      <div class="row">
                        <div class="col-md-4 text-left">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="slider_status" id="slider_status" value="0" <?php if(isset($slider_info) && $slider_info['slider_status'] == 0){ echo 'checked'; } ?>>
                            <label for="slider_status" class="custom-control-label">Disable This Slider</label>
                          </div>
                        </div>
                        <div class="col-md-8 text-right">
                          <a href="<?= base_url(); ?>Master/slider" class="btn btn-sm btn-default px-4 mx-4">Cancel</a>
                          <?php if(isset($update)){
														if($role_id == 1 || in_array("slider3", $role_access)){
															echo '<button class="btn btn-sm btn-primary float-right px-4">Update</button>';
														}
													} else{
														if($role_id == 1 || in_array("slider2", $role_access)){
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
                <h3 class="card-title"> <i class="fa fa-list"></i> All Slider List</h3>
              </div>
              <div class="card-body p-2 overflow_x_auto">
                <table id="example1" class="table table-bordered table-striped w-100">
                  <thead>
                    <tr>
                      <th class="d-none">#</th>
                      <th class="wt_50">Action</th>
                      <th>Slider</th>
                      <!-- <th>Possition</th> -->
                      <th class="wt_50">Image</th>
                      <th class="wt_50">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($slider_list)){
                     $i=0; foreach ($slider_list as $list) { $i++;
                        // $slider_details = $this->Master_Model->get_data('olo_slider','slider_name',['slider_id'=>$list->main_slider_id],'','row_array');
                    ?>
                    <tr>
                      <td class="d-none"><?php echo $i; ?></td>
                      <td class="text-center">
                        <div class="btn-group">
													<?php if($role_id == 1 || in_array("slider3", $role_access)){ ?>  
														<a href="<?php echo base_url() ?>Master/edit_slider/<?php echo $list->slider_id; ?>" type="button" class="btn btn-sm btn-default"><i class="fa fa-edit text-primary" data-toggle="tooltip" data-placement="bottom" title="Edit"></i></a>
													<?php } if($role_id == 1 || in_array("slider4", $role_access)){ ?>  
														<a href="<?php echo base_url() ?>Master/delete_slider/<?php echo $list->slider_id; ?>" type="button" class="btn btn-sm btn-default" onclick="return confirm('Delete this Slider Information');" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash text-danger"></i></a>
													<?php } ?>
												</div>
                      </td>
                      <td><?php echo $list->slider_name; ?></td>
                      <!-- <td><?php
											if($list->slider_possition == '1'){
												echo 'Top Slider';
											} ?></td> -->
                      <td class="text-center"><img width="50px" src="<?php echo base_url() ?>assets/images/slider/<?php echo $list->slider_image;  ?>" alt="Slider Image"></td>
                      <td>
                          <?php if($list->slider_status == 0){ echo '<span class="text-danger">Inactive</span>'; }
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


<!-- <script type="text/javascript">
	// Check Duplication..
	var slider_name1 = $('#slider_name').val();
	$('#slider_name').on('change',function(){
		var slider_name = $(this).val();
		$.ajax({
			url:'<?php echo base_url(); ?>Master/check_duplication',
			type: 'POST',
			data: {"column_name":"slider_name",
			"column_val":slider_name,
			"table_name":"satg_slider"},
			context: this,
			success: function(result){
				if(result > 0){
					$('#slider_name').val(slider_name1);
					toastr.error(slider_name+' Exist.');
				}
			}
		});	
	});
</script> -->
