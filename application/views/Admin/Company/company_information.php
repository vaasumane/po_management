<!DOCTYPE html>
<html>
<?php
  $page = "company_information";
?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <div class="content-wrapper">
  <section class="content-header pt-0 pb-2">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12 text-left mt-3">
            <h4>Company</h4>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-10 offset-md-1">
            <div class="card card-info card_shadow">
              <div class="card-header">
                <h3 class="card-title">Edit Company Information</h3>
              </div>
              <form class="input_form needs-validation" novalidate action="" method="post" enctype="multipart/form-data" autocomplete="off">
                <div class="card-body row">
                  <div class="form-group col-md-12">
                    <label>Company Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" name="company_name" id="company_name" value="<?php if(isset($company_info)){ echo $company_info['company_name']; } ?>" placeholder="Enter Company Name" required>
										<div class="invalid-feedback">
											Please enter Company Name.
										</div>
									</div>
                  <div class="form-group col-md-12">
                    <label>Company Short Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" name="company_shortname" id="company_shortname" value="<?php if(isset($company_info)){ echo $company_info['company_shortname']; } ?>" placeholder="Enter Company Short Name" required>
										<div class="invalid-feedback">
											Please enter Short Company Name.
										</div>
									</div>
                  <div class="form-group col-md-12">
                    <label>Address<span class="text-danger">*</span></label>
                    <textarea class="form-control form-control-sm" rows="3" name="company_address" id="company_address" placeholder="Enter Company Address" required><?php if(isset($company_info)){ echo $company_info['company_address']; } ?></textarea>
                  </div>
                  <div class="form-group col-md-3 select_sm">
                    <label>Select Country</label>
                    <select class="form-control select2" name="country_id" id="country_id" data-placeholder="Select Country" required>
                      <option value="">Select Country</option>
                      <?php if(isset($country_list)){ foreach ($country_list as $list) { ?>
                      <option value="<?php echo $list->country_id; ?>" <?php if(isset($company_info) && $company_info['country_id'] == $list->country_id){ echo 'selected'; } ?>><?php echo $list->country_name; ?></option>
                      <?php } } ?>
                    </select>
                  </div>
                  <div class="form-group col-md-3 select_sm">
                    <label>Select State<span class="text-danger">*</span></label>
                    <select class="form-control select2" name="state_id" id="state_id" data-placeholder="Select State" required>
                      <option value="">Select State</option>
                      <?php if(isset($state_list)){ foreach ($state_list as $list) { ?>
                      <option value="<?php echo $list->state_id; ?>" <?php if(isset($company_info) && $company_info['state_id'] == $list->state_id){ echo 'selected'; } ?>><?php echo $list->state_name; ?></option>
                      <?php } } ?>
                    </select>
										<div class="invalid-feedback">
											Please select State.
										</div>
                  </div>
                  <div class="form-group col-md-3 select_sm">
                    <label>Select City<span class="text-danger">*</span></label>
                    <select class="form-control select2" name="city_id" id="city_id" data-placeholder="Select City" required>
                      <option value="">Select City</option>
                      <?php if(isset($city_list)){ foreach ($city_list as $list) { ?>
                      <option value="<?php echo $list->city_id; ?>" <?php if(isset($company_info) && $company_info['city_id'] == $list->city_id){ echo 'selected'; } ?>><?php echo $list->city_name; ?></option>
                      <?php } } ?>
                    </select>
										<div class="invalid-feedback">
											Please select City.
										</div>
                  </div>
                  <div class="form-group col-md-3">
                    <label>Pin/Zip Code</label>
                    <input type="number" min="100000" max="999999" step="1" class="form-control form-control-sm pincode_no" name="company_pincode" id="company_pincode" value="<?php if(isset($company_info)){ echo $company_info['company_pincode']; } ?>" placeholder="Pin/Zip Code">
                  </div>

                  <div class="form-group col-md-3">
                    <label>GST No.</label>
                    <input type="text" class="form-control form-control-sm gst_no" name="company_gst_no" id="company_gst_no" value="<?php if(isset($company_info)){ echo $company_info['company_gst_no']; } ?>" placeholder="Enter GST No.">
                  </div>
									<div class="form-group col-md-3">
                    <label>PAN No.</label>
                    <input type="text" class="form-control form-control-sm pan_no" name="company_pan_no" id="company_pan_no" value="<?php if(isset($company_info)){ echo $company_info['company_pan_no']; } ?>" placeholder="Enter Pan No.">
                  </div>

									<div class="form-group col-md-3 select_sm">
                    <label>TCS Applicable<span class="text-danger">*</span></label>
                    <select class="form-control select2" name="company_tcs_applicable" id="company_tcs_applicable" data-placeholder="TCS Applicable" required>
                      <option value="">TCS Applicable</option>
                      <option value="1" <?php if(isset($company_info) && $company_info['company_tcs_applicable'] == '1'){ echo 'selected'; } ?> >Yes</option>
                      <option value="0" <?php if(isset($company_info) && $company_info['company_tcs_applicable'] == '0'){ echo 'selected'; } ?> >No</option>
                    </select>
										<div class="invalid-feedback">
											Please select Value.
										</div>
                  </div>
									<div class="form-group col-md-3">
                    <label>TAN No.</label>
                    <input type="text" class="form-control form-control-sm " name="company_tan_no" id="company_tan_no" value="<?php if(isset($company_info)){ echo $company_info['company_tan_no']; } ?>" placeholder="Enter TAN No.">
                  </div>

                  <!-- <div class="form-group col-md-6">
                    <label>Statecode</label>
                    <input type="number" class="form-control form-control-sm" name="company_statecode" id="company_statecode" value="<?php if(isset($company_info)){ echo $company_info['company_statecode']; } ?>" placeholder="Statecode">
                  </div> -->

                  <div class="form-group col-md-3">
                    <label>Mobile No. 1<span class="text-danger">*</span></label>
                    <input type="number" class="form-control form-control-sm mobile_no" name="company_mob1" id="company_mob1" value="<?php if(isset($company_info)){ echo $company_info['company_mob1']; } ?>" placeholder="Mobile No. 1" required>
										<div class="invalid-feedback">
											Please enter Mobile No.
										</div>
									</div>
                  <div class="form-group col-md-3">
                    <label>Mobile No. 2 / Landline No.</label>
                    <input type="number" class="form-control form-control-sm" name="company_mob2" id="company_mob2" value="<?php if(isset($company_info)){ echo $company_info['company_mob2']; } ?>" placeholder="Mobile No. 2">
                  </div>

                  <div class="form-group col-md-3">
                    <label>Email Id<span class="text-danger">*</span></label>
                    <input type="email" class="form-control form-control-sm email" name="company_email" id="company_email" value="<?php if(isset($company_info)){ echo $company_info['company_email']; } ?>" placeholder="Email" required>
										<div class="invalid-feedback">
											Please enter Email Id
										</div>
									</div>
                  <div class="form-group col-md-3">
                    <label>Website</label>
                    <input type="text" class="form-control form-control-sm" name="company_website" id="company_website" value="<?php if(isset($company_info)){ echo $company_info['company_website']; } ?>" placeholder="Website">
                  </div>                  

                  <div class="form-group col-md-3">
                    <label>DL No. 1</label>
                    <input type="text" class="form-control form-control-sm" name="company_lic1" id="company_lic1" value="<?php if(isset($company_info)){ echo $company_info['company_lic1']; } ?>" placeholder="Enter DL No. 1">
                  </div>
                  <div class="form-group col-md-3">
                    <label>DL No. 2</label>
                    <input type="text" class="form-control form-control-sm" name="company_lic2" id="company_lic2" value="<?php if(isset($company_info)){ echo $company_info['company_lic2']; } ?>" placeholder="Enter Licence No. 2">
                  </div>
											
									<div class="form-group col-md-12 mb-2">
										<hr class="m-0">
									</div>



                  <div class="form-group col-md-6">
                    <label>Bank Name</label>
                    <input type="text" class="form-control form-control-sm" name="bank_name" id="bank_name" value="<?php if(isset($company_info)){ echo $company_info['bank_name']; } ?>" placeholder="Enter Bank Name">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Bank Branch Name</label>
                    <input type="text" class="form-control form-control-sm" name="bank_branch" id="bank_branch" value="<?php if(isset($company_info)){ echo $company_info['bank_branch']; } ?>" placeholder="Enter Bank Branch Name">
                  </div>

                  <div class="form-group col-md-6">
                    <label>Bank Account Number</label>
                    <input type="number" step="1" class="form-control form-control-sm" name="bank_acc_no" id="bank_acc_no" value="<?php if(isset($company_info)){ echo $company_info['bank_acc_no']; } ?>" placeholder="Enter Bank Account Number">
                  </div>
                  <div class="form-group col-md-6">
                    <label>IFSC Number</label>
                    <input type="text" class="form-control form-control-sm" name="bank_ifsc_no" id="bank_ifsc_no" value="<?php if(isset($company_info)){ echo $company_info['bank_ifsc_no']; } ?>" placeholder="Enter IFSC Number">
                  </div>
											
									<div class="form-group col-md-12 mb-2">
										<hr class="m-0">
									</div>

                  <!-- <div class="form-group col-md-6">
                    <label>Google Pay Number</label>
                    <input type="number" class="form-control form-control-sm mobile_no" name="google_pay_no" id="google_pay_no" value="<?php if(isset($company_info)){ echo $company_info['google_pay_no']; } ?>" placeholder="Enter Google Pay Number">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Phone Pe Number</label>
                    <input type="number" class="form-control form-control-sm mobile_no" name="phone_pe_no" id="phone_pe_no" value="<?php if(isset($company_info)){ echo $company_info['phone_pe_no']; } ?>" placeholder="Enter Phone Pe Number">
                  </div> -->

									
                  <div class="form-group col-md-6">
                    <label>Financial Year From Date</label>
										<div class="input-group date" id="date1" data-target-input="nearest">
											<input type="text" class="form-control form-control-sm datetimepicker-input" name="company_fin_from" id="company_fin_from" data-target="#date1" data-toggle="datetimepicker" value="<?php if(isset($company_info)){ echo $company_info['company_fin_from']; } ?>" required>
										</div>
									</div>
									<div class="form-group col-md-6">
                    <label>Financial Year To Date</label>
										<div class="input-group date" id="date2" data-target-input="nearest">
											<input type="text" class="form-control form-control-sm datetimepicker-input" name="company_fin_to" id="company_fin_to" data-target="#date2" data-toggle="datetimepicker" value="<?php if(isset($company_info)){ echo $company_info['company_fin_to']; } ?>" required>
										</div>
									</div>

                  <div class="form-group col-md-6">
                    <label>Company Logo</label>
                    <input type="file" class="form-control form-control-sm valid_image" name="company_logo" id="company_logo">
                    <label>.jpg, .png file. Image size must be less than 500 kb</label>
                    <?php if(isset($company_info) && $company_info['company_logo']){ ?>
                      <input type="hidden" name="old_company_logo" value="<?php echo $company_info['company_logo']; ?>">
                      <img class="mt-2" width="100px" src="<?php echo base_url(); ?>assets/images/master/<?php echo $company_info['company_logo']; ?>" alt="">
                    <?php } ?>
                  </div>

                  <div class="form-group col-md-6">
                    <label>Company Fevicon</label>
                    <input type="file" class="form-control form-control-sm valid_image" name="company_fevicon" id="company_fevicon">
                    <label>.jpg, .png file. Image size must be less than 500 kb</label>
                    <?php if(isset($company_info) && $company_info['company_fevicon']){ ?>
                      <input type="hidden" name="old_company_fevicon" value="<?php echo $company_info['company_fevicon']; ?>">
                      <img class="mt-2" width="100px" src="<?php echo base_url(); ?>assets/images/master/<?php echo $company_info['company_fevicon']; ?>" alt="">
                    <?php } ?>
                  </div>

                <div class="card-footer col-md-12 text-right">
                  <a href="<?php echo base_url(); ?>/Company/company_list" class="btn btn-sm btn-default ml-4">Cancel</a>
                  <button type="submit" class="btn btn-sm btn-primary">Update Company</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>
</body>
</html>


<script type="text/javascript">
  $("#country_id").on("change", function(){
    var country_id =  $('#country_id').find("option:selected").val();
    $.ajax({
      url:'<?php echo base_url(); ?>Master/get_state_by_country',
      type: 'POST',
      data: {"country_id":country_id},
      context: this,
      success: function(result){
        $('#state_id').html(result);
      }
    });
  });

  $("#state_id").on("change", function(){
    var state_id =  $('#state_id').find("option:selected").val();
    $.ajax({
      url:'<?php echo base_url(); ?>Master/get_city_by_state',
      type: 'POST',
      data: {"state_id":state_id},
      context: this,
      success: function(result){
        $('#city_id').html(result);
      }
    });
  });
</script>
