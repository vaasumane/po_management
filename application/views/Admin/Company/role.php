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
            <h4 class="mb-0">Role</h4>
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
            <div class="card <?php if(!isset($update)){ echo 'collapsed-card'; } ?> card-default">
              <div class="card-header">
                <h3 class="card-title"> <?php if(isset($update)){ echo 'Update'; } else{ echo 'Add New'; } ?> Role</h3>
                <div class="card-tools">
                  <?php if(!isset($update)){
                    if($role_id == 1 || in_array("role2", $role_access)){
                      echo '<button type="button" class="btn btn-sm btn-primary" data-card-widget="collapse">Add New</button>';
                    }
                  } else{
                    echo '<a href="'.base_url().'Company/role" class="btn btn-xs btn-outline-secondary px-4 mx-4">Cancel Edit</a>';
                  } ?>
                </div>
              </div>
              <!--  -->
              <div class="card-body p-0" <?php if(isset($update)){ echo 'style="display: block;"'; } else{ echo 'style="display: none;"'; } ?>>
                <form class="input_form m-0 needs-validation" novalidate id="form_action" role="form" action="" method="post">
                  <div class="row p-4">
                    <div class="form-group col-md-6 offset-md-3">
                      <label>Role Name<span class="text-danger">*</span></label>
                      <input type="text" class="form-control form-control-sm alphabet" name="role_name" id="role_name" value="<?php if(isset($role_info)){ echo $role_info['role_name']; } ?>"  placeholder="Enter Name of Role" required >
											<div class="invalid-feedback">
												Please enter Role Name.
											</div>
										</div>
                    <div class="form-group col-md-6 offset-md-3">
                      <label>Role Description</label>
                      <textarea class="form-control form-control-sm" name="role_descr" id="role_descr" rows="4"><?php if(isset($role_info)){ echo $role_info['role_descr']; } ?></textarea>
                    </div>

                    <div class="col-md-12">
                      <hr>
                      <label>Role Permissions</label>

                      <?php if(isset($role_info)){
                         $up_role_access = explode(',',$role_info['role_access']);
                       } ?>

                      <table class="table table-bordered  mb-3">
                        <tr>
                          <td colspan="5">
                            <input type="checkbox" id="company_menu" name="role_access[]" value="company" <?php if(isset($role_info) && in_array("company", $up_role_access)){ echo ' checked'; } ?> > &nbsp;<label class="f-16">Company Menu</label>
                          </td>
                        </tr>
                        <tr>
                          <td class="wt_200" ><label>Company Info</label></td>
                          <td>
                            <input type="checkbox" class="read" menu="company_menu" name="role_access[]" value="company1" <?php if(isset($role_info) && in_array("company1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                          </td>
                          <td colspan="3">
                            <input type="checkbox" class="update" menu="company_menu" name="role_access[]" value="company3" <?php if(isset($role_info) && in_array("company3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                          </td>
                        </tr>
                        <tr>
                          <td><label>User</label></td>
                          <td>
                            <input type="checkbox" class="read" menu="company_menu" name="role_access[]" value="user1" <?php if(isset($role_info) && in_array("user1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                          </td>
                          <td>
                            <input type="checkbox" class="create" menu="company_menu" name="role_access[]" value="user2" <?php if(isset($role_info) && in_array("user2", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Create
                          </td>
                          <td>
                            <input type="checkbox" class="update" menu="company_menu" name="role_access[]" value="user3" <?php if(isset($role_info) && in_array("user3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                          </td>
                          <td>
                            <input type="checkbox" class="delete" menu="company_menu" name="role_access[]" value="user4" <?php if(isset($role_info) && in_array("user4", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Delete
                          </td>
                        </tr>
                        <tr>
                          <td><label>Role</label></td>
                          <td>
                            <input type="checkbox" class="read" menu="company_menu" name="role_access[]" value="role1" <?php if(isset($role_info) && in_array("role1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                          </td>
                          <td>
                            <input type="checkbox" class="create" menu="company_menu" name="role_access[]" value="role2" <?php if(isset($role_info) && in_array("role2", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Create
                          </td>
                          <td>
                            <input type="checkbox" class="update" menu="company_menu" name="role_access[]" value="role3" <?php if(isset($role_info) && in_array("role3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                          </td>
                          <td>
                            <input type="checkbox" class="delete" menu="company_menu" name="role_access[]" value="role4" <?php if(isset($role_info) && in_array("role4", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Delete
                          </td>
                        </tr>
                       
                      </table>
                      
                      <table class="table table-bordered  mb-3">
                        <tr>
                          <td colspan="5">
                            <input type="checkbox" id="master_menu" name="role_access[]" value="master" <?php if(isset($role_info) && in_array("master", $up_role_access)){ echo ' checked'; } ?> > &nbsp;<label class="f-16">Master Menu</label>
                          </td>
                        </tr>
                        <tr>
                          <td class="wt_200" ><label>Unit</label></td>
                          <td>
                            <input type="checkbox" class="read" menu="master_menu" name="role_access[]" value="unit1" <?php if(isset($role_info) && in_array("unit1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                          </td>
                          <td>
                            <input type="checkbox" class="read" menu="master_menu" name="role_access[]" value="unit2" <?php if(isset($role_info) && in_array("unit2", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Create
                          </td>
                          <td>
                            <input type="checkbox" class="update" menu="master_menu" name="role_access[]" value="unit3" <?php if(isset($role_info) && in_array("unit3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                          </td>
                          <td colspan="3">
                            <input type="checkbox" class="update" menu="master_menu" name="role_access[]" value="unit4" <?php if(isset($role_info) && in_array("unit4", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Delete
                          </td>
                        </tr>
                        <tr>
                          <td><label>Tax Rate</label></td>
                          <td>
                            <input type="checkbox" class="read" menu="master_menu" name="role_access[]" value="tax_rate1" <?php if(isset($role_info) && in_array("tax_rate1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                          </td>
                          <td>
                            <input type="checkbox" class="create" menu="master_menu" name="role_access[]" value="tax_rate2" <?php if(isset($role_info) && in_array("tax_rate2", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Create
                          </td>
                          <td>
                            <input type="checkbox" class="update" menu="company_menu" name="role_access[]" value="tax_rate3" <?php if(isset($role_info) && in_array("tax_rate3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                          </td>
                          <td>
                            <input type="checkbox" class="delete" menu="master_menu" name="role_access[]" value="tax_rate4" <?php if(isset($role_info) && in_array("tax_rate4", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Delete
                          </td>
                        </tr>
                        <tr>
                          <td><label>Party</label></td>
                          <td>
                            <input type="checkbox" class="read" menu="master_menu" name="role_access[]" value="party1" <?php if(isset($role_info) && in_array("party1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                          </td>
                          <td>
                            <input type="checkbox" class="create" menu="master_menu" name="role_access[]" value="party2" <?php if(isset($role_info) && in_array("party2", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Create
                          </td>
                          <td>
                            <input type="checkbox" class="update" menu="master_menu" name="role_access[]" value="party3" <?php if(isset($role_info) && in_array("party3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                          </td>
                          <td>
                            <input type="checkbox" class="delete" menu="master_menu" name="role_access[]" value="party4" <?php if(isset($role_info) && in_array("party4", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Delete
                          </td>
                        </tr>
                        
                        <tr>
                          <td><label>Remark</label></td>
                          <td>
                            <input type="checkbox" class="read" menu="master_menu" name="role_access[]" value="remark1" <?php if(isset($role_info) && in_array("remark1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                          </td>
                          <td>
                            <input type="checkbox" class="create" menu="master_menu" name="role_access[]" value="remark2" <?php if(isset($role_info) && in_array("remark2", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Create
                          </td>
                          <td>
                            <input type="checkbox" class="update" menu="master_menu" name="role_access[]" value="remark3" <?php if(isset($role_info) && in_array("remark3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                          </td>
                          <td>
                            <input type="checkbox" class="delete" menu="master_menu" name="role_access[]" value="remark4" <?php if(isset($role_info) && in_array("remark4", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Delete
                          </td>
                        </tr>
                        
                        <tr>
                          <td><label>Grade</label></td>
                          <td>
                            <input type="checkbox" class="read" menu="master_menu" name="role_access[]" value="grade1" <?php if(isset($role_info) && in_array("grade1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                          </td>
                          <td>
                            <input type="checkbox" class="create" menu="master_menu" name="role_access[]" value="grade2" <?php if(isset($role_info) && in_array("grade2", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Create
                          </td>
                          <td>
                            <input type="checkbox" class="update" menu="master_menu" name="role_access[]" value="grade3" <?php if(isset($role_info) && in_array("grade3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                          </td>
                          <td>
                            <input type="checkbox" class="delete" menu="master_menu" name="role_access[]" value="grade4" <?php if(isset($role_info) && in_array("grade4", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Delete
                          </td>
                        </tr>
                        
                        <tr>
                            <td><label>Process Type</label></td>
                            <td>
                                <input type="checkbox" class="read" menu="master_menu" name="role_access[]" value="process_type1" <?php if(isset($role_info) && in_array("process_type1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                            </td>
                            <td>
                                <input type="checkbox" class="create" menu="master_menu" name="role_access[]" value="process_type2" <?php if(isset($role_info) && in_array("process_type2", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Create
                            </td>
                            <td>
                                <input type="checkbox" class="update" menu="master_menu" name="role_access[]" value="process_type3" <?php if(isset($role_info) && in_array("process_type3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                            </td>
                            <td>
                                <input type="checkbox" class="delete" menu="master_menu" name="role_access[]" value="process_type4" <?php if(isset($role_info) && in_array("process_type4", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Delete
                            </td>
                        </tr>
                        
                        <tr>
                            <td><label>Item Group</label></td>
                            <td>
                                <input type="checkbox" class="read" menu="master_menu" name="role_access[]" value="item_group1" <?php if(isset($role_info) && in_array("item_group1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                            </td>
                            <td>
                                <input type="checkbox" class="create" menu="master_menu" name="role_access[]" value="item_group2" <?php if(isset($role_info) && in_array("itemgroup2", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Create
                            </td>
                            <td>
                                <input type="checkbox" class="update" menu="master_menu" name="role_access[]" value="item_group3" <?php if(isset($role_info) && in_array("item_group3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                            </td>
                            <td>
                                <input type="checkbox" class="delete" menu="master_menu" name="role_access[]" value="item_group4" <?php if(isset($role_info) && in_array("item_group4", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Delete
                            </td>
                        </tr>
                        
                        <tr>
                            <td><label>Department</label></td>
                            <td>
                                <input type="checkbox" class="read" menu="master_menu" name="role_access[]" value="department1" <?php if(isset($role_info) && in_array("department1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                            </td>
                            <td>
                                <input type="checkbox" class="create" menu="master_menu" name="role_access[]" value="department2" <?php if(isset($role_info) && in_array("department2", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Create
                            </td>
                            <td>
                                <input type="checkbox" class="update" menu="master_menu" name="role_access[]" value="department3" <?php if(isset($role_info) && in_array("department3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                            </td>
                            <td>
                                <input type="checkbox" class="delete" menu="master_menu" name="role_access[]" value="department4" <?php if(isset($role_info) && in_array("department4", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Delete
                            </td>
                        </tr>
                        
                        <tr>
                            <td><label>Process</label></td>
                            <td>
                                <input type="checkbox" class="read" menu="master_menu" name="role_access[]" value="process1" <?php if(isset($role_info) && in_array("process1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                            </td>
                            <td>
                                <input type="checkbox" class="create" menu="master_menu" name="role_access[]" value="process2" <?php if(isset($role_info) && in_array("process2", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Create
                            </td>
                            <td>
                                <input type="checkbox" class="update" menu="master_menu" name="role_access[]" value="process3" <?php if(isset($role_info) && in_array("process3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                            </td>
                            <td>
                                <input type="checkbox" class="delete" menu="master_menu" name="role_access[]" value="process4" <?php if(isset($role_info) && in_array("process4", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Delete
                            </td>
                        </tr>
                        
                        <tr>
                            <td><label>Item</label></td>
                            <td>
                                <input type="checkbox" class="read" menu="master_menu" name="role_access[]" value="item1" <?php if(isset($role_info) && in_array("item1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                            </td>
                            <td>
                                <input type="checkbox" class="create" menu="master_menu" name="role_access[]" value="item2" <?php if(isset($role_info) && in_array("item2", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Create
                            </td>
                            <td>
                                <input type="checkbox" class="update" menu="master_menu" name="role_access[]" value="item3" <?php if(isset($role_info) && in_array("item3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                            </td>
                            <td>
                                <input type="checkbox" class="delete" menu="master_menu" name="role_access[]" value="item4" <?php if(isset($role_info) && in_array("item4", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Delete
                            </td>
                        </tr>
                       
                      </table>
                      
                      
                      <table class="table table-bordered  mb-3">
                        <tr>
                          <td colspan="5">
                            <input type="checkbox" id="transaction_menu" name="role_access[]" value="transaction" <?php if(isset($role_info) && in_array("transaction", $up_role_access)){ echo ' checked'; } ?> > &nbsp;<label class="f-16">Transaction Menu</label>
                          </td>
                        </tr>
                        <tr>
                          <td class="wt_200" ><label>Purchase Order</label></td>
                          <td>
                            <input type="checkbox" class="read" menu="transaction_menu" name="role_access[]" value="purchase_order1" <?php if(isset($role_info) && in_array("purchase_order1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                          </td>
                          <td>
                            <input type="checkbox" class="read" menu="transaction_menu" name="role_access[]" value="purchase_order2" <?php if(isset($role_info) && in_array("purchase_order2", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Create
                          </td>
                          <td>
                            <input type="checkbox" class="update" menu="transaction_menu" name="role_access[]" value="purchase_order3" <?php if(isset($role_info) && in_array("purchase_order3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                          </td>
                          <td colspan="3">
                            <input type="checkbox" class="update" menu="transaction_menu" name="role_access[]" value="purchase_order4" <?php if(isset($role_info) && in_array("purchase_order4", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Delete
                          </td>
                        </tr>
                        <tr>
                            <td class="wt_200"><label>Job Process</label></td>
                            <td>
                                <input type="checkbox" class="read" menu="transaction_menu" name="role_access[]" value="job_process1" <?php if(isset($role_info) && in_array("job_process1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                            </td>
                            <td>
                                <input type="checkbox" class="create" menu="transaction_menu" name="role_access[]" value="job_process2" <?php if(isset($role_info) && in_array("job_process2", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Create
                            </td>
                            <td>
                                <input type="checkbox" class="update" menu="transaction_menu" name="role_access[]" value="job_process3" <?php if(isset($role_info) && in_array("job_process3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                            </td>
                            <td colspan="3">
                                <input type="checkbox" class="delete" menu="transaction_menu" name="role_access[]" value="job_process4" <?php if(isset($role_info) && in_array("job_process4", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Delete
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="wt_200"><label>Dispatch Entry</label></td>
                            <td>
                                <input type="checkbox" class="read" menu="transaction_menu" name="role_access[]" value="dispatch1" <?php if(isset($role_info) && in_array("dispatch1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                            </td>
                            <td>
                                <input type="checkbox" class="create" menu="transaction_menu" name="role_access[]" value="dispatch2" <?php if(isset($role_info) && in_array("dispatch2", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Create
                            </td>
                            <td>
                                <input type="checkbox" class="update" menu="transaction_menu" name="role_access[]" value="dispatch3" <?php if(isset($role_info) && in_array("dispatch3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                            </td>
                            <td colspan="3">
                                <input type="checkbox" class="delete" menu="transaction_menu" name="role_access[]" value="dispatch4" <?php if(isset($role_info) && in_array("dispatch4", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Delete
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="wt_200"><label>Rejection Entry</label></td>
                            <td>
                                <input type="checkbox" class="read" menu="transaction_menu" name="role_access[]" value="transaction_entry1" <?php if(isset($role_info) && in_array("transaction_entry1", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Read
                            </td>
                            <td>
                                <input type="checkbox" class="create" menu="transaction_menu" name="role_access[]" value="transaction_entry2" <?php if(isset($role_info) && in_array("transaction_entry2", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Create
                            </td>
                            <td>
                                <input type="checkbox" class="update" menu="transaction_menu" name="role_access[]" value="transaction_entry3" <?php if(isset($role_info) && in_array("transaction_entry3", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Update
                            </td>
                            <td colspan="3">
                                <input type="checkbox" class="delete" menu="transaction_menu" name="role_access[]" value="transaction_entry4" <?php if(isset($role_info) && in_array("transaction_entry4", $up_role_access)){ echo ' checked'; } ?>> &nbsp;Delete
                            </td>
                        </tr>
                       
                      </table>

                    </div>
                  </div>
                  <div class="card-footer clearfix" style="display: block;">
                    <div class="row">
                      <div class="col-md-6 text-left">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" name="role_status" id="role_status" value="0" <?php if(isset($role_info) && $role_info['role_status'] == 0){ echo 'checked'; } ?>>
                          <label for="role_status" class="custom-control-label">Disable This Role</label>
                        </div>
                      </div>
                      <div class="col-md-6 text-right">
                        <a href="<?= base_url(); ?>Company/role" class="btn btn-sm btn-default px-4 mx-4">Cancel</a>
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
            <div class="card card-info">
              <div class="card-header border-transparent">
                <h3 class="card-title text-bold"><i class="fa fa-list"></i> List All Role</h3>
              </div>
              <div class="card-body p-2 overflow_x_auto">
                <table id="example1" class="table table-bordered table-striped w-100">
                  <thead>
                  <tr>
                    <th class="d-none">#</th>
                    <th class="wt_50">Action</th>
                    <th>Role Name</th>
                    <th class="wt_75">Status</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php $i=0; foreach ($role_list as $list) { $i++; ?>
                      <tr>
                        <td class="d-none"><?php echo $i; ?></td>
                        <td>
                          <?php if($list->role_id != '1'){ ?>
                            <div class="btn-group">
                              <?php if($role_id == 1 || in_array("role3", $role_access)){ ?>
                                <a href="<?php echo base_url() ?>Company/edit_role/<?php echo $list->role_id; ?>" type="button" class="btn btn-sm btn-default"><i class="fa fa-edit text-primary"></i></a>
                              <?php } if($role_id == 1 || in_array("role4", $role_access)){ ?>
                                <a href="<?php echo base_url() ?>Company/delete_role/<?php echo $list->role_id; ?>" type="button" class="btn btn-sm btn-default" onclick="return confirm('Delete this Role');"><i class="fa fa-trash text-danger"></i></a>
                              <?php } ?>
                            </div>
                          <?php } ?>
                        </td>
                        <td><?php echo $list->role_name; ?></td>
                        <td>
                          <?php if($list->role_status == 0){ echo '<span class="text-danger">Inactive</span>'; }
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

	<!-- Loader Modal -->
	<div class="modal fade" id="loader_form_submit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document" style="height:100vh !important;">
			<div class="loader m-auto"></div> 
		</div>
	</div>

</body>
</html>

<script>
	(function() {
		'use strict';
		window.addEventListener('load', function() {
			// Fetch all the forms we want to apply custom Bootstrap validation styles to
			var forms = document.getElementsByClassName('needs-validation');
			// Loop over them and prevent submission
			var validation = Array.prototype.filter.call(forms, function(form) {
				form.addEventListener('submit', function(event) {
					if (form.checkValidity() === false) {
						event.preventDefault();
						event.stopPropagation();
						toastr.error('*Fields Required');
					} else{
						$('#loader_form_submit').modal({backdrop: 'static', keyboard: false});
					}
					form.classList.add('was-validated');
				}, false);
			});
		}, false);
	})();
</script>

<script type="text/javascript">
	// Check Mobile Duplication..
	var role_name1 = $('#role_name').val();
	$('#role_name').on('change',function(){
		var role_name = $(this).val();
		$.ajax({
			url:'<?php echo base_url(); ?>Master/check_duplication',
			type: 'POST',
			data: {"column_name":"role_name",
			"column_val":role_name,
			"table_name":"admi_role"},
			context: this,
			success: function(result){
				if(result > 0){
					$('#role_name').val(role_name1);
					toastr.error(role_name+' Exist.');
				}
			}
		});	
	});
</script>

<script type="text/javascript">
  $(document).on('change', '.create, .update, .delete, .print', function() {
    if(this.checked == true) {
        $(this).closest('tr').find('.read').prop('checked',true);
    }
  });

  $(document).on('change', '.read', function() {
    if(this.checked == false) {
      $(this).closest('tr').find('.create').prop('checked',false);
      $(this).closest('tr').find('.update').prop('checked',false);
      $(this).closest('tr').find('.delete').prop('checked',false);
      $(this).closest('tr').find('.print').prop('checked',false);
    }
  });

  $("input[type='checkbox']").change(function() {
    if(this.checked == true) {
      var menu_name = $(this).attr('menu');
      $('#'+menu_name).prop('checked',true);
    }
  });


// On check Menu checkbox select all sub checkbox...

  // Company Menu
  $(document).on('change', '#company_menu', function(){
    if(this.checked == true) {
      $("input[menu='company_menu']").prop('checked',true);
    } else{
      $("input[menu='company_menu']").prop('checked',false);
    }
  });
  // Master Menu
  $(document).on('change', '#master_menu', function(){
    if(this.checked == true) {
      $("input[menu='master_menu']").prop('checked',true);
    } else{
      $("input[menu='master_menu']").prop('checked',false);
    }
  });
  // Product Menu
  $(document).on('change', '#product_menu', function(){
    if(this.checked == true) {
      $("input[menu='product_menu']").prop('checked',true);
    } else{
      $("input[menu='product_menu']").prop('checked',false);
    }
  });
  
    // Transaction Menu
  $(document).on('change', '#transaction_menu', function(){
    if(this.checked == true) {
      $("input[menu='transaction_menu']").prop('checked',true);
    } else{
      $("input[menu='transaction_menu']").prop('checked',false);
    }
  });
	

// If No any sub menu checked then uncheck Mani Menu.

  $(document).on('change', "input[menu='company_menu']", function(){
    var check = 0;
    var uncheck = 0;
    $("input[menu='company_menu']").each(function(){
      if(this.checked == true){
        check++;
      } else{
        uncheck++;
      }
    });

    if(check == 0){
      $("#company_menu").prop('checked',false);
    } else{
      $("#company_menu").prop('checked',true);
    }
  });

  $(document).on('change', "input[menu='master_menu']", function(){
    var check = 0;
    var uncheck = 0;
    $("input[menu='master_menu']").each(function(){
      if(this.checked == true){
        check++;
      } else{
        uncheck++;
      }
    });

    if(check == 0){
      $("#master_menu").prop('checked',false);
    } else{
      $("#master_menu").prop('checked',true);
    }
  });

	$(document).on('change', "input[menu='product_menu']", function(){
		var check = 0;
		var uncheck = 0;
		$("input[menu='product_menu']").each(function(){
			if(this.checked == true){
				check++;
			} else{
				uncheck++;
			}
		});

		if(check == 0){
			$("#product_menu").prop('checked',false);
		} else{
			$("#product_menu").prop('checked',true);
		}
	});

// transaction_menu

	$(document).on('change', "input[menu='transaction_menu']", function(){
		var check = 0;
		var uncheck = 0;
		$("input[menu='transaction_menu']").each(function(){
			if(this.checked == true){
				check++;
			} else{
				uncheck++;
			}
		});

		if(check == 0){
			$("#transaction_menu").prop('checked',false);
		} else{
			$("#transaction_menu").prop('checked',true);
		}
	});

</script>
