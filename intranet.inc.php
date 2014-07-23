<?php

///////////////////////////////////////////////////////////////////////////////////
//
// Call the required include files
//
///////////////////////////////////////////////////////////////////////////////////

    require("session.inc");
    require("traffic.inc");
    require("globals.inc");
    require("databases.inc");

///////////////////////////////////////////////////////////////////////////////////
//
// Database connection area
//
///////////////////////////////////////////////////////////////////////////////////

	// define the default database variables
	$defaultRDBMS		= "MYSQL";
	$defaultHost		= "localhost";
	$defaultUsername	= "root";
	$defaultPassword	= "heimer27";
	$defaultDB		= "devTrak";

   	$db = &new cDatabases();
    $db->Set($defaultRDBMS);
   	$db->Connect($defaultHost,$defaultUsername,$defaultPassword,$defaultDB); 


	// retrieve the user id so we can tell if they have admin access to the system
				
	$user_id = $_SESSION['users_id']; 

///////////////////////////////////////////////////////////////////////////////////
//
// Global Variables
//
///////////////////////////////////////////////////////////////////////////////////

	// Values for alternating row colors
	$rowcolor1 = '#F0F0F2';  
	$rowcolor2 = '#FFFFFF';  
	$hovercolor1 = '#BAD4EB';  
	$hovercolor2 = '#DCE9F4';  

///////////////////////////////////////////////////////////////////////////////////
//
// Subroutines for use throughout the site
//
///////////////////////////////////////////////////////////////////////////////////

function next_ID($table)
{
	$sql = "SELECT * FROM $table";
	$result = $db->Query($sql);
	$cnt = $db->NumRows($result);
	if ($cnt == 0)
	{
		return 1;
	} else {
		$col = $db->ColumnName($result, 0);
		$sql = "SELECT MAX(" . $col . ") as last_id FROM " . $table;
		$result = $db->Query($sql);
		$row = $db->FetchRow($result);
		$new_id = $row[last_id] + 1;
		return $new_id;
	}
}

			
function unhtmlspecialchars( $string )
   {
       $string = str_replace ( '&amp;', '&', $string );
       $string = str_replace ( '&#039;', '\'', $string );
       $string = str_replace ( '&quot;', '\"', $string );
       $string = str_replace ( '&lt;', '<', $string );
       $string = str_replace ( '&gt;', '>', $string );
       $string = str_replace ( '\\', '', $string );
       
       return $string;
   }



	// Generate top of each page
	// The $title variable determines which tab to highlight in the navigation bar
	function write_header($title,$focus = 'Y', $adminValue = '')
	{

		echo "
			<html>
			<head>
				<title>Brent's Test Intranet</title>
				<LINK href='http://localhost/Include/intranet_new.css' rel='stylesheet' type='text/css'>
				<script language='JavaScript1.2' src='http://localhost/Include/fw_menu.js'></script>
				<script language='JavaScript1.2' src='http://localhost/Include/intranet.js'></script>
				<script language='JavaScript1.2' src='http://localhost/Include/datepicker.js'></script>
			</head>

			<body bgcolor='#FFFFFF' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' class='$title'
		     ";
		     
		if ($focus == 'Y')
		{
		    echo " onLoad='document.forms[0].elements[0].focus()'";
		}
		     
		echo " >

			<table width='100%' border='0' cellspacing='0' cellpadding='0'>

			<!--top slice content -->

				<tr> 
					<td colspan='5' bgcolor='DAA42B'><img src='http://localhost/Images/top_slice.jpg' width='100%' height='9'></td>
				</tr>
				<tr> 
					<td colspan='5' bgcolor='#FFFFFF'><img src='http://localhost/Images/shim.gif' width='4' height='4'></td>
				</tr>
  
			<!--banner content -->   
				<tr> 
					<td width='10%'>&nbsp;</td>
					<td align='center'><span id='banner'><h1>Brent's Test Intranet</h1></span></td>
					<td width='10%'>&nbsp;</td>
				</tr>
				<tr> 
					<td colspan='5' bgcolor='#FFFFFF'><img src='http://localhost/Images/shim.gif' width='4' height='4'></td>
				</tr>

			<!--purple bar content -->

		";

		if ($title == '')
		{
			echo "	
				<tr> 
					<td colspan='5' bgcolor='#333366'><img src='http://localhost/Images/shim.gif' width='4' height='4'></td>
				</tr>
				</table>
			";
		
		}else{
			echo "
				</table>
	
<!--	 			<div id='purple'>
				<h8>&nbsp;</h8>
					<div id='nav'>
		    		<ul>
				    	<li id='nav-home'><a title='Start Page' href='http://localhost/start.php'>Home</a></li>
				    	<li id='nav-client'><a title='Client List' href='http://localhost/Clients/client.php'>Clients</a></li>
				    	<li id='nav-action'><a title='Dev Trak' href='http://localhost/DevTrak/allIssuesReport.php'>Dev Trak</a></li>
				    	<li id='nav-utilities'><a title='Misc Utilities' href='http://localhost/Utilities/utilities.php'>Utilities</a></li>
					"; 

						if ($adminValue == 1)
						{
							echo "
				    			<li id='nav-projecttrak'><a title='Project Trak' href='http://localhost/ProjectTrak/mainMenu.php'>Project Trak</a></li>
							"; 
				    		}
				    	echo "
				    	
				    	<li id='nav-logout'><a title='Logout' href='http://localhost/logout.php'>Logout</a></li>
		    		</ul>
			    	<span id='navclear'></span>
					</div>
				</div>
--> 		

			";
		}
	}

	// End of write_header function

	function write_footer($in_table)
	{
		if ($in_table == 'Y')
		{
			echo "<table width='100%'><tr><td>&nbsp;</td></tr><td><div id='tbl_footer'>  <!-- Footer notes here --> </div></td></tr></table>";
		}else{
		
			echo "
				<!--footer content -->

					<div id='footer'>
						&copy;.
					</div>
					</body>
					</html>
			";
		}

	}
	
	
	// For ProjectTrak, we will generate instructions at the top of each page
	function write_project_instr($pg)
	{
		echo "
			<table width='700> align='center'>
				<tr>
					<td align='center'><b>Project Trak: 
			";
			
		switch($pg)
		{
			case 'new':
				echo "Add New Project</b><br>
					  <i>This is the starting page for any new project. All of the items on this page must be completed at one time. Once the project info is entered,
					  you may save the info and return to the project later, or save the info and continue to the next step: Print Specifications</i>
					 ";
			case 'pdr1':
				echo "Print Specifications</b><br>
					  <i>This page is used to define the specifications for the project Letter, RD, Labels or Envelope. At any time you can save the data you have entered.
					  Once all the data is complete, click the Complete button or the Complete & Continue button if you wish to start entering Project Files.</i>
					 ";
		}
		
		echo "		</td>
				</tr>
			</table>
			";
	}
		  		

		
