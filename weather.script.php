<?php 
  //  https://joeybabcock.me/projects/posts/2014/05/08/php-actual-weather-query-script/ For more info 
  $zipcode = 92011; //put your zipcode here(or set it dynamically from the user's information)
  
  $rainlight = '
  <script type="text/javascript">
  var script = document.createElement( \'script\' );
  script.type = \'text/javascript\';
  script.src = \'https://joeybabcock.me/js/rainfall1.js\';
  $("#nav").prepend(script);
  </script>';//Light rain script
  
  $rainheavy = '
  <script type="text/javascript">
  var script = document.createElement( \'script\' );
  script.type = \'text/javascript\';
  script.src = \'https://joeybabcock.me/js/rainfall2.js\';
  $("#nav").prepend(script);
  </script>';//Heavy rain
  
  $snow = '<script type="text/javascript" src=\'https://joeybabcock.me/js/snowfall.js\'></script>';//Snow script
  
  $fog = '<style type="text/css">#viewport{-webkit-filter: blur(1px);filter: blur(1px);}</style>';//Blurs the screen slightly
  
  $thunder = "<script type='text/javascript' src='https://joeybabcock.me/js/weather/lightning-weather.js'></script>"; //a script for fun
  
  $sunny = ''; //nothing but the clouds
  
  $thunds = false;//Set to true for later addition of the canvas overlay
  
  /* various cloud numbers/colors */
  $clouds = "<script>var  NUM_CLOUDS = 30;var type = 1;</script><script type='text/javascript' src='https://joeybabcock.me/js/weather/clouds.js'></script>";
  $cloudsthin = "<script>var  NUM_CLOUDS = 8;var type = 1;</script><script type='text/javascript' src='https://joeybabcock.me/js/weather/clouds.js'></script>";
  $cloudsuthin = "<script>var  NUM_CLOUDS = 4;var type = 1;</script><script type='text/javascript' src='https://joeybabcock.me/js/weather/clouds.js'></script>";
  $cloudsdark = "<script>var  NUM_CLOUDS = 50;var type = 3;</script><script type='text/javascript' src='https://joeybabcock.me/js/weather/clouds.js'></script>";
  $cloudsmed = "<script>var  NUM_CLOUDS = 50;var type = 2;</script><script type='text/javascript' src='https://joeybabcock.me/js/weather/clouds.js'></script>";
  $cloudsfog = "<script>var  NUM_CLOUDS = 80;var type = 1;</script><script type='text/javascript' src='https://joeybabcock.me/js/weather/clouds.js'></script>";
  /* Rain Sounds */
  $rainsoundslib ="<script src='https://joeybabcock.me/js/buzz.min.js'></script>";
  $rainsounds = '<script>var mySound = new buzz.sound( "https://joeybabcock.me/audio/rain", {
    formats: [ "ogg", "mp3" ] });
mySound.play().fadeIn().loop().setVolume(50);</script>
';
		
$url = 'https://weather.yahooapis.com/forecastrss?p=' . $zipcode . '&u=f';//Url to weather XML file(thanks to yahoo)
$use_errors = libxml_use_internal_errors(true);
$string = file_get_contents($url);
$xml = simplexml_load_string($string);
$xml->registerXPathNamespace('yweather', 'http://xml.weather.yahoo.com/ns/rss/1.0');
$location = $xml->channel->xpath('yweather:location');
libxml_clear_errors();
libxml_use_internal_errors($use_errors);
//if(isset($xml->channel->item->children('yweather', TRUE)->condition->attributes()->text)){//My old host would complain if this wasn't set
echo '<!-- Joeybabcock.me Weather Query Script -->';
	
    foreach($xml->channel->item as $item){
		
        $current = $item->xpath('yweather:condition');
        $forecast = $item->xpath('yweather:forecast');
        $winds = $xml->channel->xpath('yweather:wind');
	$units = $xml->channel->xpath('yweather:units');
	$unit = (string)$units[0]->attributes()->temperature;
        $currentweather = (string)$current[0]->attributes()->text;
	$temp = (string)$current[0]->attributes()->temp;
	$wind = (string)$winds[0]->attributes()->speed . " " . (string)$units[0]->attributes()->distance . "/h";
	$windraw = (string)$winds[0]->attributes()->speed;	
	$windspeed = '<script>var speed = '.$windraw.';</script>';
	//echo $currentweather;	//tests	
	//$currentweather = "Thunder";
        switch (true) {
	        case stristr( $currentweather, "Thunderstorm" ): 
	        case stristr( $currentweather, "Thunder" ):	 
	                echo $thunder;
			$img = 42;
			$thunda = true;
			echo $rainheavy;
		        echo $cloudsdark;
			echo $windspeed;
			echo $rainsoundslib;
			echo $rainsounds;
	    	break;
	    	case stristr( $currentweather, "Snow" ): 	  
	    	case stristr( $currentweather, "Hail" ): 	  
	                echo $snow;
			$img = 34;
			echo $windspeed;
	    	break;
	    	case stristr( $currentweather, "Rain" ):
		case stristr( $currentweather, "Showers" ):
		        echo $rainheavy;
			$img = 18;
			echo $cloudsmed;
			echo $windspeed;
			echo $rainsoundslib;
			echo $rainsounds;
		break;
	    	case stristr( $currentweather, "Drizzle" ):
	    	case stristr( $currentweather, "Light Rain" ):
	                echo $rainlight;
			$img = 17;
			echo $cloudsmed;
			echo $windspeed;
			echo $rainsoundslib;
			echo $rainsounds;
					  
	    	break;
	    	case stristr( $currentweather, "Fog" ):
		case stristr( $currentweather, "foggy" ):
	    	case stristr( $currentweather, "Haze" ):
        	case stristr( $currentweather, "Smoke" ):
	                echo $fog;
			$img = 13;
			echo $cloudsfog;
			echo $windspeed;
	    	break;
		case stristr( $currentweather, "Cloudy" ):
		case stristr( $currentweather, "Cloud" ):
		case stristr( $currentweather, "Clouds" ):
		        echo $clouds;
			$img = 32;
			echo $windspeed;
		break;
		case stristr( $currentweather, "Fair" ):
			echo $cloudsuthin;
			$img = 32;
			echo $windspeed;
		break;
		case stristr( $currentweather, "Partly Cloudy" ):
		        echo $cloudsthin;
			$img = 32;
			echo $windspeed;
		break;
	    	default: 	  
		        echo $sunny;
		        $img = 28;
			echo $windspeed;
        	break;
		}
		
	}
	
?>
<div class="widget">
	<h2>Weather</h2>
	<div class="inner"> 
		<p>Current Weather For <? echo $zipcode; ?>:</p>
		<? echo $currentweather . " " . $temp . "&deg;<small>". $unit ."</small>, Wind Speed: " . $wind; ?>
	</div>
</div>
