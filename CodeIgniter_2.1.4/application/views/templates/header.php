<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <meta id="view" name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    
    <link rel="shortcut icon" href="<?php echo base_url() ?>images/favicon/calendar.ico" type="image/x-icon" />

    <link rel="stylesheet" href="<?php echo base_url() ?>css/normalize.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>css/foundation.css" />	
    <link rel="stylesheet" href="<?php echo base_url() ?>foundation-icons/foundation-icons.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>css/basic.css" type="text/css" />
    
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
    <link type="text/css" media="screen" rel="stylesheet" href="<?php echo base_url() ?>css/prettyPhoto.css" title="prettyPhoto main stylesheet" charset="utf-8" />
    
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="<?php echo base_url() ?>scripts/myScript.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>scripts/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
    
    <script src="<?php echo base_url() ?>js/vendor/custom.modernizr.js"></script>
    <style type="text/css">
        <?php echo $style; ?>
    </style>
    <script>
        $(function() {
                $( "#dialog" ).dialog({
                    dialogClass: "no-close",
                    modal: true,
                    width: 'auto'
                });
            });
         $(function() {
            $( "#datepicker" ).datepicker();
            });    
        <?php echo $script ?>
    </script>
</head>
<body>
    <?php echo $menu; ?>


        
    

