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