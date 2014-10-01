<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Results</title>
</head>

<body>
<table border="1">
	<?php
		$con = mysqli_connect("localhost","root","","winestore");
		$query = "SELECT ". 
				"wine.wine_name AS WineName, ".
				"wine.`year` AS Year, ".
				"grape_variety.variety AS Variety, ".				
				"winery.winery_name AS Winery, ".
				"region.region_name AS Region ".
				"FROM ".
				"wine ".
				"INNER JOIN wine_variety ON wine.wine_id = wine_variety.wine_id ".
				"INNER JOIN grape_variety ON wine_variety.variety_id = grape_variety.variety_id ".
				"INNER JOIN winery ON wine.winery_id = winery.winery_id ".
				"INNER JOIN region ON winery.region_id = region.region_id ".
				"GROUP BY ".
				"wine.wine_name, ".
				"grape_variety.variety, ".
				"wine.`year`, ".
				"winery.winery_name, ".
				"winery.region_id ".
				"ORDER BY WineName,Year,Variety,Winery, Region ";
	    #echo $query;
	    echo "</br>";
		$result = mysqli_query($con,$query);
		if (mysqli_num_rows($result) == 0)
		{
			echo 'No records match your search criteria.';
		}
		else
		{
			echo "<tr>".
				"<th>Wine Name</th>".
				"<th>Year</th>".				
				"<th>Wine Variety</th>".				
				"<th>Winery Name</th>".
				"<th>Wine Region</th>".
				"<th>Min. Cost of Wine</th>".
				"<th>Bottles at Min. Cost</th>".
				"<th>Total Bottles</th>".
				"<th>No. Customers</th>".
			"</tr>";
			$tmpWineName = ""; #use for comparison to determine whether or not to run subqueries
			while($row = mysqli_fetch_array($result))
			{								
				echo "<tr>".
					"<td>".$row['WineName']."</td>".
					"<td>".$row['Year']."</td>".
					"<td>".$row['Variety']."</td>".
					"<td>".$row['Winery']."</td>".
					"<td>".$row['Region']."</td>";
					
				#compare previous wine id with current row wine id, if different run sub queries for new wine id
				if ($tmpWineName == "" || $tmpWineName <> $row['WineName'])
				{
					$tmpWineName = $row['WineName'];
					
					#Begin sub queries
					#1 - Get Minimum cost of wine
					$query = "SELECT Min(inventory.cost) AS MinCost ".
							 "FROM inventory ".
							 "INNER JOIN wine ON wine.winery_id = inventory.wine_id ".
							 "WHERE wine.wine_name='".$tmpWineName."'";
					$tmpresult = mysqli_query($con, $query);
					while($tmprow =  mysqli_fetch_array($tmpresult))
					{
						$MinCost = $tmprow['MinCost'];
					}
						
					#2 - Get bottles sold at Minimum cost
					$query = "SELECT SUM(inventory.on_hand) AS MinCostBottles ".
							 "FROM inventory ".
							 "INNER JOIN wine ON wine.winery_id = inventory.wine_id ".
						     "WHERE wine.wine_name= '".$tmpWineName."'".
							 " AND inventory.cost = '".$MinCost."'";
					$tmpresult = mysqli_query($con, $query);
					while($tmprow =  mysqli_fetch_array($tmpresult))
					{
						$MinCostBottles = $tmprow['MinCostBottles'];
					}
					
					#3 - Get Total bottles
					$query = "SELECT SUM(inventory.on_hand) AS TotalBottles ".
							 "FROM inventory ".
							 "INNER JOIN wine ON wine.winery_id = inventory.wine_id ".
							 "WHERE wine.wine_name='".$tmpWineName."'";
					$tmpresult = mysqli_query($con, $query);
					while($tmprow =  mysqli_fetch_array($tmpresult))
					{
						$TotalBottles = $tmprow['TotalBottles'];
					}		
					
					#4 - Total Customers
					$query = "SELECT Count(items.cust_id) AS TotalCustomers ".
							 "FROM items ".
							 "INNER JOIN wine ON wine.wine_id = items.wine_id ".
							 "WHERE wine.wine_name='".$tmpWineName."'";
					$tmpresult = mysqli_query($con, $query);
					while($tmprow =  mysqli_fetch_array($tmpresult))
					{
						$TotalCustomers = $tmprow['TotalCustomers'];
					}
																						
				}
				echo "<td>".$MinCost."</td>";									
				echo "<td>".$MinCostBottles."</td>";
				echo "<td>".$TotalBottles."</td>";
				echo "<td>".$TotalCustomers."</td>";
				echo "</tr>";
			}			
		}
		mysqli_close($con);
	?>
</table>
</body>

</html>
