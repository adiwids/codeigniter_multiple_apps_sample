<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="EN" lang="EN" dir="ltr">
<head profile="http://gmpg.org/xfn/11">
<title><?php echo $webtitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="imagetoolbar" content="no" />
<link href="<?php echo $favicon; ?>" rel="shortcut icon" type="image/icon" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/ui/frontend-layout.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/ui/frontend-forms.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/ui/frontend-navi.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/ui/frontend-tables.css" type="text/css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/scripts/frontend-aboutpage.js"></script>
</head>
<body id="top">
<div class="wrapper col1">
  <div id="header">
    <div id="logo">
      <h1><a href="<?php echo base_url(); ?>"><?php echo $webtitle; ?></a></h1>
      <p><strong><?php echo ""; ?></strong></p>
    </div>
    <div id="newsletter" style="display: none;">
      <p>Log in to manage website's contents</p>
      <form action="<?php echo base_url(); ?>backend.php/main/login" name="top-form-login" id="top-login-form" method="post">
        <fieldset>
          <legend>NewsLetter</legend>
          <input type="text" name="_username" id="top-username" value="" />
          <input type="text" name="_password" id="top-password" value="" />
          <input type="button" id="top-btn-login" value="Log In" />
        </fieldset>
      </form>
    </div>
    <br class="clear" />
  </div>
</div>
<div class="wrapper col2">
  <div id="topbar">
    <div id="topnav">
      <ul>
        <li><a href="<?php echo base_url(); ?>frontend.php/home">Beranda</a></li>
        <li class="active"><a href="<?php echo base_url(); ?>frontend.php/profile">Profil</a></li>
        <li><a href="#">Pemeliharaan</a>
          <ul>
            <li><a href="<?php echo base_url(); ?>frontend.php/maint/?pid=2">Jadwal Pemeliharaan</a></li>
            <li><a href="<?php echo base_url(); ?>frontend.php/maint/?pid=1">Jadwal Perawatan</a></li>
            <li><a href="<?php echo base_url(); ?>frontend.php/maint/?pid=0">Jadwal Perbaikan</a></li>
          </ul>
        </li>
        <li><a href="<?php echo base_url(); ?>frontend.php/aboutme">Tentang Saya</a></li>
      </ul>
    </div>
    <div id="search">

    </div>
    <br class="clear" />
  </div>
</div>
<div class="wrapper col5">
  <div id="container">
    <div id="content">
      <h2><?php echo $posttitle; ?></h2>
      <img src="<?php echo $attachment; ?>" class="image-post" />
      <?php echo $content; ?>
      <span class="post-info">
          <b>Author:</b> <?php echo $author; ?> | <b>Last update:</b> <?php echo $last_updated_at; ?>
      </span>
    </div>
    <br class="clear" />
  </div>
</div>
<div class="wrapper col6">
  <div id="footer">
    <div id="login">
      <h2>Admin Site</h2>
      <p>Untuk mengelola isi website, silahkan akses halaman <a href="<?php echo base_url(); ?>backend.php/main">admin site</a>.</p>
    </div>
    <div class="footbox">
      <h2>Perawatan</h2>
      <ul>
      <?php
        $lists = "<li><a href='#'>...</a></li>";
        if(!is_null($rawatlist))
        {
            if(count($rawatlist) > 0)
            {
                $lists = "";
                for($l = 0;$l < count($rawatlist);$l++)
                {
                    $lists .= "<li>
                                <a href='".base_url()."frontend.php/maint/readpost?pid=".$rawatlist[$l]['scheduleid']."'>[".$rawatlist[$l]['schedule_date']."] ".$rawatlist[$l]['name']."</a>
                               </li>
                    ";
                }
            }
        }
        echo $lists;
      ?>
      </ul>
    </div>
    <div class="footbox">
      <h2>Perbaikan</h2>
      <ul>
      <?php
        $lists = "<li><a href='#'>...</a></li>";
        if(!is_null($baiklist))
        {
            if(count($baiklist) > 0)
            {
                $lists = "";
                for($l = 0;$l < count($baiklist);$l++)
                {
                    $lists .= "<li>
                                <a href='".base_url()."frontend.php/maint/readpost?pid=".$baiklist[$l]['scheduleid']."'>[".$baiklist[$l]['schedule_date']."] ".$baiklist[$l]['name']."</a>
                               </li>
                    ";
                }
            }
        }
        echo $lists;
      ?>
      </ul>
    </div>
    <div class="footbox">
      <h2>Pemeliharaan</h2>
      <ul>
      <?php
        $lists = "<li><a href='#'>...</a></li>";
        if(!is_null($peliharalist))
        {
            if(count($peliharalist) > 0)
            {
                $lists = "";
                for($l = 0;$l < count($peliharalist);$l++)
                {
                    $lists .= "<li>
                                <a href='".base_url()."frontend.php/maint/readpost?pid=".$peliharalist[$l]['scheduleid']."'>[".$peliharalist[$l]['schedule_date']."] ".$peliharalist[$l]['name']."</a>
                               </li>
                    ";
                }
            }
        }
        echo $lists;
      ?>
      </ul>
    </div>
    <br class="clear" />
  </div>
</div>
<div class="wrapper col7">
  <div id="copyright">
    <p class="fl_left">Registered &reg; <?php echo date("Y"); ?> - All Rights Reserved - <a href="<?php echo base_url(); ?>"><?php echo $_SERVER['HTTP_HOST']; ?></a></p>
    <p class="fl_right" style="color: transparent;">Template by <a style="color: transparent;" href="http://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p>
    <br class="clear" />
  </div>
</div>
</body>
</html>