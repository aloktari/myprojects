<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Users</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0;
		padding: 14px 15px 10px 15px;
	}

	#body {
		margin: 15px;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	
	table {
		width: 100%;
	}
	tr:hover {
		background-color: #eee;
	}
	th {
		text-align: left;
		width: 20%;
		background-color: #DDD;
	}
	th, td {
		padding: 10px;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Users</h1>
	<div id="body">
		<table>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Created</th>
			</tr>
	
		<?php foreach ($users as $user): ?>
			<tr>
				<td><?php echo $user['id']; ?></td>
				<td><?php echo $user['name']; ?></td>
				<td><?php echo $user['email']; ?></td>
				<td><?php echo $user['phone']; ?></td>
				<td><?php echo $user['created']; ?></td>
			</tr>
		<?php endforeach; ?>
		
		</table>
	</div>
</div>

</body>
</html>