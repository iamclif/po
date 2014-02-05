<!--<div class="grid_3 site_intro">
<h1>Welcome to John Pollak Photography</h1>
<p>John is a New York based Photographer and motion graphics animator. He has traveled the country taking photos of landscapes, city life, and the optical illusions that make photography interesting.</p></div>-->

<!--<img class="hr" src="img/hr.jpg" />-->

<div id="galleries">
<h2>Photo Galleries</h2>
<?php
	if($galleries) : 
		foreach($galleries as $res) :
?>
<div class="grid_3 gallery_cover">
    	<h3><?php echo $res->title; ?></h3>
<a href="<?php echo site_url('detail/' . $res->id . '/' . url_title($res->title)); ?>" class="gallery_overlay"></a>
		<img src="<?php echo base_url() . 'uploads/gallery/' . $res->id . '/cover.jpg'; ?>" alt="<?php echo $res->title; ?>"  /></div>
<!-- end grid_3 gallery_cover -->

<?php
		endforeach;
	else:
?>
<div class="grid_12"><h3 class="error">No galleries yet.</h3></div>
<?php endif; ?>
</div><!-- end galleries -->

<img class="hr" src="img/hr.jpg" />

<!--<div class="fat_footer">
	<div class="rounded01">
		<a href="http://www.johnpollak.com/page/14"><h2>Video Gallery</h2></a>	</div>
	<div class="rounded02">
		<ul>
			<li>promos</li>
			<li>rotoscoping</li>
			<li>graphic packages</li>
			<li>storyboards</li>
			<li>elements</li>
			<li>typography</li>
		</ul>
	</div>
</div>-->
<!-- end fat footer 1 -->


<!--<div class="fat_footer">
<div class="rounded01">
		<a href="http://www.johnpollak.com/page/21"><h2>Contact John</h2></a>	</div>
	<div class="rounded02">
		
        <p><a href="mailto:john@johnpollak.com"><img src="img/email_icon.png" alt="eMail John Pollak" />eMail John</a></p>
		<p class="space">or visit him on:</p>	
		<a href="http://www.linkedin.com/pub/john-pollak/7/a35/889"><h2 class="linkedin">linkedin2</h2></a>	</div>
</div>-->
<!-- end fat footer 2 -->


<!--<div class="fat_footer">
<div class="rounded01">
		<a href="http://www.johnpollak.com/page/15"><h2>Biography</h2></a>	</div>
	<div class="rounded02">
	  
      <ul>
        <li>Photographer</li>
        <li>Designer</li>
        <li>Photo retoucher</li>
        <li>Animator</li>
        <li>and balloon<br /> animal artist</li>
	</ul>	
    </div>
</div>-->
<!--end fat footer 3 --> 
  
	


