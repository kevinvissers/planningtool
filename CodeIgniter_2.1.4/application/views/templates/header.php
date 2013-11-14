<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <meta id="view" name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    
    <link rel="shortcut icon" href="<?php echo base_url() ?>images/favicon/calendar.ico" type="image/x-icon" />

    <link rel="stylesheet" href="<?php echo base_url() ?>css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>css/foundation.css">	
    <link rel="stylesheet" href="<?php echo base_url() ?>foundation-icons/foundation-icons.css">
    
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
    <link type="text/css" media="screen" rel="stylesheet" href="<?php echo base_url() ?>css/prettyPhoto.css" title="prettyPhoto main stylesheet" charset="utf-8" />
    
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="<?php echo base_url() ?>scripts/myScript.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>scripts/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
    
    <script src="<?php echo base_url() ?>js/vendor/custom.modernizr.js"></script>
    <style type="text/css">
        /* footer */
        /*.footer {position:fixed;left:0px;bottom:0px;width:100%;line-height: 24px;font-size: 11px;background: #fff;background: rgba(255, 255, 255, 0.5);text-transform: uppercase;z-index: 100;box-shadow: 1px 0px 2px rgba(0,0,0,0.2);}*/
        /* align right */
        span.right {float: right;}
        /* author signature */
        .author{font-family: "Courier New";margin-right: 5px;}
        /* fixed footer */
        footer {position:fixed;left:0px;bottom:0px;right:0px;width:100%;line-height: 20px;text-transform: uppercase;z-index: 100;}
        /* footer white background */
        .white{background-color:white;}
        /* move button from border */
        .has-button{margin-right:5px;}
        /* highlight today */
        .highlight{font-size:larger;}  
        
        
      .size-12 { font-size: 12px; }
      
      .size-14 { font-size: 14px; }
      
      .size-16 { font-size: 16px; }
      
      .size-18 { font-size: 18px; }
      
      .size-21 { font-size: 21px; }
      
      .size-24 { font-size: 24px; }
      
      .size-36 { font-size: 36px; }
      
      .size-48 { font-size: 48px; }
      
      .size-60 { font-size: 60px; }
      
      .size-72 { font-size: 72px; }
        /* weekKalender */
        /*.kalender_week_inhoud{position: absolute;background-color: white; margin-top: 50px; min-width: 500px; margin-left:20%; margin-right:20%; }
        .week_hoofding{width: 200px;}
        .week_inhoud{height: 200px;}
        .calendarDay{}
        /*.calendarDetail td:hover{background-color: grey;}*/
       /* .calendarDetail{}
        #displayCalendarBefore{}
        #displayCalendarAfter{}
        .tijdstip{font-family: monospace;font-size: 0.8em;}
        
        /* afspraken */
        /*div.afspraken{background-color: white;height:370px;margin-top:50px;margin-left: 50px;}*/
        /* overige */
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
            <?php echo $script ?>
    </script>
</head>
<body>
    <?php echo $menu; ?>


        
    

