<?php 
	function sendtoindex()
	{
		print "
			<body onLoad='document.forms[0].submit()'>
			<form ACTION='index.php' METHOD=POST>
			</form>
			</body>
		";
		return;
	}

	function sendtostart($req_url)
	{
		if ($req_url != '')
		{
			$action_url = $req_url;
		}else{
			$action_url = 'start.php';
		}
		
		print "
			<body onLoad='document.forms[0].submit()'>
			<form ACTION='$action_url' METHOD=POST>
			</form>
			</body>
		";
		return;
	}	
	
	function sendtologout()
	{
		echo "<script>window.location='http://localhost'</script>";
		return;
	}
	
	function sendtoclient()
	{
	
		header("Location: ./Clients/client.php"); 
	
		return;
	}
		function sendtocclist()
	{
		print "
			<body onLoad='document.forms[0].submit()'>
			<form ACTION='http://localhost/Utilities/cclist.php' METHOD=POST>
			</form>
			</body>
		";
		return;
	}
?>
