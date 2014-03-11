<!DOCTYPE html>
<html>
<head>
	<title>Example</title>
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/css/bootstrap.css">
	<style type="text/css">
	.container{
		margin-bottom: 50px;
	}
	</style>
</head>
<body>
<div class="container">
	<h1>Flexible Validator</h1>
	<fieldset>
		<legend>Test Form</legend>
		<?php include("validates.php");?>

		<form role="form" method="post" action="" enctype="multipart/form-data">
		  <div class="form-group">
		    <label for="exampleInputEmail1">Email address</label>
		    <input type="text" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword1">Password</label>
		    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword2">Confirm Password</label>
		    <input type="password" name ="password_confirmation" class="form-control" id="exampleInputPassword2" placeholder="Confirm Password">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputEmail1">Alternative Email address</label>
		    <input type="text" name="email2" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputFile">My File</label>
		    <input type="file" name ='myfile' id="exampleInputFile">
		    <p class="help-block">Example block-level help text here.</p>
		  </div>
		  <div class="checkbox">
		    <label>
		      <input type="checkbox" name="checkme"> Check me out
		    </label>
		  </div>
		  <button type="submit" name="submit" class="btn btn-default">Submit</button>
		</form>
	</fieldset>
</div>	
</body>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.1/js/bootstrap.min.js"></script>
</html>