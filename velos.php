<?php
//$context = stream_context_create($opts);
//$opts = array('http' => array('proxy'=> 'tcp://www-cache:3128', 'request_fulluri'=> true));
//$context = stream_context_create($opts);

$xmltxt = file_get_contents('http://ip-api.com/xml', false);

$xml1 = new DOMDocument;
//$xml->load('gps.xml');
$xml1->loadXML($xmltxt);

$test=simplexml_load_string($xmltxt);
$latitude= $test->lat;
$longitude = $test->lon;
$ville=$test->city;


$meteo= file_get_contents("https://www.infoclimat.fr/public-api/gfs/xml?_ll=$latitude,$longitude&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2",false);
//echo $longitude.",".$latitude;



$xml = new DOMDocument;
//$xml->load('gps.xml');
$xml->loadXML($meteo);
$test=simplexml_load_string($meteo);
$xsl = new DOMDocument;
$xsl->load('meteo.xsl');
// Configuration du transformateur
$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl); // attachement des règles xsl 

//$opts = array('http' => array('proxy'=> 'tcp://www-cache:3128'));
//$context = stream_context_create($opts);
$velib= file_get_contents("https://api.jcdecaux.com/vls/v1/stations?contract=$ville&apiKey=5dc905dc851e7cfa5b910d25c2e82eea9b6b43fd",false);
$velib = json_decode($velib);



?>
<!DOCTYPE html>
<html>

<head>
    <title>A Bicyclette</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
</head>
<style>
    #map {
        height: 500px;
    }
    table{
        width: 100%;
    }
    h3{
        text-align: center;
    }
</style>

<body>

    <?php echo $proc->transformToXML($xml);?>
    <script type="text/javascript">
        
        var requete = new XMLHttpRequest();
        requete.onload = function() {
        //La variable à passer est alors contenue dans l'objet response et l'attribut responseText.
        var variableARecuperee = this.responseText;
        };
    </script>
    <h1>
         
         <script type="text/javascript">
            document.write(variableARecuperee)
         </script>
      </h1>
    <div id="map">
        <script type="text/javascript">

            var map = L.map('map').setView([<?php echo $latitude ?>, <?php echo $longitude ?>], 14);
            <?php
            foreach($velib as $station){
                $place_libre=$station->available_bike_stands;
                $velo_dispo=$station->available_bikes;
                $lat=$station->position;
                $lat=$lat->lat;
                $lng=$station->position;
                $lng=$lng->lng;
                ?>
                var marker = L.marker([<?php echo $lat?>,<?php echo $lng?>]).addTo(map);
                marker.bindPopup("Velo(s) Disponible :<?php echo $velo_dispo?> <br/> Borne(s) Disponible :<?php echo $place_libre?>").openPopup();
                <?php
            }?>
            
            var tiles = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 18,
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1
            }).addTo(map);

        </script>
    </div>
    <div>
        <h1>Sources :</h1>
        <ul>
            <li><a href="http://ip-api.com/xml">Info ip</a></li>
            <li><a href="https://www.infoclimat.fr/public-api/gfs/xml?_ll=<?php echo $latitude?>,<?php echo $longitude?>&_auth=ARsDFFIsBCZRfFtsD3lSe1Q8ADUPeVRzBHgFZgtuAH1UMQNgUTNcPlU5VClSfVZkUn8AYVxmVW0Eb1I2WylSLgFgA25SNwRuUT1bPw83UnlUeAB9DzFUcwR4BWMLYwBhVCkDb1EzXCBVOFQoUmNWZlJnAH9cfFVsBGRSPVs1UjEBZwNkUjIEYVE6WyYPIFJjVGUAZg9mVD4EbwVhCzMAMFQzA2JRMlw5VThUKFJiVmtSZQBpXGtVbwRlUjVbKVIuARsDFFIsBCZRfFtsD3lSe1QyAD4PZA%3D%3D&_c=19f3aa7d766b6ba91191c8be71dd1ab2">Data infos climat</a></li>
            <li><a href="https://api.jcdecaux.com/vls/v1/stations?contract=<?php echo $ville?>&apiKey=5dc905dc851e7cfa5b910d25c2e82eea9b6b43fd">Data velo'stan</a></li>
        </ul>
    </div>
</body>

</html>
