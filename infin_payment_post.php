<?php

//settings
$payment_base_url   = "http://py-gui0903.infin-connect.de/extern/gui_ci/main.php";

$api_key            = get_option('api_key');
$country_code       = 'de';
$amount             = '0.00';
$session_id         = md5(date("YmdHis").$callback_url);
$service_name       = URLencode(get_option('company'));
$product_name       = URLencode(get_option('product'));
$button_text        = get_option('buttontext');
if(!$button_text)
    $button_text    = "Buy with infin-Payment";

$url                = "$payment_base_url?api_key=$api_key&country_code=$country_code&session_id=$session_id&infin_sn=$service_name&infin_pn=$product_name&wpsid=".session_id();
$pluginpath         = plugin_dir_url(__FILE__);

//injecting some style and javascript
echo <<<EOT

<style>
    .price {
        color: #880000;
        font-size: 125%;
        font-weight: bold;
        clear: both;
    }

    .paidorfree {
        color: #008800;
        font-size: 125%;
        font-weight: bold;   
        clear: both;
    }

    .paymentbutton {
        border: 0px solid #AAAAAA;
        background-color: #CCCCCC;
        background-image: url('{$pluginpath}infin-payment-button.png');
        display: inline;
        background-repeat: no-repeat;
        background-position: left middle;
        padding: 7px;
        padding-left: 40px;
        font-size: 16px;
        font-weight: normal;
        color: #111111;
        cursor: pointer;
    }

    .premiumcontent {
        border: 2px solid #FFFF88;
        background-color: #FFFFDD;
        padding:8px;
    }

    .titlepremium {
        font-size: 9px;
        color: #000000;
        background-color: #FFFF88;
        margin-top: -8px;
        margin-right: -8px;
    }

</style>

<script>

var paymentStarted = 0; 
var paymentWindow  = 0;

function checkPaymentWindow()
{
    if(paymentStarted && (typeof(paymentWindow) == 'undefined' || paymentWindow.closed))
        document.location.reload();
}

function openPaymentWindow(url,winName) { 
    var width           = 600;
    var height          = 600;
    
    var left            = parseInt((window.width/2) - (width/2));
    var top             = parseInt((window.height/2) - (height/2));    

    var windowFeatures  = "width=" + width + ",height=" + height + ",status,resizable,left=" + left + ",top=" + top + "screenX=" + left + ",screenY=" + top;

    paymentStarted      = 1;
    paymentWindow       = window.open(url, winName, windowFeatures);
    timed               = setInterval(function(){checkPaymentWindow()},1000);
}
</script>
EOT;
?>