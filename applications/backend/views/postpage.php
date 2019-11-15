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
		<title><?php echo $title; ?> | Post</title>
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo $favicon; ?>"/>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/ui/backend-layout.css"/>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery-1.7.1.min.js"></script>
		<script type="text/javascript"> var base_url = '<?php echo base_url(); ?>'; </script>
                <script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/tiny_mce/jquery.tinymce.js"></script>
                <script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/backend-postpage.js"></script>
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
						<li><a href="<?php echo base_url(); ?>backend.php/webinfo/">Informasi Website</a></li>
						<li><a href="<?php echo base_url(); ?>backend.php/home/">Halaman Beranda</a></li>
						<li><a href="<?php echo base_url(); ?>backend.php/aboutme/">Halaman Tentang Saya</a></li>
						<li><a href="<?php echo base_url(); ?>backend.php/profile/">Halaman Profil</a></li>
<!--						<li><a href="<?php echo base_url(); ?>backend.php/post/"  class="current">Posts</a></li>-->
						<li><a href="<?php echo base_url(); ?>backend.php/assets/">Entry Mesin</a></li>
                                                <li><a href="<?php echo base_url(); ?>backend.php/schedule/">Entry Jadwal</a></li>
					</ul>
				</div>
				<div class="center-content">
					<form action="<?php echo base_url(); ?>backend.php/post/savedata" enctype="multipart/form-data" class="forms" id="post-form" method="post">
						<fieldset>
                                                    <legend>Post</legend>
							<!--<div class="fieldcontainer">
								<div style="width: 100%;">
									<img src="<?php echo ""; ?>" id="_imgphoto" width="100%" />
								</div>
								<div style="width: 80%;">
									<label for="_favicon">Foto:</label>
									<input type="file" class="rounded" id="_photo" name="_photo" width="80%" />
								</div>
							</div>-->
                                                        <div class="fieldcontainer composite">
								<label for="_title">Judul:</label>
								<input type="text" class="rounded" id="_title" name="_title" value="<?php echo ""; ?>" />
                                                                <input type="text" class="rounded" id="_ispublish" name="_ispublish" value="<?php echo ""; ?>" />
                                                                <input type="checkbox" name="_published" id="_published" readonly="readonly" />Published
                                                        </div>
                                                        <div class="fieldcontainer composite">
								<label for="_title">Penulis:</label>
								<input type="text" class="readonly rounded" id="_author" name="_author" value="<?php echo ""; ?>" />
                                                                <input type="text" class="readonly rounded" id="_lastupdated" name="_lastupdated" value="<?php echo ""; ?>" />
							</div>
                                                        <div class="fieldcontainer">
								<label for="_title">Tags:</label>
								<input type="text" class="rounded" id="_tag" name="_tag" value="<?php echo ""; ?>" />
							</div>
                                                        <div class="fieldcontainer">
                                                            <input type="text" class="hidden rounded" id="_postid" name="postid" value="<?php echo ""; ?>" />
								<label for="_username">Isi:</label>
                                                                <textarea class="wysiwyg-editor rounded" id="_content" name="content"><?php echo ""; ?></textarea>
							</div>
							<div class="fieldcontainer center">
								<input type="button" id="btn-submit-publish" value="Publish" />
                                                                <input type="button" id="btn-submit-save" value="Simpan" />
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
