<?
$zipcode = 'zip here'; //Put your zip code here.
$rain = '<script type=\"text/javascript\" src=\'http://joeybabcock.me/js/rainfall.js\';></script>';//What to echo when it rains 
$snow = '<script type=\"text/javascript\" src=\'http://joeybabcock.me/js/snowfall.js\';></script>';//What to echo when it snows
$fog = 'Your Fog Here';//What to echo when it is foggy
$thunder = 'Thunder here';//What to echo when it is stormy
$sunny = 'Skimmets';//What to echo on default


$url = 'http://weather.yahooapis.com/forecastrss?p=' . $zipcode;$use_errors = libxml_use_internal_errors(true);$xml = simplexml_load_file($url);if (!$xml) {  $xml = simplexml_load_file('local-backup-weather-file-here.xml');}libxml_clear_errors();libxml_use_internal_errors($use_errors);$currentweather = $xml->channel->item->children('yweather', TRUE)->condition->attributes()->text;echo '<!-- Joeybabcock.me Weather Query Script -->';$temp = $xml->channel->item->children('yweather', TRUE)->condition->attributes()->temp;switch (true) {case stristr( $currentweather, "Thunderstorm" ): 	 echo $thunder;	  break; 	  case stristr( $currentweather, "Snow" ): 	  case stristr( $currentweather, "Hail" ): 	  echo $snow; 	  break; 	  case stristr( $currentweather, "Rain" ): 	  case stristr( $currentweather, "Drizzle" ): 	  case stristr ($currentweather, "Light Rain" ): 	  case stristr( $currentweather, "Showers" ): 	  echo $rain; 	  break; 	  case stristr( $currentweather, "Fog" ): 	  case stristr( $currentweather, "Haze" ): 	  case stristr( $currentweather, "Smoke" ): 	  echo $fog; 	  break; 	  default: 	  echo $sunny;	  break;}
?>
