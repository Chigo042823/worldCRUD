<?php 
    require 'src/class/World.cls.php';
    require 'src/class/WorldView.cls.php';
    require 'src/class/WorldControl.cls.php';

	$worldView = new WorldView();
	$countries = $worldView->getAllCountries();
	$iter = 1;
	$worldCont = new WorldControl();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Countries</title>
		<link rel="stylesheet" href="src/css/style.css">
		<!-- Latest compiled and minified CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="src/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
  		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	</head>
	<body data-bs-theme="dark">
		<div id="panelContainer">
			<div id="insertPanel" class="p-4 rounded">
				<h1>Add a New Country</h1>
				<section id="formContainer">
					<section>
						<label for="countryCode">Country Code:</label>
						<input type="text" class="form-control" id="countryCode">

						<label for="countryName">Country Name:</label>
						<input type="text" class="form-control" id="countryName">

						<label for="countryContinent">Continent:</label>
						<select class="form-select" id="countryContinent">
							<option selected>Choose a continent</option>	
							<option value="Europe">Europe</option>
							<option value="Asia">Asia</option>
							<option value="Africa">Africa</option>
							<option value="North America">North America</option>
							<option value="South America">South America</option>
							<option value="Antarctica">Antarctica</option>
							<option value="Australia">Australia</option>
						</select>
					</section>
					<section id="row2">
						<label for="surfaceArea">Surface Area:</label>
						<input type="text" class="form-control" id="surfaceArea">

						<label for="population">Population:</label>
						<input type="text" class="form-control" id="population">

						<label for="governmentForm">Government Form:</label>
						<input type="text" class="form-control" id="governmentForm">
					</section>
				</section>
				<button class="btn btn-success" id="insertConfirm">Confirm</button>
				<button class="btn btn-secondary cancelButton">Cancel</button>
			</div>
		</div>
			<div id="header">
				<h2 class="text-center">Countries Around the World</h2>
				<div id="tableWidgets">
					<input class="form-control" id="searchBar" type="text" placeholder="Search Country Name...">
					<button class="btn btn-outline-success" id="insertButton">Add</button>
				</div>
			</div>
		<div class="rounded border border-light-subtle" id="tableWrap">
			<table class="table table-dark table-striped">
				<thead>
					<tr>
						<th>Number</th>
						<th>Code</th> 
						<th>Name</th> 
						<th>Continent</th> 
						<th>Surface Area</th>
						<th>Population</th>
						<th>Government Form</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody id="tableBody">
					<?php 
						foreach ($countries as $country) :
					?>
					<tr>
						<td><?php echo $iter ?></td>
						<td><?php echo $country["Code"] ?></td>
						<td><?php echo $country["Name"] ?></td>
						<td><?php echo $country["Continent"] ?></td>
						<td><?php echo $country["SurfaceArea"] ?></td>
						<td><?php echo $country["Population"] ?></td>
						<td><?php echo $country["GovernmentForm"] ?></td>
						<td><button class="btn btn-outline-secondary editButton" id="<?php echo $country['Code'] ?>">Edit</button></td>
						<td><button class="btn btn-outline-danger deleteButton <?php echo $country['Name'] ?>" id="<?php echo $country['Code'] ?>">Delete</button></td>
					</tr>
					<?php 
						$iter++;
						endforeach;
					?>
				</tbody>
			</table>
		</div>
	</body>
