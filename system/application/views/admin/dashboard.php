        <div id="sidebar">
        	<div class="content-wrap">
                <h3>Galleries</h3>
            	<div class="conent-inner">
<?php if($galleries): ?>
					<ul>
<?php foreach($galleries as $res) :  ?>
						<li><?php echo anchor('admin/add_photo/' . $res->id, $res->title); ?></li>
<?php endforeach; ?>
		            </ul>
<?php else : ?>
					<div class="error">You don't have galleries yet!</div>
<?php endif; ?>
				</div>
			</div>
            
        	<div class="content-wrap">
                <h3>Pages</h3>
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
        <!-- sidebar: end -->
        
        <!-- main: start -->
        <div id="main" class="clearfix">
        	<h2>Dashboard</h2>
        	<ul id="dashboard">
            	<li>
                	<a href="<?php echo site_url('admin/galleries'); ?>" class="tooltip" title="Manage your galleries/photos">
                    	<img src="images/kview.png" alt="Manage your galleries/photos"  /><br />
                        <p>Photos<br />Galleries</p>
                    </a>
                </li>
                
            	<li>
                	<a href="<?php echo site_url('admin/pages'); ?>" class="tooltip" title="add/edit pages">
                    	<img src="images/kate.png" alt="add/edit pages"  /><br />
                        <p>Pages</p>
                    </a>
                </li>
                
            	<li>
                	<a href="<?php echo site_url('admin/config'); ?>" class="tooltip" title="config your site">
                    	<img src="images/advancedsettings.png" alt="config your site"  /><br />
                        <p>Config</p>
                    </a>
                </li>
                
            	<li>
                	<a href="<?php echo site_url('admin/logout'); ?>" class="tooltip" title="logout">
                    	<img src="images/exit.png" alt="logout"  /><br />
                        <p>Exit</p>
                    </a>
                </li>
                
            </ul>
        </div>
        <!-- main: end -->
