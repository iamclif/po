<div id="sidebar">
    <div class="content-wrap">
        <h3>Lost your password?</h3>
        <div class="conent-inner">
            <form action="<?php echo site_url('admin/recover_password'); ?>" method="post" enctype="multipart/form-data" class="nyroModal">
                <label for="email">email</label>
                <input type="texr" name="email" id="email" /><br  />
                <small>type your email</small>
                <label for="send"></label>
                <input name="send" type="submit" value="send" />
            </form>
        </div>
    </div>
</div>
<div id="main">
    <!-- subNav: start -->  
    <h3>Login</h3>
    <?php echo $this->session->flashdata('message'); ?>
    <form action="<?php echo site_url('admin/do_login/'); ?>" method="post">
        <label for="login">login</label>
        <input type="text" name="login" id="login" class="medium" value=""/>
        <label for="pass">password</label>
        <input name="pass" type="password" class="medium" id="pass" value="" />
        <input type="submit" name="submit" value="submit"  />
    </form>
</div>