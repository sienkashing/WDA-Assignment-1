<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Results</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">    
    <a href="Home.php"><img src="Pictures/Logo.jpg" alt="" height="120" width="400" /></a>
    
    <?php		
            $con = mysqli_connect("localhost","root","","winestore");

            global $Where;
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
                            "Count(items.cust_id) AS TotalCustomers ".
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
                    echo '<h1>No records match your search criteria.</h1>';
            }
            else
            {
                    echo '<table class="table table-striped">'.
                            '<thead>'.
                            '<tr>'.
                            "<th>Wine Name</th>".
                            "<th>Year</th>".				
                            "<th>Wine Variety</th>".				
                            "<th>Winery Name</th>".
                            "<th>Wine Region</th>".
                            "<th>Cost</th>".
                            "<th>On Hand</th>".
                            "<th>Total Orders</th>".
                    "</tr></thead>";
                    echo"<tbody>";
                    while($row = mysqli_fetch_array($result))
                    {								
                            echo "<tr>".
                                    "<td>".$row['WineName']."</td>".
                                    "<td>".$row['Year']."</td>".
                                    "<td>".$row['Variety']."</td>".
                                    "<td>".$row['Winery']."</td>".
                                    "<td>".$row['Region']."</td>".
                                    "<td>".$row['Cost']."</td>".
                                "<td>".$row['OnHand']."</td>".
                                "<td>".$row['TotalCustomers']."</td>".
                                "</tr>";
                    }		
                    echo "</tbody></table>";
            }
            mysqli_close($con);
    ?>            
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>

</html>
