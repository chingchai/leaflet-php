<?php
//-------------------------------------------------------------
// * Name: PHP-PostGIS2GeoJSON  
// * Purpose: GIST@NU (www.cgistln.nu.ac.th)
// * Date: 2016/10/13
// * Author: Chingchai Humhong (chingchaih@nu.ac.th)
// * Acknowledgement: 
//-------------------------------------------------------------
   // Database connection settings
    define("PG_DB"  , "geodb");
    define("PG_HOST", "5.223.44.146"); 
    define("PG_USER", "postgres");
    define("PG_PORT", "5566"); 
    define("PG_PASS", "USbOtPlenS"); 
    define("TABLE",   "school");
    
    // Retrieve start point
    // Connect to database
    $con = pg_connect("dbname=".PG_DB." host=".PG_HOST." port=".PG_PORT." password=".PG_PASS." user=".PG_USER);
    $sql = "select  id, name, address, lat, lon, ST_AsGeoJSON(geom) AS geojson from ".TABLE."; ";
    
   // Perform database query
   $query = pg_query($con,$sql);   
   //echo $sql;
    // Return route as GeoJSON
   $geojson = array(
      'type'      => 'FeatureCollection',
      'features'  => array()
   ); 
  
   // Add geom to GeoJSON array
   while($edge=pg_fetch_assoc($query)) {  
      $feature = array(
         'type' => 'Feature',
         'geometry' => json_decode($edge['geojson'], true),
         'crs' => array(
            'type' => 'EPSG',
            'properties' => array('code' => '4326')
         ),
            'properties' => array(
            'id' => $edge['id'],
            'name' => $edge['name'],
            'address' => $edge['address'],
            'lat' => $edge['lat'],
            'lon' => $edge['lon']
         )
      );
      
      // Add feature array to feature collection array
      array_push($geojson['features'], $feature);
   }
   // Close database connection
   pg_close($con);
   // Return routing result
   // header('Content-type: application/json',true);
  echo json_encode($geojson);
?>