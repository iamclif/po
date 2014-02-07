<div id="sidebar">
    <div class="content-wrap">
        <h3><a href="<?php echo site_url('admin/add_page'); ?>">Add new page</a></h3>
    </div>
</div>
<div id="main">
<?php if($pages) : ?>
<table>
    <thead>
        <tr>
            <th colspan="7">Pages</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <th>Title</th>
            <th>Active?</th>
            <th>actions</th>
        </tr>
<?php foreach($pages as $res) :?>
        <tr>
            <td>
                <a href="<?php echo site_url('admin/add_page/'.$res->id); ?>" title="Click to edit this entry" class="tooltip">
                    <?php echo $res->title; ?>
                </a>
            </td>
            <td><?php echo $res->active; ?></td>
            <td>
                <a class="tooltip nyroModal" rev="modal" href="<?php echo site_url('admin/delete_page/'.$res->id); ?>" title="delete this entry.">
                    <img src="images/cancel.png" />
                </a>
                <a href="<?php echo site_url('admin/add_page/'.$res->id); ?>" title="click to edit this entry" class="tooltip">
                    <img src="images/edit.png" />
                </a>
<?php $sit_link = ($res->active == 'Y') ? 'N' : 'Y'; //define situation link ?>
                <a href="<?php echo site_url('admin/update_status/pages/'.$sit_link.'/'.$res->id); ?>" title="Change situation (inative/active) " class="tooltip nyroModal" rev="modal">
                    <img src="images/error.png" />
                </a>
            </td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>
<?php echo $this->pagination->create_links(); ?>
<?php else: ?>
<div class="error">You don't have pages yet!</div>
<?php endif; ?>
</div>