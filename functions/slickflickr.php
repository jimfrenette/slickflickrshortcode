<?php
/**
 * Slick Flickr Album Shortcode
 *
 * @since bga 2018-10
 *
 * @param array [photoset_id
 * example
 * [slickflickrshortcode photoset_id=72157700655807521]
 *
 * @return string Unordered list of images for lazy loading slick photo gallery
 *
 * url format reference:
 * https://www.flickr.com/services/api/misc.urls.html
 */
function slickflickr_shortcode_handler($args) {

    $xml = slickflickr_get_photoset($args['photoset_id']);

    ob_start();
	?>
    <ul class="photogrid">
    <?php
    foreach($xml->photoset[0]->photo as $photo) {
        echo '<li><img data-src="https://farm' . $photo['farm'] . '.staticflickr.com/' . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '_b.jpg" alt="' . $photo['title'] . '" /></li>';
    }
    ?>
    </ul>
    <?php
    return ob_get_clean();
}
add_shortcode( 'slickflickrshortcode',  'slickflickr_shortcode_handler' );

function slickflickr_curl($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch); // response
    curl_close($ch);
    return $data;
}

function slickflickr_get_photoset($photoset_id) {
    $results = null;
    $api_key = '6905c474af51a058cf1f0dc858076cba';
    $url = 'https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=' . $api_key . '&photoset_id=' . $photoset_id . '&format=rest';
    $xml = new \SimpleXmlElement(slickflickr_curl($url));
    return $xml;
}
