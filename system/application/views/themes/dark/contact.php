<div class="grid_5 prefix_1 page_image">
<img src="/themes/dark/img/b_clarinet_rings_300.jpg" width="300" height="225" /></div>
<div class="grid_5 page_content">
    <h2>Get in touch</h2>
    <?php echo $form_result; ?>
    <h3>John Pollak Photography</h3>
    <ul>
        <li>244 10th Ave #5W</li>
        <li>New York NY</li>
        <li>646-957-3377</li>
        <li><a href="mailto:info@johnpollak.com">info@johnpollak.com</a></li>
    </ul>
    <form action="<?php echo site_url("submit_form"); ?>" enctype="multipart/form-data" method="post" id="ContactForm" >
        <fieldset>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php echo ( ! set_value('name') ) ? 'name' : set_value('name'); ?>" />

            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="<?php echo ( ! set_value('email') ) ? 'email' : set_value('email'); ?>"/>

            <label for="message">Your message</label>
            <textarea name="message" id="message" cols="4" rows="5"><?php echo ( ! set_value('message') ) ? 'message' : set_value('message'); ?></textarea>
            
        <label for="submit"></label>
            <input type="submit" name="submit" id="submit" value="send" />
        </fieldset>
    </form>
</div>