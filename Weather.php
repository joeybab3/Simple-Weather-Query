 <?php
  //  http://joeybabcock.me/projects/posts/2014/05/08/php-actual-weather-query-script/  
  $url = 'http://w1.weather.gov/xml/current_obs/KCRQ.xml'; //go to http://w1.weather.gov/xml/current_obs/seek.php?state=ca&Find=Find to get your url, click on the xml one and copy it.
  $rain = '<script type=\"text/javascript\" src=\'http://joeybabcock.me/js/rainfall.js\';></script>';
  $snow = '<script type=\"text/javascript\" src=\'http://joeybabcock.me/js/snowfall.js\';></script>';
  $fog = 'Your Fog Here';
  $thunder = 'Thunder here';
  $sunny = '';
        
		
$xml = simplexml_load_file($url); $currentweather = $xml->weather; switch (true) { case stristr( $currentweather, "Thunderstorm" ): echo $thunder; break; case stristr( $currentweather, "Snow" ): case stristr( $currentweather, "Hail" ): echo $snow; break; case stristr( $currentweather, "Rain" ): case stristr( $currentweather, "Drizzle" ): case stristr ($currentweather, "Light Rain" ); case stristr( $currentweather, "Showers" ): echo $rain; break; case stristr( $currentweather, "Fog" ): case stristr( $currentweather, "Haze" ): case stristr( $currentweather, "Smoke" ): echo $fog; break; default: echo $sunny; break; } ?>
