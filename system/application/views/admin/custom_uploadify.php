<script type="text/javascript" src="<?php echo base_url() . 'admin_files/js/uploadify/'; ?>swfobject.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'admin_files/js/uploadify/'; ?>jquery.uploadify.v2.0.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#uploadify").uploadify({
		'uploader'       : '<?php echo base_url() . 'admin_files/js/uploadify/'; ?>uploadify.swf',
		'script'         : '<?php echo $uploadify_action; ?>',
		'cancelImg'      : '<?php echo base_url() . 'admin_files/js/uploadify/'; ?>cancel.png',
		'folder'         : 'uploads',
		'queueID'        : 'fileQueue',
		'auto'           : false,
		'multi'          : <?php echo $uploadify_multi; ?>
	});
});
</script>
