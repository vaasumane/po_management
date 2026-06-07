<!DOCTYPE html>
<html>
<?php
$page = "make_information_list";
?>
<style>
  td{
    padding:2px 10px !important;
  }
</style>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="mb-0">Company</h4>
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
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title text-bold"><i class="fa fa-list"></i> List Company Information</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body overflow_x_auto">
              <table id="example1" class="table table-bordered table-striped w-100">
                <thead>
                <tr>
                  <th class="wt_50">#</th>
                  <th>Company Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th class="wt_50">Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                  $i=0;
                  foreach ($company_list as $list) {
                    $i++;
                  ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $list->company_name; ?></td>
                      <td><?php echo $list->company_mob1; ?></td>
                      <td><?php echo $list->company_email; ?></td>
                      <td class="text-center">
                        <?php if($role_id == 1 || in_array("company", $role_access)){ ?>
                          <a href="<?php echo base_url(); ?>Company/edit_company/<?php echo $list->company_id; ?>"> <i class="fa fa-edit"></i> </a>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  </div>
</body>
</html>
