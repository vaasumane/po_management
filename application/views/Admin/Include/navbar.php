<?php
  $company_info = $this->Master_Model->get_info_arr_fields('company_name, company_shortname, company_logo','company_id', $sess_user_data['company_id'], 'company');
?>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link  f-14" data-toggle="dropdown" href="#" aria-expanded="false">
            <i class="far fa-user"></i>
            <b><?php echo $sess_user_data['user_name']; ?></b>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="row">
                <div class="col-6 text-center">
                    <a href="<?php echo base_url(); ?>User/user_profile" class="dropdown-item py-4">
                    <i class="far fa-user f-22"></i><br>Profile
                    </a>
                </div>
                <div class="col-6 text-center">
                    <a href="<?php echo base_url(); ?>User/dashboard" class="dropdown-item py-4">
                    <i class="fas fa-th f-22"></i><br>Dashboard
                    </a>
                </div>
                </div>
            <div class="dropdown-divider"></div>
            <a href="<?php echo base_url(); ?>User/logout" class="dropdown-item dropdown-footer"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?php echo base_url(); ?>User" class="brand-link">
		<?php if($company_info[0]['company_logo']){ ?>
		<img src="<?php echo base_url() ?>assets/images/master/<?php echo $company_info[0]['company_logo']; ?>" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
		<?php } ?>
		<span class="brand-text font-weight-light f-14"><?php echo $company_info[0]['company_shortname']; ?></span>
	</a>

  <!-- Sidebar -->
	<div class="sidebar">

		<!-- Sidebar User -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<?php if($sess_user_data['user_image']){ ?>
					<img src="<?php echo base_url() ?>assets/images/master/<?php echo $sess_user_data['user_image'];  ?>" class="img-circle elevation-2" alt="User Image">
				<?php } ?>
			</div>
			<div class="info">
				<a href="<?php echo base_url(); ?>User/user_profile" class="d-block f-14"><?php echo $sess_user_data['user_name']; ?></a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="<?php echo base_url(); ?>User/dashboard" class="nav-link head <?php if(isset($main_menu) && $main_menu == "Dashboard"){ echo 'active'; } ?>">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>Dashboard</p>
					</a>
				</li>
					
				<?php if($role_id == 1 || in_array("company", $role_access)){ ?>
					<li class="nav-item has-treeview  <?php if(isset($main_menu) && $main_menu == "Company"){ echo 'menu-open'; } ?>">
						<a href="#" class="nav-link head <?php if(isset($main_menu) && $main_menu == "Company"){ echo 'active'; } ?>">
								<i class="nav-icon fas fa-chart-pie"></i>
								<p>Company <i class="right fas fa-angle-left"></i> </p>
						</a>
						<ul class="nav nav-treeview">
							<?php if($role_id == 1 || in_array("company1", $role_access)){ ?>
								<li class="nav-item">
									<a <?php if(isset($update_company)){ echo 'href="'.$act_link.'"'; } else{ ?> href="<?php echo base_url(); ?>Company/company_list" <?php } ?> class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Company Information"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Company Information</p>
									</a>
								</li>
							<?php } ?>
							<?php if($role_id == 1 || in_array("user1", $role_access)){ ?>
								<li class="nav-item">
										<a <?php if(isset($update_user)){ echo 'href="'.$act_link.'"'; } else{ ?> href="<?php echo base_url(); ?>User/user_information" <?php } ?> class="nav-link <?php if(isset($sub_menu) && $sub_menu == "User"){ echo 'active'; } ?>">
												<i class="far fa-circle nav-icon"></i> <p>User</p>
										</a>
								</li>
							<?php } ?>
							<!-- <?php if($role_id == 1 || in_array("role1", $role_access)){ ?>
								<li class="nav-item">
										<a <?php if(isset($update_role)){ echo 'href="'.$act_link.'"'; } else{ ?> href="<?php echo base_url(); ?>Company/role" <?php } ?> class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Role"){ echo 'active'; } ?>">
												<i class="far fa-circle nav-icon"></i> <p>Role</p>
										</a>
								</li>
							<?php } ?> -->
						</ul>
					</li>
				<?php } ?>
				
				<?php if($role_id == 1 || in_array("master", $role_access)){ ?>
					<li class="nav-item has-treeview <?php if(isset($main_menu) && $main_menu == "Master"){ echo 'menu-open'; } ?>">
						<a href="#" class="nav-link head <?php if(isset($main_menu) && $main_menu == "Master"){ echo 'active'; } ?>">
							<i class="nav-icon fas fa-cogs"></i>
							<p> Master <i class="right fas fa-angle-left"></i> </p>
						</a>
						<ul class="nav nav-treeview">
							<?php if($role_id == 1 || in_array("unit1", $role_access)){ ?>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Master/unit" class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Unit"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Unit</p>
									</a>
								</li> 
							<?php } ?>
							<?php if($role_id == 1 || in_array("tax_rate1", $role_access)){ ?>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Master/tax_rate" class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Tax Rate"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Tax Rate</p>
									</a>
								</li> 
							<?php } ?>
							<!-- <?php if($role_id == 1 || in_array("slider1", $role_access)){ ?>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Master/slider" class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Slider"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Slider</p>
									</a>
								</li> 
							<?php } ?> -->
							<!-- <?php if($role_id == 1 || in_array("manufacturer1", $role_access)){ ?>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Master/manufacturer" class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Manufacturer"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Manufacturer</p>
									</a>
								</li> 
							<?php } ?> -->
							<?php if($role_id == 1 || in_array("party1", $role_access)){ ?>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Master/party" class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Party"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Party</p>
									</a>
								</li> 
							<?php } ?>
							<?php if($role_id == 1 || in_array("remark1", $role_access)){ ?>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Master/remark" class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Remark"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Remark</p>
									</a>
								</li> 
							<?php } ?>
							<?php if($role_id == 1 || in_array("grade1", $role_access)){ ?>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Master/grade" class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Grade"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Grade</p>
									</a>
								</li> 
							<?php } ?>
							<?php if($role_id == 1 || in_array("item_group1", $role_access)){ ?>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Master/item_group" class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Item Group"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Item Group</p>
									</a>
								</li> 
							<?php } ?>
							<?php if($role_id == 1 || in_array("process_type1", $role_access)){ ?>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Master/process_type" class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Process Type"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Process Type</p>
									</a>
								</li> 
							<?php } ?>
							<?php if($role_id == 1 || in_array("department1", $role_access)){ ?>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Master/department" class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Department"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Department</p>
									</a>
								</li> 
							<?php } ?>
							<?php if($role_id == 1 || in_array("process1", $role_access)){ ?>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Master/process" class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Process"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Process</p>
									</a>
								</li> 
							<?php } ?>
							<?php if($role_id == 1 || in_array("item1", $role_access)){ ?>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Master/item" class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Item"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Item</p>
									</a>
								</li> 
							<?php } ?>
						</ul>
					</li>
				<?php } ?>

				<?php if($role_id == 1 || in_array("transaction", $role_access)){ ?>
					<li class="nav-item has-treeview <?php if(isset($main_menu) && $main_menu == "Transaction"){ echo 'menu-open'; } ?>">
						<a href="#" class="nav-link head <?php if(isset($main_menu) && $main_menu == "Transaction"){ echo 'active'; } ?>">
							<i class="nav-icon fas fa-exchange-alt"></i>
							<p> Transaction <i class="right fas fa-angle-left"></i> </p>
						</a>
						<ul class="nav nav-treeview">
							<?php if($role_id == 1 || in_array("purchase_order1", $role_access)){ ?>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Transaction/purchase_order" class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Purchase Order"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Purchase Order</p>
									</a>
								</li> 
							<?php } ?>
							<?php if($role_id == 1 || in_array("job_process1", $role_access)){ ?>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Transaction/job_process" class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Job Process"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Job Process</p>
									</a>
								</li> 
							<?php } ?>
							<?php if($role_id == 1 || in_array("dispatch1", $role_access)){ ?>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Transaction/dispatch" class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Dispatch Entry"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Dispatch Entry</p>
									</a>
								</li> 
							<?php } ?>
							<?php if($role_id == 1 || in_array("transaction_entry1", $role_access)){ ?>
								<li class="nav-item">
									<a href="<?php echo base_url(); ?>Transaction/transaction_entry" class="nav-link <?php if(isset($sub_menu) && $sub_menu == "Rejection Entry"){ echo 'active'; } ?>">
										<i class="far fa-circle nav-icon"></i> <p>Rejection Entry</p>
									</a>
								</li> 
							<?php } ?>
						</ul>
					</li>
				<?php } ?>

				<?php if($role_id == 1 || in_array("report", $role_access)){ ?>				
					<li class="nav-item">
						<a href="<?php echo base_url(); ?>Report/po_report" class="nav-link head <?php if(isset($main_menu) && $main_menu == "Report"){ echo 'active'; } ?>">
							<i class="nav-icon fas fa-file"></i>
							<p>Report</p>
						</a>
					</li>
				<?php } ?>



			</ul>
		</nav>
	</div>
</aside>