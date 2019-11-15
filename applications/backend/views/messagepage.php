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
		<title><?php echo $title; ?></title>
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo $favicon; ?>"/>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/ui/backend-layout.css"/>
                <script type="text/javascript"> var base_url = '<?php echo base_url(); ?>'; </script>
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
<!--						<li><a href="<?php echo base_url(); ?>backend.php/post/">Posts</a></li>-->
						<li><a href="<?php echo base_url(); ?>backend.php/schedule/">Entry Jadwal</a></li>
					</ul>
				</div>
				<div class="center-content">
                                    <div class="box rounded">
                                        <div>
                                            <?php 
                                                $icon_url = "";
                                                switch($type)
                                                {
                                                    case "ERR_PAGE":
                                                        $icon_url = "App-error-icon.png";break;
                                                    case "INFO_PAGE":
                                                        $icon_url = "Information-icon.png";break;
                                                    default:
                                                        $icon_url = "Information-icon.png";break;
                                                }
                                            ?>
                                            <img src="<?php echo base_url(); ?>assets/images/<?php echo $icon_url; ?>" />
                                       </div>
                                        <div>
                                            <h2><?php echo $title; ?></h2>
                                        </div>
                                        <div class="message-content">
                                            <p><?php echo $message; ?></p>
                                        </div>
                                        <div>
                                            <a href="<?php echo $backlink; ?>" class="button">&Ll;Kembali</a>
                                        </div>
                                    </div>
				</div>
			</div>
		</div>
	</body>
</html>
