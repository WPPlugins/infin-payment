<?php
	$payment_base_url = "http://py-gui0903.infin-connect.de/extern/gui_ci/main.php";
	$api_request_url  = "http://py-gui0903.infin-connect.de/extern/gui_ci/main.php/wpdemo/";
?>

<script>
	function get_API_KEY()
	{       
        urlpay = "<?php echo urlencode($api_request_url.'?callbackurl='.urlencode(plugin_dir_url(__FILE__).'callback.php')); ?>";
        url = "<?php echo plugin_dir_url(__FILE__).'ajax.php?url=';?>"+urlpay;
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET",url,false);
        xmlhttp.send();
        document.getElementById("api_key").value=xmlhttp.responseText;
	}
</script>

<div class="wrap">
    <h2>infin-Payment Settings</h2>
    <form method="post" action="options.php"> 
        <?php @settings_fields('infin_payment-group'); ?>
        <?php @do_settings_fields('infin_payment-group'); ?>

        <table class="form-table">  
            <tr valign="top">
                <th scope="row"><label for="api_key">API-KEY</label></th>
                <td><input type="text" name="api_key" id="api_key" value="<?php echo get_option('api_key'); ?>" / style='width: 300px'> <button onClick="get_API_KEY();">Get a demo_API-KEY</button></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="company">Company name</label></th>
                <td><input type="text" name="company" id="company" value="<?php echo get_option('company'); ?>" /> set to something relevant, so we can help you debug</td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="company">Product name</label></th>
                <td><input type="text" name="product" id="product" value="<?php echo get_option('product'); ?>" /> set to something relevant, so we can help you debug</td>
            </tr>
			<tr valign="top">
                <th scope="row"><label for="buttontext">Text on payment-button</label></th>
                <td><input type="text" name="buttontext" id="buttontext" value="<?php echo get_option('buttontext'); ?>" /> for example "Click here to pay"</td>
            </tr>
        </table>

        <?php @submit_button(); ?>
    </form>
    <br>
    <?php
    	$api_key 		= get_option('api_key');
    	$country_code 	= 'de';
    	$amount 		= '1.00';
    	$session_id     = md5(date("YmdHis")."whateverseed");    	
    	$service_name   = URLencode(get_option('company'));
    	$product_name   = URLencode(get_option('product'));

    	$url = "$payment_base_url?api_key=$api_key&country_code=$country_code&amount=$amount&session_id=$session_id&infin_sn=$service_name&infin_pn=$product_name";
    ?>

    <a href='http://www.infin.de/service/index.php?mini=mehr-info&page=MI_NEWEN&selektiert=payment&activetab=tabs1-mp' target=_blank title="Please register here for the paperwork needed to retrieve your money"><input type="button" class="button button-primary" value="Retrieve your money"></a><br><br><hr>

    <b>This is typically the URL which will be called for a payment:</b> <a href='<?php echo $url; ?>' target=_blank><?php echo $url; ?></a>
    <br><br>

    
</div>
