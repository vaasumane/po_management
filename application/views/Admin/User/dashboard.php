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
          <div class="col-sm-12 text-center mt-3">
            <h4>Dashboard</h4>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <hr>
        <h5 class="mb-3"> Summary</h5>
        <div class="row">

					<?php if($role_id == '1'){ ?>
						<div class="col-md-3 col-6">
							<a class="text-dark" href="<?php echo base_url(); ?>User/user_information">
								<div class="info-box">
									<span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">User</span>
										<span class="info-box-number"><?php echo $user_cnt; ?></span>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-3 col-6">
							<a class="text-dark" href="<?php echo base_url(); ?>Master/party">
								<div class="info-box">
									<span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Party</span>
										<span class="info-box-number"><?php echo $party_cnt; ?></span>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-3 col-6">
							<a class="text-dark" href="<?php echo base_url(); ?>Master/department">
								<div class="info-box">
									<span class="info-box-icon bg-primary elevation-1"><i class="fas fa-list"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Department</span>
										<span class="info-box-number"><?php echo $department_cnt; ?></span>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-3 col-6">
							<a class="text-dark" href="<?php echo base_url(); ?>Master/process_type">
								<div class="info-box">
									<span class="info-box-icon bg-success elevation-1"><i class="fas fa-list"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Process Type</span>
										<span class="info-box-number"><?php echo $process_type_cnt; ?></span>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-3 col-6">
							<a class="text-dark" href="<?php echo base_url(); ?>Master/item">
								<div class="info-box">
									<span class="info-box-icon bg-info elevation-1"><i class="fas fa-list"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Item</span>
										<span class="info-box-number"><?php echo $item_cnt; ?></span>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-3 col-6">
							<a class="text-dark" href="<?php echo base_url(); ?>Transaction/purchase_order">
								<div class="info-box">
									<span class="info-box-icon bg-primary elevation-1"><i class="fas fa-list"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Purchase Order</span>
										<span class="info-box-number"><?php echo $purchase_order_cnt; ?></span>
									</div>
								</div>
							</a>
						</div>
					<?php } ?>
						<div class="col-md-3 col-6">
							<a class="text-dark" href="<?php echo base_url(); ?>Transaction/job_process">
								<div class="info-box">
									<span class="info-box-icon bg-success elevation-1"><i class="fas fa-list"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Job Process</span>
										<span class="info-box-number"><?php echo $job_process_cnt; ?></span>
									</div>
								</div>
							</a>
						</div>
						
					<?php if($role_id == '1'){ ?>
						<div class="col-md-3 col-6">
							<a class="text-dark" href="<?php echo base_url(); ?>Transaction/dispatch">
								<div class="info-box">
									<span class="info-box-icon bg-info elevation-1"><i class="fas fa-list"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Dispatch</span>
										<span class="info-box-number"><?php echo $dispatch_cnt; ?></span>
									</div>
								</div>
							</a>
						</div>
					<?php } ?>

          <!-- 
          <div class="col-md-3 col-6">
            <a class="text-dark" href="<?php echo base_url(); ?>Master/customer">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Customer</span>
                  <span class="info-box-number"><?php echo $customer_cnt; ?></span>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-3 col-6">
            <a class="text-dark" href="<?php echo base_url(); ?>Master/unit">
              <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-balance-scale"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Unit</span>
                  <span class="info-box-number"><?php echo $unit_cnt; ?></span>
                </div>
              </div>
            </a>
          </div>
					
          <div class="col-md-3 col-6">
            <a class="text-dark" href="<?php echo base_url(); ?>Master/manufacturer">
              <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-industry"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Manufacturer</span>
                  <span class="info-box-number"><?php echo $manufacturer_cnt; ?></span>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-3 col-6">
            <a class="text-dark" href="<?php echo base_url(); ?>Master/product">
              <div class="info-box">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cog"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Product</span>
                  <span class="info-box-number"><?php echo $product_cnt; ?></span>
                </div>
              </div>
            </a>
          </div> -->

        </div>

				




      </div>

      </div><!-- /.container-fluid -->
    </section>
  </div>

</body>
</html>
