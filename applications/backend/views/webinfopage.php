<!doctype html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="pragma" content="no-cache" />
		<meta name="robots" content="all" />
		<meta name="MSSmartTagsPreventParsing" content="true" />
		<meta http-equiv="imagetoolbar" content="false" />
		<meta name="Description" content="" />
		<meta name="Keywords" content="" />
		<meta name="Owner" content="" />
		<meta name="Copyright" content="" />
		<meta name="Author" content="" />
		<meta name="Distribution" content="Global" />
		<meta name="Rating" content="General" />
		<meta name="Robots" content="INDEX,FOLLOW" />
		<meta name="Googlebot" content="INDEX,FOLLOW" />
		<meta name="MSNbot" content="INDEX,FOLLOW" />
		<meta name="Revisit-after" content="3 Day" />
		<title><?php echo $title; ?> | Informasi Website</title>
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo $favicon; ?>"/>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/ui/backend-layout.css"/>
                <script type="text/javascript"> var base_url = '<?php echo base_url(); ?>'; </script>
                <script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery-1.7.1.min.js"></script>
                <script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/tiny_mce/jquery.tinymce.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/backend-webinfopage.js"></script>
	</head>
	<body class="normal">
		<div class="container">
			<div class="toolbar">
				<div class="left-bar-icon">
					<a href="<?php echo base_url(); ?>backend.php/main/index">
						<img src="<?php echo base_url(); ?>assets/images/settings.png" alt="" />
					</a>
				</div>
				<div id="title-text-bar">
					<span id="title-text"><?php echo $title; ?></span>
					<span class="inset">
						(<a href="<?php echo base_url(); ?>">Lihat Website</a>)
					</span>
				</div>
				<div id="logon-info">
					<span>
						Selamat datang, <span id="user-info-bar"><?php echo $username; ?></span>!
						[<a href="<?php echo base_url(); ?>backend.php/main/logout" class="inset">Log Out</a>]
					</span>
				</div>
			</div>
			<div class="content">
				<div class="sidepanel">
					<ul>
						<li><a href="<?php echo base_url(); ?>backend.php/webinfo/" class="current">Informasi Website</a></li>
						<li><a href="<?php echo base_url(); ?>backend.php/home/">Halaman Beranda</a></li>
						<li><a href="<?php echo base_url(); ?>backend.php/aboutme/">Halaman Tentang Saya</a></li>
						<li><a href="<?php echo base_url(); ?>backend.php/profile/">Halaman Profil</a></li>
<!--						<li><a href="<?php echo base_url(); ?>backend.php/post/">Posts</a></li>-->
						<li><a href="<?php echo base_url(); ?>backend.php/assets/">Entry Mesin</a></li>
                                                <li><a href="<?php echo base_url(); ?>backend.php/schedule/">Entry Jadwal</a></li>
					</ul>
				</div>
				<div class="center-content">
					<form action="<?php echo base_url(); ?>backend.php/webinfo/savedata" enctype="multipart/form-data" class="forms" id="websettings-form" method="post">
						<fieldset>
							<legend>Informasi Website</legend>
							<div class="fieldcontainer">
								<label for="_title">Judul Website:</label>
								<input type="text" class="rounded" id="_title" name="_title" value="<?php echo $title; ?>" />*
							</div>
							<div class="fieldcontainer">
								<div style="width: 32px;">
									<img src="<?php echo $favicon; ?>" id="_imgfavicon" width="32" height="32" />
								</div>
								<div style="width: 80%;">
									<label for="_favicon">Icon:</label>
									<input type="file" class="rounded" id="_favicon" name="_favicon" width="80%" /><br />
                                                                        <span class="filling-info">
                                                                            Ukuran file maks.: 1 MB<br />
                                                                            Hanya file *.jpg, *.png dan *.gif<br />
                                                                            Ukuran icon: 32x32 pixel
                                                                        </span>
								</div>
							</div>
                                                        <div class="fieldcontainer">
								<label for="_username">Homescreen Text:</label>
                                                                <textarea class="wysiwyg-editor rounded" id="_hometext" name="_hometext"><?php echo $hometext; ?></textarea>
							</div>
							<div class="fieldcontainer">
								<label for="_username">Nama Pengguna:</label>
								<input type="text" class="hidden rounded" id="_userid" name="_userid" value="<?php echo $userid; ?>" />
								<input type="text" class="rounded" id="_username" name="_username" value="<?php echo $username; ?>" />*
							</div>
							<div class="fieldcontainer">
								<label for="_pass1">Password:</label>
								<input type="password" class="rounded" id="_pass1" name="_pass1" value="<?php echo $password; ?>" />*
								<input type="password" class="rounded" id="_pass2" name="_pass2" value="<?php echo $password; ?>" />*
							</div>
							<div class="fieldcontainer">
								<label for="_email">Email:</label>
								<input type="text" class="rounded" id="_email" name="_email" value="<?php echo $email; ?>" />
							</div>
							<div class="fieldcontainer center">
								<input type="button" id="btn-submit-webinfo" value="Simpan" />
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
