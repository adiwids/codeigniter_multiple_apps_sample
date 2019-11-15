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
		<title>Admin Site | Login</title>
		<link rel="shortcut icon" type="image/x-icon" href=""/>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/ui/backend-layout.css"/>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/backend-loginpage.js"></script>
	</head>
	<body class="normal">
		<div class="container">
			<div class="center-box">
                                <?php
                                    if(isset($message) && !empty($message))
                                    {
                                ?>
                                <div id="err-msg-box" class="box rounded" style="position: absolute;margin: -100px 0;">
                                    <div>
                                        <?php 
                                            $icon_url = "";
                                            switch($type)
                                            {
                                                case "ERR_PAGE":
                                                    $icon_url = "error.png";break;
                                                case "INFO_PAGE":
                                                    $icon_url = "info.png";break;
                                                default:
                                                    $icon_url = "info.png";break;
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
                                </div>
                                <?php
                                    }
                                ?>
				<form action="<?php echo base_url(); ?>backend.php/main/login" id="login-form" method="post">
					<div class="fieldcontainer">
						<label for="">Nama Pengguna:</label>
                                                <input type="text" class="rounded" id="_username" name="_username" />
					</div>
					<div class="fieldcontainer">
						<label for="">Password:</label>
                                                <input type="password" class="rounded" id="_password" name="_password" />
					</div>
					<div class="fieldcontainer">
						<label for="">Ketik kode di bawah:</label>
                                                <div><?php echo $captcha; ?></div>
                                                <input type="text" class="rounded" id="_captchacode" name="_captchacode" />
					</div>
					<div class="fieldcontainer">
						<input type="button" class="button" id="btn-submit-login" value="Log In" />
					</div>
				</form>
			</div>
		</div>
	</body>
</html>
