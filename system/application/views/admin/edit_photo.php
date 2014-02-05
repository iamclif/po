<div id="edit_photo">
        <?php if($photo) : ?>
        <form action="<?php echo site_url('admin/save_edit_photo/' . $photo->id); ?>" method="post" enctype="multipart/form-data" class="ajax_form- nyroModal">
        	<label for="title">Title</label>
            <input type="text" name="title" id="title" class="big" value="<?php echo $photo->title; ?>" />
            
        	<label for="description">Description</label>
            <textarea name="description" id="description" class="big"><?php echo $photo->description; ?></textarea>
            
            <label for="send"></label>
            <input name="send" type="submit" value="send" />
            <div id="result"></div>

        </form>
        <?php else : ?>
        <h4 class="error">Photo not found</h4>
        <?php endif; ?>
        <a href="<?php echo site_url('admin/add_photo/' . $photo->galleries_id);?>" class="nyroModalClose close">back</a>
</div>