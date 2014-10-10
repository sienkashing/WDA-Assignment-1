<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Results</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container">
<a href="Home.php">
<img src="Pictures/Logo.jpg" alt="" height="120" width="400" /></a>
<!-- BEGIN GOTRESULTS -->
<table class="table table-striped">    
<thead>
<tr>
	<th>Wine Name</th>
	<th>Year</th>			
	<th>Wine Variety</th>
	<th>Winery Name</th>
	<th>Wine Region</th>
	<th>Cost</th>
	<th>On Hand</th>
	<th>Total Orders</th>
</tr>
</thead>
<tbody>
<!-- END GOTRESULTS -->
<!-- BEGIN RESULTS -->
<tr>
	<td>{WineName}</td>
	<td>{Year}</td>
	<td>{Variety}</td>
	<td>{Winery}</td>
	<td>{Region}</td>
	<td>{Cost}</td>
	<td>{OnHand}</td>
	<td>{TotalOrders}</td>	
</tr>
<!-- END RESULTS -->
<!-- BEGIN GOTRESULTS -->
</tbody>
</table>
<!-- END GOTRESULTS -->
<!-- BEGIN NORESULTS -->
{header}
<!-- END NORESULTS -->
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>

</html>
