<?php
    $url = "http://api-v2.test/products/7"; // modifier le produit 1
    $data = array('name' => 'Techno Camon 14 Pro', 'slug' => 'techno-camon-14-pro', 'description' => 'The Techno Camon 14 Pro is phone the families android smartphone', 'price' => '150.99');
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
    $response = curl_exec($ch);

    var_dump($response);

    if (!$response) 
    {
        return false;
    }
?>