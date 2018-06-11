<?php

    $weather ="";
    $error ="";

    if(array_key_exists('city',$_GET)){
        
        $city = str_replace(' ','',$_GET['city']);
        
        $file_headers = @get_headers("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
            
            $error = "The city does not exist";
            
        } else{
        
        $forecastPage = file_get_contents("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        
        $pageArray = explode('Weather Today </h2>(1&ndash;3 days)</span><p class="b-forecast__table-description-content"><span class="phrase">',$forecastPage);
        
        $secondPageArray = explode('</span></p></td><td colspan=',$pageArray[1]);
        
        $weather = $secondPageArray[0];
        }
    }

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <title>Weather Scraper</title>
    
    <style type="text/css">
        html { 
          background: url(background_weather.jpg) no-repeat center center fixed;
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
        }
        
        body{
            background:none;
        }
        
        .container{
            text-align:center;
            margin-top:150px;
            width:450px;
        }
        
        input{
            margin:20px 0;
        }
        
        #weather {
            margin-top:15px;
        }
        
    </style>
  </head>
  <body>
      
      
      <div class="container">
          <h1>What's The Weather?</h1>
          
         <form>
          <div class="form-group">
            <label for="exampleInputEmail1">Enter the name of a city</label>
            <input type="text" class="form-control" id="city" name="city" aria-describedby="emailHelp" placeholder="E.g. London, Tokyo" value="<?php
                if(array_key_exists('city',$_GET)){
                
                    echo $_GET['city']; 
                }
                    
                    ?>">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
        <div id="weather"><?php 
        
            if($weather){
                echo '<div class="alert alert-primary" role="alert">'
                .$weather.'</div>';
            } else if($error){
                echo '<div class="alert alert-danger" role="alert">'
                .$error.'</div>';
            }
        ?>
        </div>
          
      </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  </body>
</html>