<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" >
		<link href="../../content/themes/material/material.min.css" rel="stylesheet" >
		<link href="../../content/themes/_default/style.css" rel="stylesheet" >
		<script src="../../content/themes/material/material.min.js"></script>
		<script src="../../content/scripts/jquery/jquery.min.js"></script>
	</head>
	<body onload="$('body').show('fade')" style="display:none;">
		<div id="content" class="mdl-layout mdl-js-layout" >
			<main class="mdl-layout__content">			  
				<div class="snippet-group">
					<div class="snippet-header">
						<div class="snippets">				  
							<div class="snippet">
								<div class="snippet-container">									
									<div id="snippet-content"><?php include $_GET['url']; ?></div>									
								</div>				  
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>
	</body>
</html>