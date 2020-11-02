<div class="container top-margin">
	<div class="jumbotron" style="box-shadow: rgba(0, 0, 0, 0.3) 12px 12px 5px 1px;">
		<h2><?php echo $blog['title']; ?></h2>
			<span class="badge badge-pill badge-primary"> Posted on: <?php echo $blog['created_on']; ?></span></strong>
		<br>
		<center>
			<img class="img-fluid" src="<?php echo str_replace('index.php', '', site_url()); ?>/application/assets/images/blogs/<?php echo $blog['blog_image']; ?>" height="50%" width="60%">
		</center>
		<hr class="my-4">
		<div>
			<?php echo $blog['description']; ?>
		</div>

		<?php if ($this->session->userdata('user_id') == $blog['created_by']) : ?>
			<hr>
			<a class="btn btn-default pull-left" href="<?php echo site_url(); ?>/blogs/edit/<?php echo $blog['slug']; ?>">Edit</a>
			<?php echo form_open('/blogs/delete/'.$blog['id']); ?>
				<input type="submit" value="Delete" class="btn btn-danger">
			</form>
		<?php endif ?>
	</div>
</div>
<br>