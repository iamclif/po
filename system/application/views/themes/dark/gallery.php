<div id="photo_back" class="pagination"><a href="<?php echo base_url();?>">&lt; home</a></div>
<ul class="gallery-container">
<?php if($photos) : foreach($photos as $res) :?>
    <li class="gallery_item">
        <a href="<?php echo base_url() . 'photo/' . $res->id; ?>" class="gallery_overlay" title="<?php echo $res->description; ?>">
            <img src="<?php echo base_url() . 'uploads/gallery/' . $res->galleries_id . '/' . $res->image; ?>"  />
        </a>
    </li>
<?php endforeach; else: ?>
</ul>
<div class="grid_12">
    <h3 class="error">No photos yet</h3>
</div>
<?php endif; ?>
