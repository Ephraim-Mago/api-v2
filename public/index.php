<h1>Hello</h1>

<?php
  	$url = 'http://api-v2.test/products/';
  	$data = array('name' => 'Max Cata Lamp 13W', 'slug' => 'max-cata-lamp-13-w', 'description' => 'Max Cata 13W as energy saving electronic fluorescent lamp', 'price' => '2.25');
  	// utilisez 'http' même si vous envoyez la requête sur https:// ...
  	$options = array(
    	'http' => array(
      		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      		'method'  => 'POST',
      		'content' => http_build_query($data)
    	)
  	);
  	$context  = stream_context_create($options);
  	$result = file_get_contents($url, false, $context);
  	if ($result === FALSE) { /* Handle error */ }

  	var_dump($result);
?>