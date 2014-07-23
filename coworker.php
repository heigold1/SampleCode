<?php
require("../Include/intranet.inc.php");


  if ($_SESSION[session_current] != '1')
  {
    sendtologout();	
  } else {

  	write_header('utilities','Y'); 
//while(list($key,$val) = each($_REQUEST)){ echo "$key = $val<br>"; }

	$coFname = $_POST[coFname];
	$coLname = $_POST[coLname];
	$coEmail = $_POST[coEmail];
	$coPhone = $_POST[coPhone];
	$coPosition = $_POST[coPosition];
	$coBusiness = $_POST[coBusiness];
	$coFacility = $_POST[coFacility];
	if($_POST[coAccess] == 'on'){ $coAccess = 1;}
	if($_POST[coAdmin] == 'on'){ $coAdmin = 1;}
	$coUname = $_POST[coUname];
	$coPassword = $_POST[coPassword];
	if($_REQUEST[preEdit] != ''){ $coID = $_REQUEST[preEdit];}else{ $coID = $_POST[coID];};

	unset($error_found);
	unset($error_text);
		
	if ((isset($_POST[insCoworker])) || (isset($_POST[editCoworker])))
	{

		if ($coFname == ''){$error_text = "You must enter a First Name.<br>";}
		if ($coLname == ''){$error_text .= "You must enter a Last Name.<br>";}
		if ($coEmail == ''){$error_text .= "You must enter an Email address.<br>";}
		if ($coPosition == ''){$error_text .= "You must enter a Position.<br>";}
		if ($coBusiness == ''){$error_text .= "You must enter a Line of Business.<br>";}
		if ($coFacility == ''){$error_text .= "You must enter the Facility name.<br>";}
		if (($coAccess == '1') && ($coUname == '')){$error_text .= "You must enter a User Name for Intranet Access.<br>";}
		if (($coAccess == '1') && ($coPassword == '')){$error_text .= "You must enter a Password for Intranet Access.<br>";}
		
		if(!isset($error_text))
		{
			if (isset($_POST[insCoworker]))
			{
				$sqlMaxCoID = "SELECT MAX(co_id) AS max_id " .
						  	  "FROM tblCoworkers;";

				$resultMaxCoID = $db->Query($sqlMaxCoID);
				$my_row = $db->FetchRow($resultMaxCoID);

				if ($my_row)
				{

					$new_co_id = $my_row[0] + 1;
				}
				else
				{
					$new_co_id = 1;
				}				
				


				$sql = "INSERT INTO tblCoworkers " .
					   "(co_id,co_fname,co_lname,co_email,co_phone,co_position,co_business,co_facility,co_userid,co_pwd,co_intranet,co_admin) " .
					   "VALUES " .
					   "($new_co_id,'$coFname','$coLname','$coEmail','$coPhone','$coPosition','$coBusiness',$coFacility,'$coUname','$coPassword','$coAccess','$coAdmin');";

				$result = $db->Query($sql);
				
				$error_text = "Coworker $coFname $coLname was successfully added.";

			}elseif(isset($_POST[editCoworker])){
				
				$sql = "UPDATE tblCoworkers " .
					   "SET co_fname = '$coFname', co_lname = '$coLname', co_email = '$coEmail', " .
					   "co_phone = '$coPhone', co_position = '$coPosition', co_business = '$coBusiness', co_facility = $coFacility, " .
					   "co_userid = '$coUname', co_pwd = '$coPassword', co_intranet = '$coAccess', co_admin = '$coAdmin' " .
					   "WHERE co_id = $coID";
					   
				$result = $db->Query($sql);
				
				$error_text = "Coworker $coFname $coLname was updated.";
				
			}
		}else{
			$error_found = 1;
		}
		unset($_POST[insCoworker]);
		unset($_POST[editCoworker]);
	
	}
	
	if (($_POST[preInsert] != '') || ($_REQUEST[preEdit] != '') || (isset($error_found)))
	{
		if (($_REQUEST[preEdit] != '') && (!isset($error_found)))
		{
			$sql = "SELECT * FROM tblCoworkers " .
				   "WHERE co_id = $coID";

			$result = $db->Query($sql);

			$co_row = $db->FetchRow($result,3);
			
			$coFname = $co_row[co_fname];
			$coLname = $co_row[co_lname];
			$coEmail = $co_row[co_email];
			$coPhone = $co_row[co_phone];
			$coPosition = $co_row[co_position];
			$coBusiness = $co_row[co_business];
			$coFacility = $co_row[co_facility];
			$coAccess = $co_row[co_intranet];
			$coAdmin = $co_row[co_admin];
			$coUname = $co_row[co_userid];
			$coPassword = $co_row[co_pwd];
				
		}
		
		echo "<form name='frmCoworker' method='post' action='coworker.php'>";
		echo "<table width='50%' align='center'>";
		echo "<tr><td colspan='2' align='center'><font color='red' size='3'>$error_text</font></td></tr>";

		echo "<tr><td align='right' id='label' width='300'>First Name<font color='red' size='3'>*</font></td>";
		echo "<td id='label' width='400'><input name='coFname' maxlength='50' size='30' id='fancybox' value='$coFname'></td></tr>"; 

		echo "<tr><td align='right' id='label' width='300'>Last Name<font color='red' size='3'>*</font></td>";
		echo "<td id='label' width='400'><input name='coLname' maxlength='50' size='30' id='fancybox' value='$coLname'"; 
		echo "onBlur=\"javascript:frmCoworker.coUname.value= frmCoworker.coFname.value.substring(0,1).toLowerCase() + frmCoworker.coLname.value.toLowerCase();javascript:frmCoworker.coEmail.value = frmCoworker.coFname.value.substring(0,1).toLowerCase() + frmCoworker.coLname.value.toLowerCase() + '@mkpartners.com';\"></td></tr>"; 

		echo "<tr><td align='right' id='label' width='300'>Email<font color='red' size='3'>*</font></td>";
		echo "<td id='label' width='400'><input name='coEmail' maxlength='50' size='30' id='fancybox' value='$coEmail' onChange='javascript:this.value=this.value.toLowerCase();'></td></tr>"; 

		echo "<tr><td align='right' id='label' width='300'>Phone</td>";
		echo "<td id='label' width='400'><input name='coPhone' maxlength='50' size='30' id='fancybox' value='$coPhone'></td></tr>"; 

		echo "<tr><td align='right' id='label' width='300'>Position<font color='red' size='3'>*</font></td>";
		echo "<td id='label' width='400'><select name='coPosition' id='fancybox'><option value=''>Select...";
		while (list($idx,$val) = each($position))
		{

			echo "<option value='$idx'";
			if ($coPosition == $idx){ echo " SELECTED";}
			echo ">$val";
		}
		echo "</select></td></tr>";

		echo "<tr><td align='right' id='label' width='300'>Line of Business<font color='red' size='3'>*</font></td>";
		echo "<td id='label' width='400'><select name='coBusiness' id='fancybox'><option value=''>Select...";
		echo "<option value='BS'";
		if ($coBusiness == 'BS'){ echo " SELECTED";}
		echo ">Billing Solutions";
		echo "<option value='CO'";
		if ($coBusiness == 'CO'){ echo " SELECTED";}
		echo ">Corporate";
		echo "<option value='DM'";
		if ($coBusiness == 'DM'){ echo " SELECTED";}
		echo ">Direct Mail";
		echo "</select></td></tr>";

		echo "<tr><td align='right' id='label' width='300'>Facility<font color='red' size='3'>*</font></td>";
		echo "<td id='label' width='400'><select name='coFacility' id='fancybox'><option value=''>Select...";
		while (list($idx,$val) = each($facility))
		{
			echo "<option value='$idx'";
			if ($coFacility == $idx){ echo " SELECTED";}
			echo ">$val";
		}
		echo "</select></td></tr>";
		
		echo "<td align='right' id='label' width='300'>Intranet Access</td>";
		echo "<td id='label' width='400'><input type='checkbox' name='coAccess' id='fancybox'";
		if ($coAccess == '1'){ echo " CHECKED";}
		echo "></td></tr>";

		echo "<tr><td align='right' id='label' width='300'>User Name</td>";
		echo "<td id='label' width='400'>";
		echo "<input name='coUname' maxlength='50' size='30' id='fancybox' value='$coUname' onChange='javascript:this.value=this.value.toLowerCase();'></td></tr>"; 

		echo "<tr><td align='right' id='label' width='300'>Password</td>";
		echo "<td id='label' width='400'><input name='coPassword' maxlength='50' size='30' id='fancybox' value='$coPassword'></td></tr>"; 

		echo "<td align='right' id='label' width='300'>Administrator</td>";
		echo "<td id='label' width='400'><input type='checkbox' name='coAdmin' id='fancybox'";
		if ($coAdmin == '1'){ echo " CHECKED";}
		echo "></td></tr>";
		
		echo "<tr><td colspan='2' align='center' id='label'>";
		if ($_REQUEST[preEdit] != '')
		{
			echo "<input type='submit' name='editCoworker' value='Update Coworker' id='fancybox'>";
		}else{
			echo "<input type='submit' name='insCoworker' value='Add Coworker' id='fancybox'>";
		}
		echo "</td></tr>";
		echo "<tr><td colspan='2' align='center' id='label'>";
		echo "<input type='submit' name='insCancel' value='Cancel' id='fancybox'>";
		echo "<input type='hidden' name='coID' value='$coID'>";
		echo "</td></tr>";
		
		echo "</table></form>";		
		
		echo "<script>frmCoworker.coFname.focus();</script>";
	}else{

?>
	<form name="frmCoworker" method="post" action="coworker.php">
	<table width="80%" align="center" id="list">
	
	<tr>
		<td></td>
		<td><a href="#" onClick="frmCoworker.sortValue.value=0; frmCoworker.submit();">NAME</a></td>
		<td><a href="#" onClick="frmCoworker.sortValue.value=1; frmCoworker.submit();">LINE OF BUSINESS</a></td>
		<td><a href="#" onClick="frmCoworker.sortValue.value=2; frmCoworker.submit();">POSITION</a></td>
<?php
	$sort_fld = array('co_lname','co_business','co_position');
	
	if ($_POST[sortValue] == "")
	{
		$sort_by = 'co_lname';
	}else{
		$sort_by = $sort_fld[$_POST[sortValue]];
	}

				
	$sql = "SELECT * FROM tblCoworkers " .
		   "ORDER BY $sort_by";
		   
	$result = $db->Query($sql);

	while ($co_row = $db->FetchRow($result,3))
	{
    	echo "<tr>\n";
		echo "<td><a style='background-color: #ffffff' href='coworker.php?preEdit=$co_row[co_id]'><img name='edit' src='http://localhost/Images/editAction.gif' border='0' alt='Edit This Coworker'></a>";
    	echo "<td><input type='hidden' name='coID' value='$co_row[co_id]'>";
    	echo "$co_row[co_fname]&nbsp;$co_row[co_lname]</td>\n";
    	echo "<td>";
    	if ($co_row[co_business] == 'BS')
    	{
    		echo "Billing Solutions";
    	}elseif($co_row[co_business] == 'DM'){
    		echo "Direct Mail";
    	}else{
    		echo "Corporate";
    	}
    	echo "</td>\n";
    	$pos_idx = $co_row[co_position];
    	echo "<td>$position[$pos_idx]</td>\n";
    	echo "</tr>\n";
	}
		echo "<tr><td colspan='4' align='center'><a href='#' onClick=\"frmCoworker.preInsert.value='1';frmCoworker.submit();\">Add Coworker</a>";
		echo "<input type='hidden' name='preEdit'><input type='hidden' name='preInsert'><input type='hidden' name='sortValue'></td></tr>";

?>
	
	</table>
	</form>


<?php
	}
	write_footer('Y');
}
?>
