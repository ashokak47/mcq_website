<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
	<meta name="author" content="Bootlab">

	<title><?=$title?></title>
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300&display=swap" rel="stylesheet">

	 <link href="<?=base_url()?>public/app_stack/css/modern.css" rel="stylesheet"> 
	<link href="<?=base_url()?>public/app_stack/css/custom.css" rel="stylesheet">
	<!-- BEGIN SETTINGS -->
	<!-- You can remove this after picking a style -->
	<style>
		body {
			opacity: 0;
			font-family: 'Roboto Slab', serif;
	        font-size: 12px;
		}
	</style>
	
	<!-- END SETTINGS -->
</head>
<script>
	 window.addEventListener("load", function(){
	 var load_screen = document.getElementById("load_screen");
	    $(load_screen).hide();
	 });
</script> 
<body>
    <div id="load_screen">
    	<div class="spinner-border text-primary mr-2 custom-spinner" role="status">
			<span class="sr-only">Loading...</span>
		</div>
    </div>
