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
            <h4>Tax Rate</h4>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">

					<div class="col-md-6 ">
            <div class="card card-info card_shadow <?php //if(!isset($update)){ echo 'collapsed-card'; } ?>">
              <div class="card-header">
                <h3 class="card-title"> <?php if(isset($update)){ echo 'Update'; } else{ echo 'Add New'; } ?> Tax Rate</h3>
                <div class="card-tools">
                  <?php if(!isset($update)){
										// if($role_id == 1 || in_array("tax_rate2", $role_access)){
                    // 	echo '<button type="button" class="btn btn-sm btn-primary" data-card-widget="collapse">Add New</button>';
										// }
                  } else{
                    echo '<a href="'.base_url().'Master/tax_rate" type="button" class="btn btn-xs btn-outline-secondary" >Cancel Update</a>';
                  } ?>
                </div>
              </div>
              <!--  -->
                <div class="card-body p-0 " <?php //if(isset($update)){ echo 'style="display: block;"'; } else{ echo 'style="display: none;"'; } ?>>
                  <form class="input_form m-0 needs-validation" novalidate id="form_action" role="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
                    <div class="row p-4">
                      <div class="form-group col-md-12">
                        <label>Enter Tax Rate Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="tax_rate_name" id="tax_rate_name" value="<?php if(isset($tax_rate_info)){ echo $tax_rate_info['tax_rate_name']; } ?>" placeholder="Enter Tax Rate Name" required>
                      </div>
                      <div class="form-group col-md-12">
                        <label>Tax %<span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-sm" name="tax_rate_per" id="tax_rate_per" value="<?php if(isset($tax_rate_info)){ echo $tax_rate_info['tax_rate_per']; } ?>" placeholder="Enter Tax %" required>
                      </div>
                    </div>
                    <div class="card-footer clearfix" style="display: block;">
                      <div class="row">
                        <div class="col-4 text-left">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="tax_rate_status" id="tax_rate_status" value="0" <?php if(isset($tax_rate_info) && $tax_rate_info['tax_rate_status'] == 0){ echo 'checked'; } ?>>
                            <label for="tax_rate_status" class="custom-control-label">Disable This Tax Rate</label>
                          </div>
                        </div>
                        <div class="col-8 text-right">
													<a href="<?= base_url(); ?>Master/tax_rate" class="btn btn-sm btn-default px-4 mx-1">Cancel</a>
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



          <div class="col-md-6 ">
            <div class="card  card-info card_shadow">
              <div class="card-header">
                <h3 class="card-title">List All Tax Rate Information</h3>
              </div>
              <div class="card-body p-2 overflow_x_auto">
                <table id="example1" class="table table-bordered table-striped w-100">
                  <thead>
                  <tr>
                    <th class="d-none">#</th>
                    <th class="wt_50">Action</th>
                    <th>Tax Rate Name</th>
                    <th class="wt_50">Tax %</th>
                    <th class="wt_50">Status</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($tax_rate_list)){
                     $i=0; foreach ($tax_rate_list as $list) { $i++;
                    ?>
                    <tr>
                      <td class="d-none"><?php echo $i; ?></td>
                      <td class="text-center">
                        <div class="btn-group">
													<a href="<?php echo base_url() ?>Master/edit_tax_rate/<?php echo $list->tax_rate_id; ?>" type="button" class="btn btn-sm btn-default"><i class="fa fa-edit text-primary"></i></a>
													<a href="<?php echo base_url() ?>Master/delete_tax_rate/<?php echo $list->tax_rate_id; ?>" type="button" class="btn btn-sm btn-default" onclick="return confirm('Delete this Tax Rate Information');"><i class="fa fa-trash text-danger"></i></a>
												</div>
                      </td>
                      <td><?php echo $list->tax_rate_name; ?></td>
                      <td><?php echo $list->tax_rate_per; ?></td>
                      <td>
                        <?php if($list->tax_rate_status == 0){ echo '<span class="text-danger">Inactive</span>'; }
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
