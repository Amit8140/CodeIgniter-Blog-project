<div class="container top-margin">
<?php 
$this->load->helper('text');
if ($this->session->userdata('blog_error')) { ?>
	<div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $this->session->flashdata('blog_error'); ?>
      </div>
<?php }
if (empty($blogs)): ?>
	<div class="container card" style="box-shadow: rgba(0, 0, 0, 0.3) 12px 12px 5px 1px;">
		<div class="row text-white bg-dark">
			<div class="col-md-9 card-body">
				<div class="card-text">
					<p>No Records found....</p>
				</div>	
			</div>	
		</div>
	</div>	
<?php else:
foreach($blogs as $blog) : ?>
	<div class="container card" style="box-shadow: rgba(0, 0, 0, 0.3) 12px 12px 5px 1px;">
		<h3 class="card-header"><?php echo $blog['title']; ?></h3>
	<div class="row text-white bg-dark">
		<div class="col-md-3 mb-2">
			<img class="img-border" src="<?php echo str_replace('index.php','',site_url());?>application/assets/images/blogs/<?php echo $blog['blog_image']; ?>" width="100%" height="100%">
		</div>
		<div class="col-md-9 card-body">
			<small >
				<span class="badge badge-pill badge-primary"> Posted on: <?php echo $blog['created_on']; ?></span> in <strong class="card-title"><?php echo $blog['category_title'] ; ?></strong>
			</small>
			<br>
			<div class="card-text">
				<?php echo word_limiter($blog['description'], 30); ?>
			</div>
			<p>
				<a class="btn btn-primary btn-lg" href="<?php echo site_url('/blogs/'.$blog['slug']); ?>">Read More >></a>
			</p>
		</div>
	</div>	
	</div>
	<br>
<?php 
endforeach;
endif;
?>
	<div>
		<?php 
		//if ($this->pagination->create_links()) {
			echo '<ul class="pagination">';
			echo $this->pagination->create_links();
			echo '</ul>';
		//} ?>
	</div>
</div>