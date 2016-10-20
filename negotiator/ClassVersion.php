<?php
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright 2009, 2010 Genius Idea Studio, LLC. All Rights Reserved
|
| The sale, duplication or transfer of the script to any 
| person other than the original purchaser is a violation
| of the purchase agreement and is strictly prohibited.
|
| Any alteration of the script source code or accompanying 
| materials will void any responsibility of Genius Idea 
| Studio, LLC regarding the proper functioning of the script.
|
| By using this script you agree to the terms and conditions 
| of use of the script.   
|
| ================================================================
| RAP-tools.com Themes
| ================================================================
+--------------------------------------------------------------------------
*/

if ($_REQUEST['action'] == "register") { ?>

	<link rel='stylesheet' type='text/css' href='css/styles.css'>
	
	<form id="registrationform" name="registrationform" method="post" action="/rap_admin/addons/GIS/themes/ClassVersion.php">
	<input type="hidden" name="action" value="registration">
	<input type="hidden" name="title" value="<?= $_REQUEST['title']; ?>">
	<table width="500">
	<tr><td>&nbsp;</td></tr>
	<tr><td class="Prompts" colspan="3">Before you can use the Themes addon you need to register it using the paypal email address you used when you purchased the addon.<br><br>Enter in the email address in the field below and click the Register button.</td></tr>
	<tr><td>&nbsp;</td></tr>
 	<tr><td class="Prompts">Email Address:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="Email" id="Email"></td></tr>
 	<tr><td>&nbsp;</td></tr>
 	<tr><td></td><td></td><td><input type="submit" name="submit" id="submit" value="Register" /></td></tr>
 	</table>
 	</form>
<?	
}

if ($_REQUEST['action'] == "registration") {

	$modregister = new ModVersion;

	$success = $modregister->register($_REQUEST['Email'], $_REQUEST['title']);
	
	echo "<link rel='stylesheet' type='text/css' href='css/styles.css'>";
	if ($success == '1') {
		echo "<p class=\"Prompts\">Congratulations this domain is now registered.  Click the continue link below to return to the main RAP interface.<br><br><a href=\"/rap_admin\" target=\"_top\">Continue...</a></p>";
	} else {
		echo "<p class=\"Prompts\">We are sorry but we could not find that email address for this product.  Click the Continue link below to return to the registration page.<br><br><a href=\"?action=register&title=" . $_REQUEST['title'] . "\">Continue...</a></p>";	
	}
	
}


class ModVersion
{
	function versioninfo()
	{
		$title = title;
		$version = version;
	
		$lv = $this->versioncheck();
		
		$latestversion = $lv[0];
		$upgradeURL = $lv[1];
		$addonsuppt = $lv[2];
		$reg=$lv[3];

		if ($reg == '0') { 
			$reg = "Unregistered"; 
			$html="
				
				<iframe src='addons/GIS/themes/ClassVersion.php?action=register&title=" . $title . "' width='800' height='800' frameborder='0'>
					
				</iframe>";
		} else {
		
			$upgrade = (version < $latestversion) ? "<a target=_blank href=$upgradeURL><font color=Red>Download Current Release.</font></a>" : "<font color=green>You have the latest version.</font>" ;
			$currentv = $latestversion;
		
			$html="
				
				<table width='800' cellpadding='2' cellspacing='0' border='0'>
					<tr>
						<td align='center' valign='top' class='admin_index_news_border'>
							<table width='100%' cellpadding='2' cellspacing='0' border='0'>
								<tr>
									<td style=\"width: 170px face: georgia\">Your Version: $version</td>
									<td style=\"width: 170px face georgia\">Current Version: $currentv</td>
									<td ><center>$upgrade</center></td>
									<td align=\"right\">Registered to: $reg</td>
								</tr>
							</table>

						</td>
					</tr>
				</table>";
			
			
		}
		return $html;
	}

	
	function g_getSecretCode($g_url) {

		$g_url = trim($g_url);
		$g_code = 0;
	
		for ($l=0; $l<strlen($g_url); ++$l) {
			$g_code += ord(substr($g_url,$l,1));
		}
	
		return $g_code;
	}
	
	
	function register($g_emailAddress, $title) {
	
		$file = "http://rap-tools.com/rap_admin/addons/GIS/regmgr/register.php?pr=" . $title . "&dn=" . $_SERVER['HTTP_HOST'] . "&pe=" . $g_emailAddress . "&sc=" . $this->g_getSecretCode($_SERVER['HTTP_HOST']);
		$file = str_replace(" ", "%20", $file);
		
		$fp   = @fopen($file,"r");
		if ($fp) {
		    $line = @fgets($fp,1024);
		    fclose($fp);
		}
		if ($line == "1") {
			//success
			return 1;
		} else {
			//failed
			return 0;
		}
			
	}
	
	
	function versioncheck(){
		$title = title;

		//get the addons
		$line = $this->readAddonsFile();

		$line = ereg_replace("#.*$","",$line);

	    list($name,$value,$url,$suptlnk,$reg) = explode("|",$line);
	    $mb_info[trim($name)] = array(trim($value),trim($url),trim($suptlnk),trim($reg));
	    return $mb_info[$title];    
	}

	function readAddonsFile()
	{
		$title = title;

		$myaddons = "";

        $file = "http://rap-tools.com/rap_admin/addons/GIS/regmgr/verify.php?pr=" . $title . "&dn=" . $_SERVER['HTTP_HOST'];
        $file = str_replace(" ", "%20", $file);

		$fp   = @fopen($file,"r");
		if ($fp) {
		    while($line = @fgets($fp,1024))
		    {
		    	$myaddons .= $line;
		    }
		    fclose($fp);
		}
		return $myaddons;
	}
}
?>