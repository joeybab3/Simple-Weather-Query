<?
  //  http://joeybabcock.me/projects/posts/2014/05/08/php-actual-weather-query-script/ For more info 
  if(isset($details['zip'])) {
  $zipcode = $details['zip'];
  } else {
  $zipcode = 92011;
  }
  $rain = '<script type="text/javascript" src=\''.$proto.'://joeybabcock.me/js/rainfall.js\'></script>';
  $snow = '<script type="text/javascript" src=\''.$proto.'://joeybabcock.me/js/snowfall.js\'></script>';
  $fog = 'it\'s foggy';
  $thunder = "<script type='text/javascript' src='".$proto."://joeybabcock.me/js/weather/lightning-weather.js'></script>";
  $sunny = '';
  $clouds = "<script>var  NUM_CLOUDS = 30;var type = 1;</script><script type='text/javascript' src='".$proto."://joeybabcock.me/js/weather/clouds.js'></script>";
  $cloudsthin = "<script>var  NUM_CLOUDS = 10;var type = 1;</script><script type='text/javascript' src='".$proto."://joeybabcock.me/js/weather/clouds.js'></script>";
  $cloudsdark = "<script>var  NUM_CLOUDS = 50;var type = 3;</script><script type='text/javascript' src='".$proto."://joeybabcock.me/js/weather/clouds.js'></script>";
  $thunda = false;

$url = 'http://weather.yahooapis.com/forecastrss?p=' . $zipcode . '&u=f';
$use_errors = libxml_use_internal_errors(true);
$string = file_get_contents($url);
$xml = simplexml_load_string($string);
$xml->registerXPathNamespace('yweather', 'http://xml.weather.yahoo.com/ns/rss/1.0');
$location = $xml->channel->xpath('yweather:location');
libxml_clear_errors();
libxml_use_internal_errors($use_errors);
//if(isset($xml->channel->item->children('yweather', TRUE)->condition->attributes()->text)){
//$currentweather = $xml->channel->item->children('yweather', TRUE)->condition->attributes()->text;
//}
echo '<!-- Joeybabcock.me Weather Query Script -->';
//if(isset($xml->channel->item->children('yweather', TRUE)->condition->attributes()->temp)){
//$temp = $xml->channel->item->children('yweather', TRUE)->condition->attributes()->temp;
//}
	
    foreach($xml->channel->item as $item){
		
            $current = $item->xpath('yweather:condition');
            $forecast = $item->xpath('yweather:forecast');
            $currentweather = (string)$current[0]->attributes()->text;	
			//echo $currentweather;		
			
        switch (true) {
			
	    case stristr( $currentweather, "Thunderstorm" ): 
		case stristr( $currentweather, "Thunder" ):	 
	                  echo $thunder;$img = 42;$thunda = true;
	    break;
	    case stristr( $currentweather, "Snow" ): 	  
	    case stristr( $currentweather, "Hail" ): 	  
	                  echo $snow;$img = 34;
	    break;
	    case stristr( $currentweather, "Rain" ):
		case stristr( $currentweather, "Showers" ):
		              echo $rain;$img = 18;
		break;
	    case stristr( $currentweather, "Drizzle" ):
	    case stristr( $currentweather, "Light Rain" ):
	                  echo $rain;$img = 17;echo $rain;
	    break;
	    case stristr( $currentweather, "Fog" ):
	    case stristr( $currentweather, "Haze" ):
        case stristr( $currentweather, "Smoke" ):
	                  echo $fog;$img = 13;echo $cloudsdark;
	    break;
		case stristr( $currentweather, "Cloudy" ):
		case stristr( $currentweather, "Cloud" ):
		case stristr( $currentweather, "Clouds" ):
		              echo $clouds;$img = 32;
		break;
		case stristr( $currentweather, "Fair" ):
		case stristr( $currentweather, "Partly Cloudy" ):
		              echo $cloudsthin;$img = 32;
		break;
	    default: 	  echo $sunny;$img = 28;
        break;
			
        }
		
	}
	?>
