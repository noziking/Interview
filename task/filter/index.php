<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>User Filter</title>

    <script src="//code.jquery.com/jquery-1.12.3.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
function filter(){
  var hair_color = document.getElementsByName("hair_color");
  var eye_color = document.getElementsByName("eye_color");
  var weight = document.getElementsByName("weight");
  var height = document.getElementsByName("height");
  var age = document.getElementsByName("age");
  var filter = hair_color;
  var table = document.getElementById("example");
  var tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    td_eye = tr[i].getElementsByTagName("td")[2];
    td_weight = tr[i].getElementsByTagName("td")[4];
    td_height = tr[i].getElementsByTagName("td")[5];
    td_age = tr[i].getElementsByTagName("td")[6];
    if (td) {
      if ( ( ( td.innerHTML.toUpperCase().indexOf(filter[2].value.toUpperCase()) > -1 && filter[2].checked == true) || ( td.innerHTML.toUpperCase().indexOf(filter[1].value.toUpperCase()) > -1  && filter[1].checked == true) || ( td.innerHTML.toUpperCase().indexOf(filter[0].value.toUpperCase()) > -1  && filter[0].checked == true) ) && ( ( td_eye.innerHTML.toUpperCase().indexOf(eye_color[0].value.toUpperCase()) > -1  && eye_color[0].checked == true) || ( td_eye.innerHTML.toUpperCase().indexOf(eye_color[1].value.toUpperCase()) > -1  && eye_color[1].checked == true) || ( td_eye.innerHTML.toUpperCase().indexOf(eye_color[2].value.toUpperCase()) > -1  && eye_color[2].checked == true) ) && ( ( td_weight.innerHTML <= '150' && weight[0].checked == true) || ( td_weight.innerHTML >= '150' && td_weight.innerHTML <= '300' && weight[1].checked == true) ) && ( ( td_height.innerHTML <= '5' && height[0].checked == true) || ( td_height.innerHTML > '5' && height[1].checked == true) ) && ( ( td_age.innerHTML <= '20' && age[0].checked == true) || ( td_age.innerHTML > '20' && age[1].checked == true) ) ) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
</head>

<body>
<div class="container" style="padding-top:3%;">
  <div class="col-md-2">
  <h4 style="font-weight:bold;">Advanced Filters</h4><br />
  <h5>Hair Colour</h5>
  <input type="checkbox" name="hair_color" value="black" onchange="filter();" checked="checked"/> Black<br />
  <input type="checkbox" name="hair_color" value="blue"  onchange="filter();" checked="checked"/> Blue<br />
  <input type="checkbox" name="hair_color" value="brown"  onchange="filter();" checked="checked"/> Brown<br />  
  <h5>Eye Colour</h5>
  <input type="checkbox" name="eye_color" value="black" onchange="filter();" checked="checked" /> Black<br />
  <input type="checkbox" name="eye_color" value="blue" onchange="filter();" checked="checked" /> Blue<br />
  <input type="checkbox" name="eye_color" value="brown" onchange="filter();" checked="checked" /> Brown<br />  
  <h5>Weight</h5>
  <input type="checkbox" name="weight" value="upto_150" onchange="filter();" checked="checked" /> Min:0 To Max:150<br />
  <input type="checkbox" name="weight" value="150_300" onchange="filter();" checked="checked" /> Min:150 To Max:300<br />
  <h5>Height</h5>
  <input type="checkbox" name="height" value="upto_5" onchange="filter();" checked="checked" /> Min:0 To Max:5<br />
  <input type="checkbox" name="height" value="5_10" onchange="filter();" checked="checked" /> Min:5 To Max:10<br />
  <h5>Age</h5>
  <input type="checkbox" name="age" value="upto_20" onchange="filter();" checked="checked" /> Min:0 To Max:20<br />
  <input type="checkbox" name="age" value="20_100" onchange="filter();" checked="checked" /> Min:20 To Max:100<br />
  </div>
  <div class="col-md-10">
  <h4 style="font-weight:bold; text-align:center;">User Table</h4><br />

  <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Hair Color</th>
                <th>Eye Color</th>
                <th>Place</th>
                <th>Weight</th>
                <th>Height</th>
                <th>Age</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Hair Color</th>
                <th>Eye Color</th>
                <th>Place</th>
                <th>Weight</th>
                <th>Height</th>
                <th>Age</th>
            </tr>
        </tfoot>
        <tbody>
		<?php  include('db.php');
		$sql = "select * from users";
		$new = $conn->query($sql);
		while($row = $new->fetch_assoc()){
		?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['hair_color']; ?></td>
                <td><?php echo $row['eye_color']; ?></td>
                <td><?php echo $row['place']; ?></td>
                <td><?php echo $row['weight']; ?></td>
                <td><?php echo $row['height']; ?></td>
                <td><?php echo $row['age']; ?></td>
            </tr>
		<?php }
		?>
        
        </tbody>
    </table>
	</div>	
</div>
</body>
</html>
