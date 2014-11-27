<head>
	<link rel="stylesheet" href="/themes/styles/captcha.css" type="text/css" />
	<script src="jquery-1.11.1.min.js"></script>
</head>
<body>
....
<?php echo form_open(current_url(), array('id' => 'login', 'class' => 'login')); ?>

<div>
	<?php
	echo form_input(array(
		'name' => 'username',
		'id' => 'username',
		'value' => set_value('username'),
		'class' => 'inputtext',
		'placeholder' => '?????????:'
	));
	?>
</div>

<div>
	<?php
	echo form_password(array(
		'name' => 'password',
		'id' => 'password',
		'value' => set_value('password'),
		'class' => 'inputtext',
		'placeholder' => '???? ??:'
	));
	?>
</div>

<div class="captcha">
	<div class="detail">
		<div class="img">
			<img src="" alt="" title="captcha">
		</div>
		<div class="inp">
			<input type="text" maxlength="10" id="captcha_code" name="captcha_code">
			<label>??????? ????????!</label>
		</div>
	</div>
</div>
<script>
	function getLongTime() {
		var d = new Date();
		var n = d.getTime();
		return n;
	}
	(function reloadCaptchaImg(capimg) {
		var link = '<?php echo admin_url('captcha/image?'); ?>' + getLongTime();
		$.ajax({
			url: link,
			success: function (result) {
				var par = capimg.parent();
				capimg.remove();
				capimg = $('<img src="' + result + '"/>');
				capimg.appendTo(par);
				capimg.animate({'opacity': '1'}, {
					duration: 300
				});
			}
		});
	})($('.captcha img'));
</script>
....
</body>