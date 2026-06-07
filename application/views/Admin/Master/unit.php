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
            <h4>Unit</h4>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">

				<?php //if($role_id == 1 || in_array("unit2", $role_access) || ( isset($update) && in_array("unit3", $role_access) ) ){ ?>

          <div class="col-md-6">
            <div class="card card-info card_shadow <?php //if(!isset($update)){ echo 'collapsed-card'; } ?> card-default">
              <div class="card-header">
                <h3 class="card-title"> <?php if(isset($update)){ echo 'Update'; } else{ echo 'Add New'; } ?> Unit</h3>
                <div class="card-tools">
                  <?php if(!isset($update)){
										// if($role_id == 1 || in_array("unit2", $role_access)){
                    // 	echo '<button type="button" class="btn btn-sm btn-primary" data-card-widget="collapse">Add New</button>';
										// }
                  } else{
										echo '<a href="'.base_url().'Master/unit" type="button" class="btn btn-xs btn-outline-secondary" >Cancel Update</a>';
									} ?>
                </div>
              </div>
              <!--  -->
              <div class="card-body p-0" <?php //if(isset($update)){ echo 'style="display: block;"'; } else{ echo 'style="display: none;"'; } ?>>
                <form class="input_form m-0 needs-validation" novalidate id="form_action" role="form" action="" method="post" autocomplete="off">
                  <div class="row p-4">
                    <div class="form-group col-md-12">
                      <label>Unit Name<span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm alphabet" name="unit_name" id="unit_name" value="<?php if(isset($unit_info)){ echo $unit_info['unit_name']; } ?>"  placeholder="Enter Name of Unit" required >
                    </div>
                    <div class="form-group col-md-12">
                      <label>Short Name<span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm" name="unit_short_name" id="unit_short_name" value="<?php if(isset($unit_info)){ echo $unit_info['unit_short_name']; } ?>"  placeholder="Enter Short Name of Unit" required >
                    </div>
                  </div>
                  <div class="card-footer clearfix" style="display: block;">
                    <div class="row">
                      <div class="col-md-4 text-left">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" name="unit_status" id="unit_status" value="0" <?php if(isset($unit_info) && $unit_info['unit_status'] == 0){ echo 'checked'; } ?>>
                          <label for="unit_status" class="custom-control-label">Disable This Unit</label>
                        </div>
                      </div>
                      <div class="col-md-8 text-right">
                        <a href="<?= base_url(); ?>Master/unit" class="btn btn-sm btn-default px-4 mx-4">Cancel</a>
                        <?php if(isset($update)){
													if($role_id == 1 || in_array("unit3", $role_access)){
														echo '<button class="btn btn-sm btn-primary float-right px-4">Update</button>';
													}
												} else{
													if($role_id == 1 || in_array("unit2", $role_access)){
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
					<?php //} ?>

          <div class="col-md-6">
            <div class="card card-info card_shadow">
              <div class="card-header border-transparent">
                <h3 class="card-title">List All Unit</h3>
              </div>
              <div class="card-body p-2 overflow_x_auto" >
                <table id="example1" class="table table-bordered table-striped w-100">
                  <thead>
                  <tr>
                    <th class="d-none">#</th>
                    <th class="wt_50">Action</th>
                    <th>Unit Name</th>
                    <th>Short Name</th>
                    <th class="wt_75">Status</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($unit_list)){
                      $i=0; foreach ($unit_list as $list) { $i++; ?>
                      <tr>
                        <td class="d-none"><?php echo $i; ?></td>
                        <td class="text-center">
                          <div class="btn-group">
														<?php //if($role_id == 1 || in_array("unit3", $role_access)){ ?>
															<a href="<?php echo base_url() ?>Master/edit_unit/<?php echo $list->unit_id; ?>" type="button" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit text-primary"></i></a>
														<?php //} if($role_id == 1 || in_array("unit4", $role_access)){ ?>  
															<a href="<?php echo base_url() ?>Master/delete_unit/<?php echo $list->unit_id; ?>" type="button" class="btn btn-sm btn-default" onclick="return confirm('Delete this Unit');" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash text-danger"></i></a>
														<?php //} ?>
													</div>
                        </td>
                        <td><?php echo $list->unit_name; ?></td>
                        <td><?php echo $list->unit_short_name; ?></td>
                        <td>
                          <?php if($list->unit_status == 0){ echo '<span class="text-danger">Inactive</span>'; }
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
