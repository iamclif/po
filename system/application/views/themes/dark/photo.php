<div class="grid_1 prev pagination">
    <?php
        if($prev_photo) : 
            echo anchor( 'photo/' . $prev_photo->id . '/' . url_title($prev_photo->title),  '&lt; prev');
        endif;
    ?>
    </div>
    
    <div class="grid_10 pagination align_center">
    <?php echo anchor( 'detail/' . $photo->galleries_id . '/' . url_title($photo->g_title),  'back to the <strong>' . $photo->g_title . '</strong>');?>
    </div>
    
    <div class="grid_1 next pagination">
    <?php
        if($next_photo) : 
            echo anchor( 'photo/' . $next_photo->id . '/' . url_title($next_photo->title),  'next &gt;');
        endif;
    ?>
    </div>      
<?php if($photo) : ?>
    <div class="grid_12 gallery_detail">
        <img src="<?php echo base_url() . 'uploads/gallery/' . $photo->galleries_id . '/' . $photo->image; ?>" alt="<?php echo $photo->title; ?>" />
    </div>
    <div class="clear"></div>
    <div class="grid_11 img_description">
        <h2><?php echo $photo->title; ?></h2>
        <p><?php echo $photo->description; ?></p>
    </div>
<?php else: ?>
    <div class="grid_12">
        <h3 class="error">No photos yet</h3>
    </div>
<?php endif; ?>