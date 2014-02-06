<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>John Pollak Photography PhotoCMS</title>
    <base href="<?php echo base_url() . 'admin_files/'; ?>"  />
    <link href="css/all.css" rel="stylesheet" type="text/css" />
    <link href="js/nyroModal-1.5.1/styles/nyroModal.full.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">var base_url = '<?php echo base_url(); ?>';</script>
</head>
<body>
<div id="container">
    <div id="header" class="grid_12">
        <h1 id="logo">John Pollak Photography</h1>
    </div>
    <div class="clear"></div>
    <div id="nav" class="grid_12">
        <ul><?php foreach($this->admin_nav  as $i => $admin_nav): ?>
            <li class="<?php echo ($this->nav == $admin_nav ? 'active' : ''); ?>">
            <?php echo anchor('admin/'.$i, $admin_nav); ?>
            </li>
            <?php endforeach; ?>
            <li>
            <?php echo anchor('admin/logout', 'logout'); ?>
            </li>
        </ul>
    </div>
    <div class="clear"></div>
    <?php echo $contents ; ?>
    <div class="spacer"></div>
    <div class="clear"></div>
    <div id="footer" class="grid_12">
        <?php echo $this->g->create_nav(TRUE, $this->nav);  ?>
        <p>&copy; Copyright <?php echo date("Y", time()); ?> John Pollak.
            <span class="signature">Site Designed by 
                <a href="http://www.clifjordan.com/">Clif Jordan</a>
            </span>
            <span class="signature">CMS by
                <a href="http://tinyurl.com/jonatanfroes" rel="external">Jônatan Fróes</a>- &nbsp;Powered by<a href="http://codeigniter.com" rel="external">CodeIgniter</a>
            </span>
        </p>
    </div>
    <div class="clear"></div>
</div>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/tooltip.js"></script>
<script type="text/javascript" src="js/nyroModal-1.5.1/js/jquery.nyroModal-1.5.1.pack.js"></script>
<script type="text/javascript" src="js/tinymce_3_2_5/tiny_mce.js"></script>    
<script type="text/javascript" src="js/custom.js"></script>
<?php
if(isset($custom_footer))
$this->load->view('admin/' . $custom_footer);
?>
</body>
</html>