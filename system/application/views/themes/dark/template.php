<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $this->site_config->site_title; ?></title>
    <base href="<?php echo base_url() . $this->config->item('t_folder'); ?>"  />
    <script type="text/javascript">var base_url = '<?php echo base_url(); ?>';</script>
    <script type="text/javascript" language="JavaScript" src="js/jquery-1.2.3.pack.js"></script>
    <script type="text/javascript" language="JavaScript" src="js/jquery.embedquicktime.js"></script>
    <link rel="stylesheet" type="text/css" href="css/galleries.css" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <meta name="description" content="<?php echo $this->site_config->site_description; ?>" />
    <meta name="keywords" content="<?php echo $this->site_config->site_keywords; ?>" />
</head>
<body>
    <div id="container">
        <div id="header">
            <h1 id="logo">John Pollak Photography</h1>
        </div>
        <div id="nav">
        <?php echo $this->g->create_nav(TRUE, $this->nav); ?></div>
        <div class="content"><?php echo $contents; ?></div>
        <div id="footer">
            <?php echo $this->g->create_nav(TRUE, $this->nav);  ?>
            <p>&copy; Copyright <?php echo date("Y", time()); ?> John Pollak.
                <span class="signature">Site Designed by 
                    <a href="http://www.clifjordan.com/">Clif Jordan</a>
                </span>
                <span class="signature">CMS by
                    <a href="http://tinyurl.com/jonatanfroes" rel="external">Jônatan Fróes</a>
                    - &nbsp;Powered by<a href="http://codeigniter.com" rel="external">CodeIgniter</a>
                </span>
            </p>
        </div>
    </div>
    <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="js/custom.1.js"></script>
</body>
</html>
