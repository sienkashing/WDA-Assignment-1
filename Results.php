<?php

set_include_path('C:\wamp\bin\php\php5.5.12\pear');
require_once "HTML/Template/IT.php";
require_once "DB.php";

$template = new HTML_Template_IT("./templates");
$template->loadTemplatefile("Results.tpl",true,true);

$con = mysqli_connect("localhost","root","","winestore");

$Where = "";
if (!empty($_GET['WineName']))
{
	$WineName = mysqli_real_escape_string($con, $_GET['WineName']);		
	$Where = "wine.wine_name Like '%".$WineName."%' ";
}
if (!empty($_GET['WineryName']))
{
	$WineryName = mysqli_real_escape_string($con,$_GET['WineryName']);
	if ($Where <> "")
	{	
		$Where = $Where." AND winery.winery_name LIKE '%".$WineryName."%' ";
	}
	else
	{
		$Where = "winery.winery_name LIKE '%".$WineryName."%' ";
	}						
}
if (!empty($_GET['Region']) and ($_GET['Region'] <> 'All'))
{
	$Region = mysqli_real_escape_string($con,$_GET['Region']);
	if ($Where <> "")
	{
		$Where = $Where." AND region.region_name = '".$Region."' ";
	}
	else
	{
		$Where = "region.region_name = '".$Region."' ";
	}			
}
if (!empty($_GET['MinStock']))
{
	$MinStock = mysqli_real_escape_string($con,$_GET['MinStock']);
	if ($Where <> "")
	{
		$Where = $Where." AND inventory.on_hand >= '".$MinStock."' ";
	}
	else
	{
		$Where = "inventory.on_hand >= '".$MinStock."' ";
	}
}	
if (!empty($_GET['MinStock']))
{
	$MinStock = mysqli_real_escape_string($con,$_GET['MinStock']);
	if ($Where <> "")
	{
		$Where = $Where." AND inventory.on_hand >= '".$MinStock."' ";
	}
	else
	{
		$Where = "inventory.on_hand >= '".$MinStock."' ";
	}
}
if (!empty($_GET['YearFrom']) and (!empty($_GET['YearTo'])))
{
	$YearFrom = mysqli_real_escape_string($con,$_GET['YearFrom']);
	$YearTo = mysqli_real_escape_string($con,$_GET['YearTo']);
	if ($Where <> "")
	{
		$Where = $Where." AND wine.`year` BETWEEN '".$YearFrom."' AND '".$YearTo."' ";
	}
	else
	{
		$Where = "wine.`year` BETWEEN '".$YearFrom."' AND '".$YearTo."' ";
	}
}	
else 
{
	if (!empty($_GET['YearFrom']))
	{
		$YearFrom = mysqli_real_escape_string($con,$_GET['YearFrom']);
		if ($Where <> "")
		{
			$Where = $Where." AND wine.`year` >='".$YearFrom."' ";
		}
		else
		{
			$Where = "wine.`year` >='".$YearFrom."' ";
		}				
	}
	if (!empty($_GET['YearTo']))
	{
		$YearTo = mysqli_real_escape_string($con,$_GET['YearTo']);
		if ($Where <> "")
		{
			$Where = $Where." AND wine.`year` <='".$YearTo."' ";
		}
		else
		{
			$Where = "wine.`year` <='".$YearTo."' ";
		}				
	}					
}	
if (!empty($_GET['CostFrom']) and (!empty($_GET['CostTo'])))
{
	$CostFrom = mysqli_real_escape_string($con,$_GET['CostFrom']);
	$CostTo = mysqli_real_escape_string($con,$_GET['CostTo']);
	if ($Where <> "")
	{
		$Where = $Where." AND inventory.cost BETWEEN '".$CostFrom."' AND '".$CostTo."' ";
	}
	else
	{
		$Where = "inventory.cost BETWEEN '".$CostFrom."' AND '".$CostTo."' ";
	}
}	
else 
{
	if (!empty($_GET['CostFrom']))
	{
		$CostFrom = mysqli_real_escape_string($con,$_GET['CostFrom']);
		if ($Where <> "")
		{
			$Where = $Where." AND inventory.cost >='".$CostFrom."' ";
		}
		else
		{
			$Where = "inventory.cost >='".$CostFrom."' ";
		}				
	}
	if (!empty($_GET['CostTo']))
	{
		$CostTo = mysqli_real_escape_string($con,$_GET['CostTo']);
		if ($Where <> "")
		{
			$Where = $Where." AND inventory.cost <='".$CostTo."' ";
		}
		else
		{
			$Where = "inventory.cost <='".$CostTo."' ";
		}				
	}					
}									
if ($Where <> "")
{
	$Where = "WHERE ".$Where." ";
}
		
$query = "SELECT ".
	    "wine.wine_id AS WineID, ".
		"wine.wine_name AS WineName, ".
		"wine.`year` AS Year, ".
		"grape_variety.variety AS Variety, ".				
		"winery.winery_name AS Winery, ".
		"region.region_name AS Region, ".
		"inventory.cost AS Cost, ".
		"inventory.on_hand AS OnHand, ".
		"Count(items.cust_id) AS TotalOrders ".
		"FROM ".
		"wine ".
		"INNER JOIN wine_variety ON wine.wine_id = wine_variety.wine_id ".
		"INNER JOIN winery ON wine.winery_id = winery.winery_id ".
		"INNER JOIN grape_variety ON wine_variety.variety_id = grape_variety.variety_id ".
		"INNER JOIN region ON winery.region_id = region.region_id ".
		"INNER JOIN inventory ON wine.wine_id = inventory.wine_id ".
		"INNER JOIN items ON wine.wine_id = items.wine_id ".				
		$Where.
		"GROUP BY ".
		"wine.wine_name, ".
		"grape_variety.variety, ".
		"wine.`year`, ".
		"winery.winery_name, ".
		"region.region_name, ".
		"inventory.cost, ".
		"inventory.on_hand ";
		if (!empty($_GET['MinCustomers']))
		{
			$query .= "HAVING COUNT(items.cust_id) >= '".$_GET['MinCustomers']. "' ";
		}				
		$query .= "ORDER BY WineName,Year,Variety,Winery, Region ";
#echo $query;
echo "</br>";
$result = mysqli_query($con,$query);
if (mysqli_num_rows($result) == 0)
{
	echo 'No records match your search criteria.';
}
else
{			
	while($row = mysqli_fetch_array($result))
	{										
		$template->setCurrentBlock("RESULTS");
		$template->setVariable("WineName", $row['WineName']);
		$template->setVariable("Year", $row['Year']);
		$template->setVariable("Variety", $row['Variety']);
		$template->setVariable("Winery", $row['Winery']);
		$template->setVariable("Region", $row['Region']);
		$template->setVariable("Cost", $row['Cost']);
		$template->setVariable("OnHand", $row['OnHand']);
		$template->setVariable("TotalOrders", $row['TotalOrders']);
		$template->parseCurrentBlock("RESULTS");
	}			
}
$template->show();

mysqli_close($con);
?>
