        <head>        
            <!-- META SECTION -->
            <title>IOR</title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta name="viewport" content="width=device-width, initial-scale=1" />
            
            <link rel="icon" href="<?=base_url();?>assets/css/assets/favicon/favicon.png" type="image/x-icon" />
            <!-- END META SECTION -->
            
            <!-- CSS INCLUDE -->        
            <!-- <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
            <?php if ($this->agent->is_mobile()){ ?>
            <link rel="stylesheet" type="text/css" id="theme" href="<?=base_url();?>assets/css/theme-blue.css"/>
            <?php } else { ?>
            <link rel="stylesheet" type="text/css" id="theme" href="<?=base_url();?>assets/css/theme-default.css"/>
            <?php } ?>
            <link rel="stylesheet" type="text/css" id="theme" href="<?=base_url();?>assets/css/tooltip.css"/>
            <link rel="stylesheet" type="text/css" id="theme" href="<?=base_url();?>assets/css/select2.css"/>
            <link rel="stylesheet" type="text/css" id="theme" href="<?=base_url();?>assets/css/jquery/jquery-confirm.css"/>
            
            <!-- <link rel="stylesheet" type="text/css" id="theme" href="<?=base_url();?>assets/css/sliders/ion.rangeSlider.css"/>
            <link rel="stylesheet" type="text/css" id="theme" href="<?=base_url();?>assets/css/sliders/ion.rangeSlider.skinHTML5.css"/> -->            

            <!-- EOF CSS INCLUDE -->                                    
        </head>