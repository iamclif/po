<div id="galleries">
    <h2>Photo Galleries</h2>
    <?php  if($galleries) : foreach($galleries as $res) : ?>
    <div class="gallery_cover">
        <h3><?php echo $res->title; ?></h3>
        <a href="<?php echo site_url('detail/' . $res->id . '/' . url_title($res->title)); ?>" class="gallery_overlay">
            <img src="<?php echo base_url() . 'uploads/gallery/' . $res->id . '/cover.jpg'; ?>" alt="<?php echo $res->title; ?>"  />
        </a>
    </div>
    <?php endforeach; else: ?>
    <div class="grid_12">
        <h3 class="error">No galleries yet.</h3>
    </div>
    <?php endif; ?>
</div>
<img class="hr" src="img/hr.jpg" />