</html>
<script type="text/javascript">
	
	$(document).ready(function () {

		$("#searchBar").keyup(function() {
			var input = $("#searchBar").val();
			filterCountries(input);
		})
		
		// Show insert panel
		$("#insertButton").click(function () {
			$("#panelContainer").load("src/modules/insertPanel.txt", () => {	
				$("#insertPanel").show();
				$("#insertButton").hide();

				// Hide edit panel
				$(".cancelButton").click(function () {
					$("#panelContainer").empty();
					$("#insertButton").show();
				});

				// Confirm edit panel
				$("#insertConfirm").click(function () {
					var params = [
					$("#countryCode").val(),
					$("#countryName").val(),
					$("#countryContinent").val(),
					$("#surfaceArea").val(),
					$("#population").val(),
					$("#governmentForm").val()]
					insertCountry(params);
				});
			});
		});  

		// Show edit panel
		$(".editButton").click(function () {
			$("#panelContainer").load("src/modules/editPanel.txt");
			setTimeout(() => {
				fillOutEdit(this.id);	
				$("#editPanel").show();

				// Hide edit panel
				$(".cancelButton").click(function () {
					$("#panelContainer").empty();
				});

				// Confirm edit panel
				$("#editConfirm").click(function () {
					var params = [$("#countryName").val(),
					$("#countryContinent").val(),
					$("#surfaceArea").val(),
					$("#population").val(),
					$("#governmentForm").val(), 
					$("#countryCode").val(),]
					updateCountry(params);
				});
			}, 7);
		});  
		// Show delete panel
		$(".deleteButton").click(function () {
			var code = this.id;
			var classes = $(this).attr('class').split(' ');
			var name = classes[classes.length - 1];
			alert(code);
			$("#panelContainer").load("src/modules/deletePanel.txt");
			setTimeout(() => {
				$("#deletePanel h1").append(" " + name + "?");
				$("#deletePanel").show();

				// Hide delete panel
				$(".cancelButton").click(function () {
					$("#panelContainer").empty();
				});

				// Confirm delete panel
				$("#deleteConfirm").click(function () {
					deleteCountry(code);
					$("#panelContainer").empty();
				});
			}, 7);
		});             
    });

	function fillOutEdit(countryCode) {
		var postData = {"fillOut": countryCode};
		$.ajax({
		url: 'src/logic/ajax.php',
		type: 'POST',
		data: postData,
		dataType: 'json',
		success: function (data) {
        console.log(data);
		$("#editPanel h1").append(" " + data.Name);
		$("#countryCode").val(data.Code);
		$("#countryName").val(data.Name);
		$("#countryContinent").val(data.Continent);
		$("#surfaceArea").val(data.SurfaceArea);
		$("#population").val(data.Population);
		$("#governmentForm").val(data.GovernmentForm);
    },
    error: function (xhr, status, error) {
        console.error('AJAX Error: ' + status + ' - ' + error);
    }
});
	}

	function updateCountry(params) {
		var postData = {"updateParameters": params};
		$.ajax({
			url: 'src/logic/ajax.php',
			type: 'POST',
			data: postData,
			success: function (data) {
			location.reload();
		},
		error: function (xhr, status, error) {
			console.error('AJAX Error: ' + status + ' - ' + error);
		}
		});
	}

	function insertCountry(params) {
		var postData = {"insertParameters": params};
		$.ajax({
			url: 'src/logic/ajax.php',
			type: 'POST',
			data: postData,
			success: function (data) {
			location.reload();
		},
		error: function (xhr, status, error) {
			console.error('AJAX Error: ' + status + ' - ' + error);
		}
		});
	}

	function deleteCountry(params) {
		var postData = {"deleteParameters": params};
		$.ajax({
			url: 'src/logic/ajax.php',
			type: 'POST',
			data: postData,
			success: function (data) {
			alert(data);
			location.reload();
		},
		error: function (xhr, status, error) {
			console.error('AJAX Error: ' + status + ' - ' + error);
		}
		});
	}

	function filterCountries(params) {
		var postData = {"searchParameters": params};
		$.ajax({
			url: 'src/logic/ajax.php',
			type: 'POST',
			data: postData,
			dataType: 'json',
			success: function (data) {
				$("#tableBody").empty();

				if (data.length > 0) {
				$.each(data, function (index, country) {
					$("#tableBody").append(
					"<tr><td>" + (index + 1) + " </td>" +
						"<td>" + country.Code + " </td>" +
						"<td>" + country.Name + " </td>" +
						"<td>" + country.Continent + " </td>" +
						"<td>" + country.SurfaceArea + " </td>" +
						"<td>" + country.Population + " </td>" +
						"<td>" + country.GovernmentForm + " </td>" +
						"<td><button class='btn btn-outline-secondary editButton' id='" + country.Code + "'>Edit</button></td>" +
						"<td><button class='btn btn-outline-danger deleteButton" +  country.Name + "id='"  + country.Code + "'>Delete</button></td>" +
					"<tr>");
				});
				} else {
					$("#tableBody").html("No results");
				}
			},
			error: function (xhr, status, error) {
				console.error('AJAX Error: ' + status + ' - ' + error);
			}
		});
	}

</script>