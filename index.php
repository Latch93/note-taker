<html>
<head>
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min">
	
	

	<link rel="stylesheet" type="text/css" href="css/index">
</head>

<script>
$(document).ready(function(){

	var setKeywords = ["Your Mom", "Dad Jokes", "Actually Funny Jokes", "Dark Humor", "Straight Facts", "Beans Memes", "L e m o n"]

	var setsAmount = setKeywords.length;
	var iteration = 0;
	var columnsWide = 3;
	var rowsDeep = 2;
	var rowNumber = 0;

	for(iteration = 0; setsAmount > iteration; iteration++){
		console.log(iteration)
		elementKeyword = setKeywords[iteration];
		console.log(elementKeyword)
		if (iteration % columnsWide == 0 && iteration != 0){
			//add a new row element and a column element
			rowNumber++;
			$("#noteSetSelector").append('<div class="row row' + rowNumber + ' " style="margin-top:1%;"></div>')			
		}
			//add a new column to the existing row
			$(".row" + rowNumber).append("<div class='col-sm keyBlock' onclick='select(`"+elementKeyword+"`)' >" + setKeywords[iteration] + "</div>")	
		}

		
})

function select(elementId){
	console.log(elementId)
			$.ajax({
			        url: "selectNotes.php",
			        type: "post",
			        data: {
			        	setID: elementId, 	
					},
					//dataType: 'json',
					success: function (response) {
						var len = response.length;
						console.log(response)
						
						
					// You will get response from your PHP page (what you echo or print)
        			},
			    });
		}
		

</script>
<head>
<style type="text/css">
	.keyBlock {
  background: lightblue; 
   border-radius: 10px;
    margin: 10px; 
    padding-bottom:20%;
}
</style>	

</head>
<body>

<div class=container id="noteSetSelector">
	<div class="row0 row" style="margin-top:20%;">
		<!-- Preset -->
	</div>
</div>	


</body>
</html>