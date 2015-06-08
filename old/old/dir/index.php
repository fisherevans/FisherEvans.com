<?php
	$hostname = "home.fisherevans.com";
	$ip = gethostbyname($hostname);
	$colors =
	array(
		"#F5F5F5",
		"#DBDBDB",
	);
	$ports = 
	array(
		array( "9092", "Deluge", "home.fisherevans.com:9092", true),
		array( "32400", "Plex", "home.fisherevans.com:32400/web", true),
		array( "63930", "SSH", "home.fisherevans.com:63930", false),
		array( "63931", "X-RDP", "home.fisherevans.com:63931", false),
		array( "63933", "Local HTTP", "home.fisherevans.com:63933", true)
	);
?>
<html>
	<head>
		<title>Directory</title>
	</head>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<style>
	*
	{
		font-family: 'Open Sans', sans-serif;
	}
	table
	{
		border-top: 1px solid #AAAAAA;
		border-left: 1px solid #AAAAAA;
		margin: 20px auto;
	}
	td
	{
		text-align:left;
		padding:10px 35px;
		border-bottom: 1px solid #AAAAAA;
		border-right: 1px solid #AAAAAA;
	}
	a
	{
		color: #0095FF;
		text-decoration: none;
	}
	a:hover
	{
		color: #367EB3;
		text-decoration: underline;
	}
	p
	{
		font-size: 85%;
	}
	</style>
	<body>
		<center>
			<p>
				Current IP of <?php echo $hostname; ?>: <b><?php echo $ip; ?></b>
			</p>
		</center>
		<table border="0" cellspacing="0">
			<tr>
				<td><b>Port</b></td>
				<td><b>Application</b></td>
				<td><b>Address</b></td>
			</tr>
			<?php
				$i = 0;
				foreach($ports as $port)
				{
					$color = $colors[$i++ % 2];
					echo "<tr style=\"background-color: " . $color . ";\">";
					
					echo "<td>" . $port[0] . "</td>";
					echo "<td>" . $port[1] . "</td>";
					
					if($port[3])
						echo '	<td><a href="http://' . $port[2] . '">' . $port[2] . '</td>';
					else
						echo "<td>" . $port[2] . "</td>";
					
					echo "</tr>\n";
				}
			?>
		</table>
		<center>
			<p>
				Port mapping for Fisher's home network.<br>
				<a href="http://www.fisherevans.com/blog">www.fisherevans.com/blog</a>
			</p>
		</center>
	</body>
</html>