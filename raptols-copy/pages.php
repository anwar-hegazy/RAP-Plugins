<?
//==============================================================================================
//
//	Filename:	pages.php
//
//	Author:		Mike Myers
//	Email:		mike@geniusideastudio.com
//	Blog:		mikemyers.me
//	Support:	www.askmikemyers.com
//
//	Copyright:	Copyright, 2009(c), Genius Idea Studio, LLC
//
//	Product Is Available For Download From www.rap-tools.com
//
//	Description:	This file is called when the Files accordian is opened. 
//
//	Version:	1.0.0 (December 23rd, 2009)
//
//	Change Log:
//				12/23/09 - Initial Version (JMM)
//
//==============================================================================================

require_once("../../../settings.php");



?>

<script type="text/javascript">

function ProductSelected(form) {
		
	var pid = jQuery('#products').val();

	jQuery('#PageList').show();

	jQuery.post("addons/GIS/raptools/product_options.php", { pid: pid},
			function(data){
				jQuery('#product-options-dis').html(data);
		  	}
		);
}

function PageSelected(form) {
	
	var pid = jQuery('#products').val();
	var flnm = jQuery('#flnm').val();

	jQuery('#product-options-dis').show();
	jQuery('#product-options-dis').html(loadingimage);

	jQuery.post("addons/GIS/raptools/file_edit.php", { pid: pid, flnm: flnm},
			function(data){
				jQuery('#product-options-dis').html(data);
		  	}
		);
}

</script>

<script type="text/javascript" src="addons/GIS/raptools/js/rap-tools.js"></script>

<?
	//If an error message was passed in then display the error message in a red box.
	if ($_POST['errormessage'] != "") { ?>
		<div class="rounded-box-red" id="error-box">
    	    <div class="box-contents">
        <? echo $_POST['errormessage']; ?>
    		</div> 
		</div>
		<br>
		<script type="text/javascript">
			jQuery('#error-box').effect("pulsate", { times:3 }, 2000);
			jQuery('#error-box').fadeOut(10000);
		</script>
<?	} 

	//If a message was passed in display the message in a green box.
	if ($_POST['message'] != "") { ?>
		<div class="rounded-box-green" id="message-box">
    	    <div class="box-contents">
        <? echo $_POST['message']; ?>
    		</div> 
		</div>
		<br>
		<script type="text/javascript">

			jQuery('#message-box').fadeOut(20000);

		</script>
<?	} ?>



<table valign="top"><tr valign="top"><td valign="top">
<div id='productslist'>
<select name="products" size="10" id="products" class="productslist" onClick="ProductSelected(this.form)">
  <option value="-1">Global</option> 
<?php 
	//Build a list of products in the select list 
	$query = "select * from products order by item_name;";		
	$request = mysql_query($query);
	while ($rs = mysql_fetch_array($request)){	
		echo "<option value=\"" . $rs['id'] . "\">" . $rs['item_name'] . "</option>";
	}

?>
 </select>
 
</div></td><td valign="top">

<div id='PageList' style="display:none">
<select name="page" size="10" id="page" class="productslist" onClick="PageSelected(this.form)">
   <option value="aboutus.html">About Us</option>
   <option value="contactus.html">Contact Us</option>
   <option value="privacy.html">Privacy Policy</option>
 </select>
</div>
</td></tr></table>

<div style='clear:both;'></div>
<div class='gis-content padding-rl-20' style="display:none" id="product-options-dis">xxxxxxxxxxxxxx</div>

<script type='text/javascript'>

jQuery(document).ready(function(){

	showProductOptions();
	}

</script>