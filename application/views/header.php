<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>2025 Laboratories</title>

	<style type="text/css">

	@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,300,600);
	
	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }
	html {
		height: 100%;
	}
	div.entityinteractor {
		background-color: grey;
		bottom: 0;
		height: 45px;
		left: 50%;
		margin-left: -512px;
		/*padding: 10px;*/
		padding: 0 !important;
		position: fixed;
		width: 1024px;
	}
	
	div.entityinteractor form {
		margin-left: 10px;
		margin-top: 2px;
	}
	
	div.entityinteractor input[type=text] {
		font-size: 15px;
		height: 32px;  
		width: 500px;
	}
	
	div.mainentitycontainer {
		min-height: 55px;
	}
	
	div#body {
	}
	
	input#search {
		float:right;
		height: 32px;;
		margin-right: 20px;
		font-size: 15px;
		width: 300px;
	}
	
	div.entityinteractor input[type=submit] {
		height: 40px;
		width: 80px;
		font-size: 15px;
	}
	
	div#body > hr {
		margin-left: -25px;
	}
	
	div.entitycontainer:hover {
		background-color: #EEEEEE;
		box-shadow: 0px 0px 5px #EEEEEE;
	}
	
	div#timelinecontainer {
		position: relative;
		left: -25px;
	}
	
	div.entitycontainer {
		padding-left: 25px;
	}
	
	div.overlay {
		background-image: url("/media/bg.png");
		height: 100%;
		position: fixed;
		right: 0;
		top: 0;
		width: 100%;
		opacity: 0.8;
		z-index: 99;
		display:none;
	}
	
	div.overform {
		display:none;
		position: fixed;
		left: 50%;
		top:50%;
		z-index: 100;
		border: 1px solid black;
		border-radius: 3px;
		padding: 10px;
		width: 500px;
		background-color: white;
		margin-left: -250px;
	}
	
	div.entityinteractorspacer {
		height: 60px;
	}
	
	div.entitycontainer:hover {
		cursor:pointer;
	}
	
	div.imgcontainer-med img {
		max-width: 200px;
		max-height: 200px;
		display: block;
	}
	
	img.filetypeicon {
		margin-right: 10px;
		display: inline !important;
		box-shadow: none !important;
	}
	
	span.pinline {
		margin-left: 20px;
	}
	
	div.imgcontainer-big img {
		max-width: 500px;
		max-height: 500px;	
		display: block;
	}
	
	div.imgcontainer-med img, div.imgcontainer-big img {
		-moz-box-shadow: 2px 2px 2px #888;
		
		-webkit-box-shadow: 2px 2px 2px #888;
		box-shadow: 2px 2px 2px #888;
	}
	
	span.colourbox {
	    display: inline-block;
	    height: 15px;
	    margin-left: 10px;
	    margin-right: 10px;
	    width: 15px;
		position:relative;
		top: 2px;
	}
	
	form p label {
		color: gray;
		width: 120px;
		display:inline-block;
		vertical-align: top;
	}
	
	body {
		background-color: #DDDDDD;
		font: 13px/20px 'Open Sans', Arial, sans-serif;
		color: #333333;
		margin: 0;
		height: 100%;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}
	
	div#header_note {
		position:absolute;
		width: 200px;
		top: 0;
		right: 0;
		padding: 5px;
		height: 20px;
		background-color: green;
		color: white;
		padding-left: 50px;
		text-align:center;
	}
	
	div#header_note.header_error {
		background-color: red;
	}

	#container > h1 {
		color: #333333;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container {
		min-height: 100%;
		margin-top: -15px;
		margin-bottom: -55px;
		padding-bottom: 60px;
		background-color:white;
		box-shadow: 0 0 16px grey;
		position:relative;
		width: 1024px;
		margin-left: auto;
		margin-right: auto;
		border: 1px solid grey;
	}
	
	#container > h1 {
		margin-top: 15px;
	}
	
	#container > * {
		padding-left: 25px;
	}
	
	div#container > h1 ul li {
		display: inline;
		margin-left: 30px; 
		margin-right: 10px;
		cursor: pointer;
	}
	
	div#container > h1 ul li a {
		color: black;
		text-decoration: none;
	}
	
	div#container > h1 ul {
		display: inline;
		margin-left: -40px;
	}
	
	div#container > h1 img {
		display: inline;
	}
	
	div#push {
		height: 100%;
		margin-bottom: -25px;
	}
	
	div.sidenote {
		font-size: 11pt;
		font-weight: normal;
		display: inline;
		position: absolute;
		right: 20px;
		float: right;
	}
	
	span.subtext, span.subtext * {
		font-size: 10pt;
		color: grey;
		margin-left: 10px;
		font-weight: none;
		text-decoration: none;
	}
	
	</style>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
	
	<script>
	$(document).ready(function() {
		$("#header_note").delay(5000).fadeOut('slow');
	});
	
	function doEntity(e) {
		window.location = "<?=base_url()?>collaborate/timeline/display/"+e;
	}
	
	
	</script>
</head>
<body>

<?=get_header_note()?>

<div id="container">
	<h1>
	<?php 
	
	$url = base_url();
	if(isLoggedIn()) $url .= "collaborate/timeline";
	
	?>
	
	<a href=<?=$url?> ><img src=<?=base_url();?>media/2025-small.png /></a>
	<?=$menu?>
	
	<?if(isLoggedIn()):
		$u = new User();?>
		<div class=sidenote><?=$u->renderColourBox().$u->name?> <a href=<?=base_url()?>collaborate/system/logout>(log out)</a></div>
	<?endif?>
	

	</h1>

	<div id="body">