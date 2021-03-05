<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
<body>

<!-- <form name="test" method="get" action="php/getvalues.php"> -->
<p><input id="send" type="submit" value="Показать PDF"> </p>
<div class="inner"></div>
</body>
<script src="libs/jquery-3.4.1.js"></script>
<script type="text/javascript">
	$('#send').click(function() {
           $.ajax({
                success: function(){
					document.location.href = "functions/pdfGen.php";
                },
                error: function(){
                    console.log("Error");
                }
            });
        });
		 
</script>
</html>