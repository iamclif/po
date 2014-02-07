<?php if($current_page) : ?>
    <div class="cms">
        <?php echo $current_page->content; ?>
    </div><!-- end .grid_5 page_content" -->
<?php else : ?>
    <div class="grid_12">
        <h3 class="error">Page not found</h3>
    </div><!-- end .grid_12 -->
<?php endif; ?>