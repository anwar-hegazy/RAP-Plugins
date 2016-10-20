<?php
/*
+--------------------------------------------------------------------------
|
| v1.0.0
| Copyright ©2009 Genius Idea Studio, LLC. All Rights Reserved
|
| The sale, duplication or transfer of the script to any 
| person other than the original purchaser is a violation
| of the purchase agreement and is strictly prohibited.
|
| Any alteration of the script source code or accompanying 
| materials will void any responsibility of Rapid Action 
| Profits regarding the proper functioning of the script.
|
| By using this script you agree to the terms and conditions 
| of use of the script.   
|
| ================================================================
| RAP-tools Editor
| ================================================================
+--------------------------------------------------------------------------
*/

$title="RAP Tracker";
$description="Advanced Tracking For Your RAP Installs";
$folders=explode("/",$_GET['path']);
$groupfolder=$folders[0];
$addonfolder=$folders[1];

?>
<td align=center>
	<table align=center cellpadding=3 cellspacing=0>
		<tr align=center><td colspan=2><h2>Installing <?=$title?> Addon</h2></td></tr>
		<tr align=center><td colspan=2><h2>Creating Tracking Table:
		<?php
			/* Create any additional tables needed in the mySQL database for this Addon */
			/* ___________ Table structure for RAP_mde ________________________ */
			$querystr = "Create table if not exists GIS_HitTracking (uid int auto_increment, Date varchar(8), Time varchar(6), PID int, Affiliate varchar(50), Page varchar(50), Referrer text, IPAddress varchar(100), Returning int, Tracking varchar(200), Type int, Disposition int, DayOfWeek int, Hour int, primary key(uid))";
			@mysql_query($querystr);
		?>
		...Done...</h2></td></tr>
		

		<?php
			/* ____________ Define your AddOn Module to Rapid Action Profits _________________ */
			
			$sql="SELECT id FROM addons
				WHERE title='$title'";
			$addres=@mysql_query($sql);
			$addrec=@mysql_fetch_assoc($addres);
			
			if ($addrec[id]=="")
			{
				$sql="INSERT INTO addons (title, description, groupfolder, addonfolder)
					VALUES('".$title."','".$description."','".$groupfolder."','".$addonfolder."')";
				@mysql_query($sql);
				$id=@mysql_insert_id();
			}
			
			/*_________________________________________________________________________*/
			
		?>
		<tr align=center>
			<td align=right><div align="center">
				<img src="tick.jpg" width="15" height="15" /></div></td>
			<td align=left nowrap="nowrap">
				<font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?=$title?> Installed!</font></td>
		</tr>
		<form method=post action="<?=$_SERVER[PHP_SELF]?>?action=addon&id=<?=$id?>">
		<tr align=center>
			<td colspan=2 align=center>
				<input type=submit name="submit" id="submit" value="Go to <?=$title?> Admin">
			</td>
		</tr>
		</form>
	</table>
</td>