<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if ($description) { ?>
    <meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
    <base href="<?php echo $base; ?>" />
<?php if ($icon) { ?>
    <link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
    <link href="<?php echo str_replace('&', '&amp;', $link['href']); ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<?php foreach ($styles as $style) { ?>
    <link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>  
<?php if($direction=="rtl"){ ?>    
    <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/javascript/resources/css/ext-all-gray-rtl.css" />
    <script type="text/javascript" src="<?php echo $theme; ?>/javascript/ext-all-rtl.js"></script>     
    <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/stylesheet-rtl.css" />
    <?php if($this->config->get('config_language')=="ar"){ ?>    
    <style>
            @font-face
            {
                font-family: AL-Mohanad;
                src: url('<?php echo $theme; ?>/stylesheet/fonts/al-mohanad-bold.ttf');
            } 
            .x-body, *{
                font-family:'AL-Mohanad',AL-Mohanad,Arial,Tahoma !important;

            }

            .user_logged {
              
            }
    </style>
    <?php } else { ?>
        <style>
                @font-face
                {
                    font-family: alvi;
                    src: url('<?php echo $theme; ?>/stylesheet/fonts/NafeesWeb.ttf');
                } 
                .x-body, *{
                    font-family:alvi,Arial,Tahoma !important;
                    font-weight: bold;
                }

                
                
        </style>
    <?php } ?>  
<?php } else { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/javascript/resources/css/ext-all-gray.css" />
    <script type="text/javascript" src="<?php echo $theme; ?>/javascript/ext-all.js"></script> 
    <link rel="stylesheet" type="text/css" href="<?php echo $theme; ?>/stylesheet/stylesheet.css" />
    <style type="text/css">
      .x-body, *{
                    /*font-family:alvi,Arial,Tahoma !important;*/
                    font-weight: 500;
                }
    </style>
<?php } ?>



<?php foreach ($scripts as $script) { ?>
    <script type="text/javascript" src="<?php echo $script; ?>"></script> 
<?php } ?>  
<script type="text/javascript" src="<?php echo $theme; ?>/javascript/jquery.js"></script> 
</head>

<body>    
<?php


if($this->config->get('config_message')){
$api_token = $this->config->get('api_password');
$api_secret = $this->config->get('api_username');
$url="http://sms.aursoft.com/balance-inquiry?api_token=".urlencode($api_token)."&api_secret=".urlencode($api_secret)."";
$ch  =  curl_init();
$timeout  =  30;
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$response = curl_exec($ch);
curl_close($ch);

    if(isset($response)){ ?>
    <div style="position: absolute;right: 45%;top: 9px;color: white;font-size: 14px;font-weight: bold">Remaining Credit : <?php echo $response; ?> </div>    
    <?php } 
}?>

<?php if($logged){ ?>
<div class="user_logged" style="font-size: 19px;word-spacing: 5px;text-decoration: underline;"><?php echo $this->config->get('config_owner') ?></div>
<div class="user_logged storeDesc" style=""><?php echo $this->config->get('config_store_description') ?></div>
    <div class="aursoft_logo" id="aursoft_logo"></div>    
<?php } else { ?>
<div class="inventory_flow_home" id="inventory_flow_logo"></div>    
<div class="aursoft_logo at-bottom" id="aursoft_logo"></div>    
<?php } ?>
 
 <div class="store_name <?php if($logged){ ?>fix-store-name<?php } ?>" id="store_name"  >
     <!-- <div class="name"><?php echo $this->config->get('config_owner') ?></div> -->
     <!-- <div class="description"><?php echo $this->config->get('config_store_description') ?></div> -->
 </div>    
<div class="help_button" id="help_btn"></div>
<script type="text/javascript">
  var main_view_port = null; 
  var store_name = "<?php echo $this->config->get('config_owner') ?>";
  var use_message = "<?php echo $this->config->get('config_message') ?>";
  var api_username = "<?php echo $this->config->get('api_username') ?>";
  var api_password = "<?php echo $this->config->get('api_password') ?>";
  var masking = "<?php echo $this->config->get('masking') ?>";
  var barcodeLabel = "<?php echo $this->config->get('barcodeLabel') ?>";
  var label_design_1 = "<?php echo $this->config->get('label_design_1') ?>";
  var label_design_2 = "<?php echo $this->config->get('label_design_2') ?>";
  var label_design_3 = "<?php echo $this->config->get('label_design_3') ?>";
  var label_design_4 = "<?php echo $this->config->get('label_design_4') ?>";
  var label_design_5 = "<?php echo $this->config->get('label_design_5') ?>";
  var userKey_barcodeLabel = "<?php echo $this->config->get('userKey_barcodeLabel') ?>";
  //var barcodeDesignJson = "<?php echo $this->config->get('barcodeDesignJson') ?>";
  Ext.onReady(function(){   
      
      Ext.QuickTips.init();
      main_view_port = Ext.create('Ext.Viewport', {
        layout: 'border',
        rtl: <?php if($direction=="rtl"){ ?>true <?php } else{ ?>false<?php }?>  ,
        id:'main_layout',
        title: '&nbsp;',
        cls:'bg-color',
        items: [{
             region: 'center',
             margins: '0 5 0 5',
             activeItem: 0,
             border: false,
             bodyBoder:false,
             id : 'main_center_panel',
             layout: 'card',
             items:[]
        }
        ,{
            xtype: 'box',
            id: 'header',
            region: 'north',
            height: 40           
            
        },{
             region: 'west',
             id : 'main_left_panel',
             title:'<h2><?php echo $text_shortcuts; ?></h2>',
             layout:'fit',
             border: false,
             html :''
         }
        ],
        renderTo: Ext.getBody()
    });
  })
</script>    