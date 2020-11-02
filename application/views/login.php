<div class="container top-margin">
  <?php if ($this->session->has_userdata('user_auth')) { ?>
      <div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $this->session->flashdata('user_auth'); ?>
      </div>
    <?php } ?>

    <?php if ($this->session->has_userdata('login_protected')) { ?>
      <div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $this->session->flashdata('login_protected'); ?>
      </div>
    <?php } ?>
    <?php if ($this->session->has_userdata('user_registered')) { ?>
      <div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $this->session->flashdata('user_registered'); ?>
      </div>
    <?php } ?>
  <div class="container mx-auto bg-secondary" style="max-width: 25em;box-shadow: rgba(0, 0, 0, 0.3) 12px 12px 5px 1px;">
      <?php echo form_open('home/loginAuth',array('autocomplete'=>'off','onsubmit'=>'validate(event)','id'=>'loginForm')); ?>
      <fieldset class="form-group">
        <legend>Please fill login details</legend>
        <div class="form-group">
          <label for="username">User-Name</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" value="<?php echo set_value('username'); ?>">
          <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Password">
          <div class="invalid-feedback"></div>
        </div>
        <div class="mb-3" >
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </fieldset>
    <?php echo form_close(); ?>
  </div>
</div>
<script type="text/javascript">
  function validate(e){
      var invalid   = false;
      var username  = jQuery('#username');
      var password  = jQuery('#password');
      if (username.val().trim() == '' || !username.val()) {
        username.addClass('is-invalid');
        username.next().text('Please enter your username.');
        username.focus();
        invalid = true;
      }else{
        username.removeClass('is-invalid');
        username.addClass('is-valid');
      }
      if (password.val().trim() == '' || !password.val()) {
        password.addClass('is-invalid');
        password.next().text('Please enter your password.');
        password.focus();
        invalid = true;
      }else{
        password.removeClass('is-invalid');
        password.addClass('is-valid');
      }
      if (invalid) {
        e.preventDefault();
        return false;
      }
  }
</script>