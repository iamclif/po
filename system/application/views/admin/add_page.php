<div id="sidebar">
    <div class="content-wrap">
        <h3>My pages</h3>
        <div class="conent-inner">
<?php if($pages): ?>
			<ul>
<?php foreach($pages as $res) :  ?>
				<li><?php echo anchor('admin/add_page/' . $res->id, $res->title); ?></li>
<?php endforeach; ?>
            </ul>
<?php else : ?>
<div class="error">You don't have pages yet!</div>

<?php endif; ?>

        </div>
	</div>
</div>
<div id="main">
        <?php if($page) : ?>
        <h3>Editing "<?php echo $page->title; ?>"</h3>
        <?php else : ?>
        <h3>New Page</h3>
        <?php endif; ?>
        <form action="<?php echo site_url('admin/save_page/' . $page->id); ?>" method="post" enctype="multipart/form-data" class="nyroModal" rev="modal"	>
        	<label for="title">Title</label>
            <input type="text" name="title" id="title" class="big" value="<?php echo $page->title; ?>" /><br  /><br  />

			<textarea id="content" name="content" rows="40" cols="50" class="mceEditor"><?php echo $page->content; ?></textarea>

            <label for="active"></label>
            <input name="active" type="checkbox" id="active" value="Y" <?php echo ($page->active == 'Y') ? 'checked="checked"' : ''; ?> /> Active?

            <label for="send"></label>
            <input name="send" type="submit" value="send" />
        </form>
</div>