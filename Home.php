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
 if (charCode == 32 || charCode == 8 || charCode == 13 ||
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
<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="col-xs-offset-3" id="body">
        <img src="Pictures/Logo.jpg" alt="" height="120" width="400" />
        <form name="searchForm" action="Results.php" method="get" onsubmit="return validate()" role="form" class="form-horizontal">
                <div class="form-group">
                        <label for="WineName" class="col-xs-2 control-label">Wine Name:</label>
                        <div class="col-xs-5">                        
                             <input class="form-control" id="WineName" name="WineName" type="text" placeholder="Wine Name"
                                    onkeypress="return preventSpecialCharacter(event)"/>
                        </div>
                </div>
                <div class="form-group">
                        <label for="WineryName" class="col-xs-2 control-label">Winery Name:</label>
                        <div class="col-xs-5">
                            <input id="WineryName" name="WineryName" type="text" class="form-control" placeholder="Winery Name"
                                   onkeypress="return preventSpecialCharacter(event)"/>
                        </div>
                </div>	
                <div class="form-group">
                        <label for="Region" class="col-xs-2 control-label">Region:</label>
                        <div class="col-xs-3">
                            <select id="Region" name="Region" class="form-control">
                                <?php
                                        $con = mysqli_connect("localhost","root","","winestore");
                                        $result = mysqli_query($con,"SELECT * FROM Region");
                                        while($row = mysqli_fetch_array($result))
                                        {
                                                echo "<option>".$row['region_name']."</option>";		
                                        }
                                ?>				
                            </select>
                        </div>
                </div>
                <div class="form-group">
                        <label for="MinStock" class="col-xs-2 control-label">Min. Stock of Wine</label>
                        <div class="col-xs-2">
                            <input name="MinStock" type="text" onkeypress="return isNumberKey(event)" 
                                   class="form-control" placeholder="Min Stock"/>
                        </div>
                </div>
                <div class="form-group">
                        <label for="MinCustomers" class="col-xs-2 control-label">Min. Customer Orders:</label>
                        <div class="col-xs-2">
                            <input id="MinCustomers" name="MinCustomers" type="text" onkeypress="return isNumberKey(event)"
                                   class="form-control" placeholder="Min. Cust. Orders"/>
                        </div>
                </div>
                <div class="form-group">
                    <label for="YearFrom" class="col-xs-2 control-label">Wine Year:</label>
                    <div class="row">
                        <div class="col-xs-2">
                            <input id="YearFrom" name="YearFrom" type="text" maxlength="4" onkeypress="return isNumberKey(event)"
                                   class="form-control" placeholder="From"/>                        
                        </div>
                        <div class="col-xs-2">
                            <input name="YearTo" type="text" maxlength="4" onkeypress="return isNumberKey(event)"
                                   class="form-control" placeholder="To"/>                        
                        </div>
                    </div>
                </div>	
                <div class="form-group">
                        <label for="CostFrom" class="col-xs-2 control-label">Cost (Dolar):</label>
                        <div class="row">
                            <div class="col-xs-2">
                                <input name="CostFrom" type="text" maxlength="4" onkeypress="return isNumberKey(event)"
                                       class="form-control" placeholder="From"/>    
                            </div>                        
                            <div class="col-xs-2">
                                <input name="CostTo" type="text" maxlength="4" onkeypress="return isNumberKey(event)"
                                       class="form-control" placeholder="To"/>    
                            </div>                                            
                        </div>                        
                </div>
                <div class="form-group">                    
                    <div class="col-xs-2 col-xs-offset-2">
                        <button type="submit" class="btn btn-default">Start Search</button>
                    </div>                                    
                </div>
        </form>        
    </div>
</div> >

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>

</html>
