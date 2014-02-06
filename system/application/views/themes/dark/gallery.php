<div id="photo_back" class="pagination"><a href="http://www.johnpollak.com">&lt; home</a></div>
<?php   if($photos) : foreach($photos as $res) :?>
    <div class="grid_2 gallery_item">
    <a href="<?php echo base_url() . 'photo/' . $res->id . '/' . url_title($res->title); ?>" class="gallery_overlay" title="<?php echo $res->description; ?>"></a>
    <img src="<?php echo get_thumb(base_url() . 'uploads/gallery/' . $res->galleries_id . '/' . $res->image); ?>" alt="<?php echo $res->title; ?>" />
</div>
<?php endforeach; else: ?>
<div class="grid_12">
    <h3 class="error">No photos yet</h3>
</div>
<?php endif; ?>