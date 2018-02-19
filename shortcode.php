<?php

function create_marvel_shortcode($atts) {
    $atts = shortcode_atts(
        array(
        ),
        $atts,
        'marvel'
    );

    $ts = time();
    $public_key = 'f4e1e14babf4f5e4d3299fbfe0e0856f';
    $private_key = '29e8e62498621ea690324f2a36525b9474656980';
    $hash = md5($ts . $private_key . $public_key);

    $api_request    = 'http://gateway.marvel.com/v1/public/comics?ts='.$ts.'&apikey='.$public_key.'&hash='.$hash;
    $api_response = wp_remote_get( $api_request, $args );
    $response_data = json_decode( wp_remote_retrieve_body( $api_response ), true );

    foreach ($response_data['data']['results'] as $key) {
        $img = $key['thumbnail']['path']."/portrait_medium.".$key['thumbnail']['extension'];
        echo "<div class='boxMarvel'>";
            echo "<div class='col1'>";
                echo "<img src='$img'>";
            echo "</div>";
            echo "<div class='col2'>";
                echo "<p><strong>".$key['title']."</strong></p>";
                echo "<p>$".$key['prices'][0]['price']."</p>";
            echo "</div>";
        echo "</div>";
    }


}

add_shortcode( 'marvel', 'create_marvel_shortcode' );

?>