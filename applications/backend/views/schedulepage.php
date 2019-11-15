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
		<title><?php echo $title; ?> | Entry Jadwal</title>
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo $favicon; ?>"/>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>assets/ui/backend-layout.css"/>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery-1.7.1.min.js"></script>
		<script type="text/javascript"> var base_url = '<?php echo base_url(); ?>'; </script>
                <script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/tiny_mce/jquery.tinymce.js"></script>
                <script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/backend-schedulepage.js"></script>
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
						<li><a href="<?php echo base_url(); ?>backend.php/assets/">Entry Mesin</a></li>
                                                <li><a href="<?php echo base_url(); ?>backend.php/schedule/" class="current">Entry Jadwal</a></li>
					</ul>
				</div>
				<div class="center-content">
					<form action="<?php echo base_url(); ?>backend.php/schedule/savedata" enctype="multipart/form-data" class="forms" id="schedule-form" method="post">
						<fieldset>
							<legend>Entry Jadwal</legend>
                                                        <div class="fieldcontainer">
                                                            <label for="_schedid">ID:</label>
                                                            <input type="text" name="_schedid" id="_schedid" class="readonly rounded" />
                                                        </div>
                                                        <div class="fieldcontainer">
                                                            <label for=""></label>
                                                            <div class="asset-combo"></div>
                                                        </div>
                                                        <div class="fieldcontainer">
                                                            <label for="_notes">Nama perbaikan:</label>
                                                            <input type="text" name="_notes" id="_notes" class="rounded" />
                                                        </div>
                                                        <div class="fieldcontainer">
                                                            <label for="_type">Jenis:</label>
                                                            <select name="_type" id="_type" class="rounded">
                                                                <option value="1" selected="selected">Perawatan</option>
                                                                <option value="0">Perbaikan</option>
                                                                <option value="2">Pemeliharaan</option>
                                                            </select>
                                                        </div>
                                                        <div class="fieldcontainer">
                                                            <label for="">Waktu:</label>
                                                            <div class="date-picker"></div>
                                                            <input type="text" name="_scheddate" id="_scheddate" class="readonly rounded" />
                                                        </div>
                                                        <div class="fieldcontainer">
                                                            <label for="_attachment">File sisipan:</label>
                                                            <label for="_attachment" id="_txtattachment" class="filling-info"></label>
                                                            <input type="file" name="_attachment" id="_attachment" class="rounded" />
                                                            <span class="filling-info">
                                                                Ukuran file maks.: 12 MB<br />
                                                                Hanya file *.jpg, *.png, *.gif, *.xls, *.xlsx<br />
                                                                Ukuran gambar maks.: 1024x768 pixel
                                                            </span>
                                                        </div>
                                                        <div class="fieldcontainer center">
								<input type="button" id="btn-submit-schedule" value="Simpan" />
                                                                <input type="button" id="btn-delete-schedule" value="Hapus" />
                                                                <input type="button" id="btn-reset-schedule" value="Batal" />
							</div>
						</fieldset>
					</form>
                                    <div class="grids">
                                        <div>
                                            <label for="_fname">Cari nama mesin/perbaikan:</label>
                                            <input type="text" name="_fname" id="_fname" class="rounded" />
                                        </div>
                                        <table>
                                            <tr class="theader">
                                                <td width="5%">No.</td>
                                                <td>Tanggal</td>
                                                <td>Nama Mesin</td>
                                                <td>Nama Perbaikan</td>
                                                <td>Tipe Pemeliharaan</td>
                                                <td width="8%"></td>
                                            </tr>
                                            <?php echo "";//$records; ?>
                                        </table>
                                    </div>
				</div>
			</div>
		</div>
	</body>
</html>
