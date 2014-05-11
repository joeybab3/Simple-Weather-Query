<?
$zipcode = '92011'; //Either set this to a zip code, or you can make it dynamic
$rain = '<script type=\"text/javascript\" src=\'http://joeybabcock.me/js/rainfall.js\';></script>'; 
$snow = '<script type=\"text/javascript\" src=\'http://joeybabcock.me/js/snowfall.js\';></script>';
$fog = 'Your Fog Here';
$thunder = 'Thunder here';
$sunny = 'Skimmets';


$url = 'http://weather.yahooapis.com/forecastrss?p=' . $zipcode; //fetch the xml file
$use_errors = libxml_use_internal_errors(true); //Should we use internal errors
$xml = simplexml_load_file($url); //load the file
if (!$xml) {
  $xml = simplexml_load_file('local-backup-weather-file-here.xml'); //This is used in case Yahoo's weather service is not available (prevents a PHP error on the frontend)
}
libxml_clear_errors();
libxml_use_internal_errors($use_errors);

//Examples of how to pull data from the XML
$currentweather = $xml->channel->item->children('yweather', TRUE)->condition->attributes()->text;
$temp = $xml->channel->item->children('yweather', TRUE)->condition->attributes()->temp;

switch (true) {
	 case stristr( $currentweather, "Thunderstorm" ): 
	 echo $thunder;
	  break; 
	  case stristr( $currentweather, "Snow" ): 
	  case stristr( $currentweather, "Hail" ): 
	  echo $snow; 
	  break; 
	  case stristr( $currentweather, "Rain" ): 
	  case stristr( $currentweather, "Drizzle" ): 
	  case stristr ($currentweather, "Light Rain" ): 
	  case stristr( $currentweather, "Showers" ): 
	  echo $rain; 
	  break; 
	  case stristr( $currentweather, "Fog" ): 
	  case stristr( $currentweather, "Haze" ): 
	  case stristr( $currentweather, "Smoke" ): 
	  echo $fog; 
	  break; 
	  default: 
	  echo $sunny;
	  break;
}
?>
