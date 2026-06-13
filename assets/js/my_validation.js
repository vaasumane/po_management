// Valid Email...

$(document).on('change','.alphabet',function(){
  var alphabet_format = /^[a-zA-Z\s]+$/;
  var alphabet = $(this).val();
  console.log(alphabet);
  
  if (alphabet_format.test(alphabet)){

  } else{
    toastr.error('Invalid value. Number & Symbol not allowed');
    $(this).val('');
  }
});

// Valid Email...
$(document).on('change','.email',function(){
  var email_format = /^[a-z0-9._%+-]+@([a-z0-9-]+\.)+[a-z]{2,4}$/;
  var email = $(this).val();
  if (email_format.test(email)){

  } else{
    toastr.error('Invalid Email Format');
    $(this).val('');
  }
});

// Valid Website URL...
$(document).on('change','.website',function(){
  var format = /^[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
  var website = $(this).val();
  if (format.test(website)){

  } else{
    toastr.error('Invalid Website Format');
    $(this).val('');
  }
});

// Valid PAN Number...
$(document).on('change','.pan_no',function(){
  var format = /[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
  var pan_no = $(this).val();
  if (format.test(pan_no)){

  } else{
    toastr.error('Invalid PAN Number Format');
    $(this).val('');
  }
});

// Valid GST Number...
$(document).on('change','.gst_no',function(){
  var format = /[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[0-9A-Z]{1}[0-9A-Z]{1}$/;
  var gst_no = $(this).val();
  if (format.test(gst_no)){

  } else{
    toastr.error('Invalid GST Number Format');
    $(this).val('');
  }
});

// Valid PinCode Number...
$(document).on('change','.pincode_no',function(){
  var format = /^[1-9][0-9]{5}$/;
  var pincode_no = $(this).val();
  // alert(pincode_no);
  if (format.test(pincode_no)){
  //
  } else{
    toastr.error('Invalid Pincode Format');
    $(this).val('');
  }
});

// Valid Mobile Number...
$(document).on('change','.mobile_no',function(){
  var mobile_format = /^[5-9][0-9]{9}$/;
  var mobile_no = $(this).val();
  // alert(pincode_no);
  if (mobile_format.test(mobile_no)){
  //
  } else{
    toastr.error('Invalid Mobile Number Format');
    $(this).val('');
  }
});

// Valid Mobile Number...
$(document).on('change','.adhar_no',function(){
  var adhar_format = /^[1-9][0-9]{11}$/;
  var adhar_no = $(this).val();
  // alert(pincode_no);
  if (adhar_format.test(adhar_no)){
  //
  } else{
    toastr.error('Invalid Adhar Number Format');
    $(this).val('');
  }
});

// Valid IFSC...
$(document).on('change','.ifsc',function(){
  var format = /^[A-Za-z]{4}\d{7}$/;
  var ifsc = $(this).val();
  // alert(ifsc);
  if (format.test(ifsc)){

  } else{
    toastr.error('Invalid IFSC Code Format');
    $(this).val('');
  }
});

// Valid IFSC...
$(document).on('change','.age',function(){
  var age = $(this).val();

  if(age < 1 || age > 100){
    toastr.error('Invalid Age');
    $(this).val('');
  }
});

// Confirm Password...
$('.password, .con_password').on('change',function(){
  var password = $('.password').val();
  var con_password = $('.con_password').val();

	if(con_password != '' && password != ''){
		if(password != con_password){
			toastr.error('Password and Confirm Password must be same');
			$('.con_password').val('');
		}
	} 
});

// Valid Image with size image
$('.valid_image').bind('change', function() {
  var size = this.files[0].size;
  var type = this.files[0].type;
  if(size > 561276){
    toastr.error('File size is must be less than 500kb');
    $(this).val('');
  }
  if(type != "image/jpeg" && type != "image/jpg" && type != "image/png"){
    toastr.error('Invalid File Type');
    $(this).val('');
  }
});

// Valid CSV...
$('.valid_csv').bind('change', function() {
  var size = this.files[0].size;
  var type = this.files[0].type;
  // alert(type);
  // if(size > 561276){
  //   toastr.error('File size is must be less than 500kb');
  //   $(this).val('');
  // }
  if(type != "application/vnd.ms-excel"){
    toastr.error('Invalid File Type. Browse CSV file');
    $(this).val('');
  }
});
