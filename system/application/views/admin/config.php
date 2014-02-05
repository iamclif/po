<div id="sidebar">
    <div class="content-wrap">
        <h3>Update watermark</h3>
        <div class="conent-inner">
            <form action="<?php echo site_url('admin/save_watermark'); ?>" method="post" enctype="multipart/form-data" class="nyroModal" rev="modal">
                <label for="watermark">watermark</label>
                <input type="file" name="watermark" id="watermark" />
                <small>This image won't be resized</small><br  />
                <small>
                	<a href="<?php echo base_url() . 'uploads/watermark/' . $configs->watermark_image; ?>" class="nyroModal">
                	    see current watermark
                    </a>
				</small>
    
                <label for="send"></label>
                <input name="send" type="submit" value="send" />
            </form>
        </div>
	</div>
</div>
<div id="main">
        <h3>Admin Configuration</h3>
        <form action="<?php echo site_url('admin/save_config/'); ?>" method="post" class="nyroModal">
        	<label for="admin_email">Admin email</label>
        	<input type="text" name="admin_email" id="admin_email" class="medium" value="<?php echo $configs->admin_email; ?>"/>
            
        	<label for="contact_email">Contact Email</label>
        	<input type="text" name="contact_email" id="contact_email" class="medium" value="<?php echo $configs->contact_email; ?>"/>
        	<label for="login">login</label>
        	<input type="text" name="login" id="login" class="medium" value="<?php echo $configs->login; ?>"/>
            
            <label for="pass">password</label>
        	<input type="text" name="pass" id="pass" class="medium" value=""/>
            
        	<label for="site_title">Site Title</label>
        	<input type="text" name="site_title" id="site_title" class="medium" value="<?php echo $configs->site_title; ?>"/>
            
        	<label for="site_description">Description</label>
            <textarea name="site_description" id="site_description"><?php echo $configs->site_description; ?></textarea>

        	<label for="site_keywords">Keywords</label>
            <textarea name="site_keywords" id="site_keywords"><?php echo $configs->site_keywords; ?></textarea>

            <label for="watermark"></label>
            <input name="watermark" type="checkbox" id="watermark" value="Y" <?php echo ($configs->watermark == 'N') ? '' : 'checked="checked"'; ?> /> Use watermark?

            <label for="submit"></label>
            <input type="submit" name="submit" value="submit"  />
            <div id="result"></div>
        </form>
</div>