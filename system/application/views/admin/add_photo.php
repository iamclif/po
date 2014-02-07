<div id="sidebar">
    <div class="content-wrap">
        <h3>Edit Gallery</h3>
        <div class="conent-inner">
            <form action="<?php echo site_url('admin/save_gallery/' . $gallery->id); ?>" method="post" enctype="multipart/form-data" class="nyroModal">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="<?php echo $gallery->title; ?>" />
                           
                <label for="description">Description</label>
                <textarea type="text" name="description" id="description"><?php echo $gallery->description; ?></textarea>
                
                <label for="cover">Cover image</label>
                <input type="file" name="cover" id="cover" />
                <a href="<?php echo base_url() . 'uploads/gallery/' . $gallery->id . '/cover.jpg'; ?>" class="nyroModal">see current cover</a><br  />
                <small>must be a jpg image</small>

                
                <label for="active"></label>
                <input name="active" type="checkbox" id="active" value="Y" <?php echo ($gallery->active == 'N') ? '' : 'checked="checked"'; ?> /> Active?
    
                <label for="send"></label>
                <input name="send" type="submit" value="send" />
                <div id="result"></div>
            </form>

        </div>
    </div>

    <div class="content-wrap">
        <h3>add photos</h3>
        <div class="conent-inner">
            <h4>Single file</h4>
                <form action="<?php echo site_url('admin/save_photo/' . $gallery->id . '/' . md5('flash_data') ); ?>" method="post" enctype="multipart/form-data" class="nyroModal" rev="modal">
                    <label for="Filedata">File</label>
                    <input type="file" name="Filedata" id="Filedata" />
                    
                    <label for="send"></label>
                    <input name="send" type="submit" value="send" />
                </form>
                <hr  />
                
            <h4>Multiple files (beta)</h4>
            <div id="fileQueue"></div>
            <input type="file" name="uploadify" id="uploadify" />
            <p>
                <a href="javascript:jQuery('#uploadify').uploadifyClearQueue()">Cancel All Uploads</a> | 
                <a href="javascript:jQuery('#uploadify').uploadifyUpload()">do upload</a> | 
                <?php echo anchor('admin/add_photo/'. $gallery->id, 'refresh page'); ?>
            </p>
        </div>
    </div>
</div>
<div id="main">
    <?php if($photos) : ?>
    <h3>Photos in this category</h3>
    <ul class="list-photos">
    <?php foreach ($photos as $res) :?>
        <li>
            <a href="<?php echo site_url("admin/delete_photo/{$res->id}"); ?>" class="nyroModal" rev="modal">delete</a> | 
            <a href="<?php echo site_url("admin/edit_photo/{$res->id}"); ?>" class="nyroModal" rev="modal">edit</a>
            <span class="photothumb">
                <a href="<?php echo base_url()  . "uploads/gallery/{$res->galleries_id}/{$res->image}"; ?>" class="nyroModal">
                    <img src="<?php echo get_thumb(base_url()."uploads/gallery/{$res->galleries_id}/{$res->image}"); ?>" alt="" />
                </a>
            </span>
        </li>
    <?php endforeach;?>
    </ul>
    <?php else : ?> 
    <h3 class="error">there is no photo in this category</h3>
    <?php endif; ?>
</div>