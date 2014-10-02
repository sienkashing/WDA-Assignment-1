<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="en-us" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Wine Store</title>
<script type="text/javascript">
function preventSpecialCharacter(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
 if (charCode == 32 || 
 	((charCode > 47) && (charCode < 58)) ||
 	((charCode > 64) && (charCode < 91)) ||
 	((charCode > 96) && (charCode < 123)))
    return true;

 return false;
}

function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
 if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;

 return true;
}
function validate()
{
	x = document.searchForm;
	YearFrom = x.YearFrom.value;
	YearTo = x.YearTo.value;
	CostFrom = x.CostFrom.value;
	CostTo = x.CostTo.value;
	
	if ((YearTo > 0) & (YearFrom > YearTo))
	{
		alert("Year From can not be bigger than Year To.");
		return false;
	}	
	else
	{
		if ((CostTo > 0) & (CostFrom > CostTo))
		{
			alert("Cost From can not be bigger than Cost To.");
			return false;
		}		
		else
		{
			return true;
		}
	}
}
</script>
</head>

<body>
<img src="Pictures/Logo.jpg" alt="" height="120" width="149" />
<form name="searchForm" action="Results.php" method="get" onsubmit="return validate()">
<table style="width: 500px">
	<tr>
		<td>Wine Name:</td>
		<td><input name="WineName" size ="30" type="text" onkeypress="return preventSpecialCharacter(event)"/></td>
	</tr>
	<tr>
		<td>Winery Name:</td>
		<td><input name="WineryName" size="30" type="text" onkeypress="return preventSpecialCharacter(event)"/></td>
	</tr>	
	<tr>
		<td>Region:</td>
		<td><select name="Region">
				<?php
					$con = mysqli_connect("localhost","root","","winestore");
					$result = mysqli_query($con,"SELECT * FROM Region");
					while($row = mysqli_fetch_array($result))
					{
						echo "<option>".$row['region_name']."</option>";		
					}
				?>				
			</select>
		</td>
	</tr>
	<tr>
		<td>Min. Stock of Wine</td>
		<td><input name="MinStock" type="text" size="19" onkeypress="return isNumberKey(event)"/></td>
	</tr>
	<tr>
		<td>Min. No of Customers who bought a Wine:</td>
		<td><input name="MinCustomers" type="text" size="19" onkeypress="return isNumberKey(event)"/></td>
	</tr>
	<tr>
		<td>Wine Year:</td>
		<td>From: <input name="YearFrom" type="text" maxlength="4" size="4" onkeypress="return isNumberKey(event)"/>To:<input name="YearTo" type="text" maxlength="4" size="4"/></td>
	</tr>	
	<tr>
		<td>Cost (Dolar):</td>
		<td>From: <input name="CostFrom" type="text" maxlength="4" size="4" onkeypress="return isNumberKey(event)"/>To:<input name="CostTo" type="text" maxlength="4" size="4"/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input name="Search" type="submit" value="Search" /></td>
	</tr>
</table>
</form>
</body>

</html>
