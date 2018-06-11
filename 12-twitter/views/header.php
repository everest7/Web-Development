<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	
	<link rel="stylesheet" href="http://wsomerset.info/12-twitter/styles.css">

    <title>Hello, world!</title>
  </head>
  <body>
  
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <a class="navbar-brand" href="http://wsomerset.info/12-twitter/">Twitter</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
		  <li class="nav-item active">
			<a class="nav-link" href="?page=timeline">Your timeline <span class="sr-only">(current)</span></a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="?page=yourtweets">Your tweets</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="?page=publicprofiles">Public Profiles</a>
		  </li>
		</ul>
		<div class="form-inline my-2 my-lg-0">
		<?php if($_SESSION['id']){ ?>
			
			<a class="btn btn-outline-success" href="?function=logout">Logout</a>
		
		<?php } else { ?>
		
		  <button class="btn btn-outline-success my-2 my-sm-0"  data-toggle="modal" data-target="#exampleModal">Login/SignUp</button>
		  
		 <?php }  ?>
		</div>
	  </div>
	</nav>