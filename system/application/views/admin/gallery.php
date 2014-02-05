<div id="sidebar">
    <div class="content-wrap">
        <h3>Add new gallery</h3>
        <div class="conent-inner">
            <form action="<?php echo site_url('admin/save_gallery'); ?>" method="post" enctype="multipart/form-data" class="nyroModal" rev="modal">
                <label for="title">Title</label>
                <input type="text" name="title" id="title"  />
                           
                <label for="description">Description</label>
                <textarea type="text" name="description" id="description"></textarea>
                
                <label for="cover">Cover image</label>
                <input type="file" name="cover" id="cover" />
                
                <label for="active"></label>
                <input name="active" type="checkbox" id="active" value="Y" checked="checked"/> Active?
    
                <label for="send"></label>
                <input name="send" type="submit" value="send" />
                <div id="result"></div>
            </form>
        </div>
	</div>
</div>
<div id="main">
<?php if($entries) : ?>
			<table>
				<caption>You have <strong><?php echo $total_rows; ?></strong> entries.</caption>
				<thead>
					<tr>
						<th colspan="7">Gallery entries</th>
					</tr>
				</thead>
				<tbody>

					<tr>
						<th>Title</th>
						<th>active?</th>
						<th>actions</th>
					</tr>
<?php foreach($entries as $res) :?>
					<tr>
						<td>
							<a href="<?php echo site_url('admin/add_photo/'.$res->id); ?>" title="Click to add photos" class="tooltip">
								<?php echo $res->title; ?>
                            </a>
                        </td>
						<td><?php echo $res->active; ?></td>
                        <td>
                        	<a class="tooltip nyroModal" rev="modal" href="<?php echo site_url('admin/delete_gallery/'.$res->id); ?>" title="delete this gallery.">
                            	<img src="images/cancel.png" />
                            </a>
                        	<a href="<?php echo site_url('admin/add_photo/'.$res->id); ?>" title="click manager this gallery" class="tooltip">
                            	<img src="images/edit.png" />
                            </a>
<?php $sit_link = ($res->active == 'Y') ? 'N' : 'Y'; //define situation link ?>
                        	<a href="<?php echo site_url('admin/update_status/galleries/'.$sit_link.'/'.$res->id); ?>" title="Change situation (inative/active)" class="tooltip nyroModal" rev="modal">
                            	<img src="images/error.png" />
                            </a>
                        </td>
					</tr>
<?php endforeach; ?>
				</tbody>
			</table>
<?php echo $this->pagination->create_links(); ?>
<?php else: ?>
<h3 class="error">There are no entries yet!</h3>
<?php endif; ?>
</div>