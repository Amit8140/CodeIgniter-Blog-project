<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('application/assets/css/style.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('application/assets/css/bootstrap.min.css'); ?>">
  <script type="text/javascript" src="<?php echo base_url('application/assets/js/jquery.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('application/assets/js/bootstrap.min.js'); ?>"></script>
  <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="<?php echo base_url(); ?>">Blog Posting</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor03">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo site_url('categories'); ?>">Categories</a>
      </li>
      <?php if ($this->session->userdata('logged_in')) { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo site_url('blogs/create'); ?>">Add Blogs</a>
        </li>
      <?php } ?>
    </ul>
    <div class="form-inline">
    <?php if ($this->uri->segment(1) != 'login'): ?>
      <div class="form-group">
      <?php echo form_open('home/search'); ?>
        <input class="form-control mr-sm-2" name="search" type="text" placeholder="Search" value="<?php echo $this->session->userdata('search_query') ?>">
          <?php $categories = $this->categories_model->get_published_cat(); ?>
        <select class="custom-select"  name="category" title="Search by Category">
          <option value="AllCategory">Search by Category</option>
        <?php 
        $search_cat = $this->session->userdata('search_cat');
        foreach ($categories as $category) {
          $selected = ($category['id'] == $search_cat) ? 'selected="selected"' : '';
          echo '<option '.$selected.' value="'.$category['id'].'">'.$category['title'].'</option>';
        } ?>
        </select>
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
      
      <?php echo form_close(); ?>
    </div>
  <?php endif; ?>
      <?php if(!$this->session->userdata('logged_in')): ?>
      <div class="">
        	<a href="<?php echo site_url('signup'); ?>"><button type="button" class="btn btn-danger">Sign-Up</button></a>
        	<a href="<?php echo site_url('login'); ?>"><button type="button" class="btn btn-success">Login</button></a>
        <?php else: ?>
          <a href="<?php echo site_url('logout'); ?>"><button type="button" class="btn btn-success">LogOut</button></a>
      </div>
      <?php endif; ?>
    </div>
  </div>
</nav>