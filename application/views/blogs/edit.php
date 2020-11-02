<div class="container top-margin text-white bg-dark">
  
  <?php echo validation_errors(); ?>

  <?php echo form_open('blogs/update'); ?>
  <input type="hidden" name="id" value="<?php echo $blog['id']; ?>">
  <div class="form-group">
    <label>Title</label>
    <input type="text" class="form-control" name="title" placeholder="Add Title" value="<?php echo $blog['title']; ?>">
  </div>
  <div class="form-group">
    <label>Description</label>
    <textarea id="editor1" class="form-control" name="description" placeholder="Add description"><?php echo $blog['description']; ?></textarea>
  </div>

  <div class="form-group">
    <label>Category</label>
    <select name="category_id" class="form-control">
      <?php foreach($categories as $category): ?>
        <option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
      <?php endforeach?>
    </select>
  </div>

  <input type="submit" class="btn btn-primary mb-3" value="Update" class="btn btn-default btn-lg">
  <?php echo form_close(); ?>

</div>
<script type="text/javascript">
  CKEDITOR.replace( 'editor1' );
</script>