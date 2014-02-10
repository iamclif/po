<?php if($current_page) : ?>
    <div class="cms">
        <?php echo $current_page->content; ?>
    </div>
<?php else : ?>
    <div class="grid_12">
        <h3 class="error">Page not found</h3>
    </div>
<?php endif; ?>