<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sign in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets_lte/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets_lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets_lte/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/admin_css.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets_lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets_lte/plugins/toastr/toastr.min.css">

</head>
<body class="hold-transition login-page" >
<div class="login-box">
  <div class="login-logo ">
    <!-- <img width="180px" src="<?= base_url(); ?>assets/images/common/logo.png" alt=""><br> -->
    <!-- <span class="login-box-msg">Sign in </span> -->
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body pt-3">
      <p class="login-box-msg"><b>Sign in</b> to start your session </p>
      <form method="post" action="" autocomplete="off">
        <div class="input-group mb-3">
          <input type="number" min="5000000000" max="9999999999" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-mobile-alt"></span>
            </div>
          </div>
        </div>
          
        <span class="text-red"> <?php echo form_error('email'); ?> </span>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <span class="text-red"> <?php echo form_error('password'); ?> </span>
        <div class="row">
          <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->
      <p class="mb-1">
        <!-- <a href="<?php echo base_url() ?>User/forgot_password">I forgot my password</a> -->
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>

</div>
<!-- /.login-box -->
<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets_lte/dist/js/adminlte.min.js"></script>
<!-- Alert -->
<script src="<?php echo base_url(); ?>assets_lte/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets_lte/plugins/toastr/toastr.min.js"></script>
<!-- Manual Validation -->
<script src="<?php echo base_url(); ?>assets/js/my_validation.js"></script>

<script type="text/javascript">
  <?php if($this->session->flashdata('flash_msg')){ ?>
    $(document).ready(function(){
      toastr.<?= $this->session->flashdata('class'); ?>('<?= $this->session->flashdata('flash_msg'); ?>');
    });
  <?php } ?>
</script>
</body>
</html>
