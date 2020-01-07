<?php
/*
Plugin Name:  Youtube video Plugin
Plugin URI: tbanys.com
Description: Video plugin
Version: 1.0.0
Author: Tautvydas Banys
License: GPLv2 or later
Text Domain: tb-video
*/


add_shortcode( 'tb-video', 'tb_youtube_video_shortcode');
add_action( 'vc_before_init', 'tb_youtube_video_map_to_wpbackery');

function tb_youtube_video_shortcode($atts) {
  $a = shortcode_atts( array(    
    'id' => '',
    'autoplay' => 0,
    'rel' => 0,
    'loop' => 0,
    'controls' => 0,
    'width' => '100%',
    'height' => '100%',
  ), $atts );

  ob_start();
  $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
  $domainName = $_SERVER['HTTP_HOST'];
  $url = $protocol . $domainName;
  ?>
  <?php if (!empty($a['id'])) : ?>
    <div class="embed-container">
      <iframe id="player" type="text/html" width="550" height="310" style="<?php echo !empty($a['width']) ? 'width: ' . $a['width'] . ';' : ''; ?><?php echo !empty($a['height']) ? 'height: ' . $a['height'] . ';' : ''; ?>"
      src="https://www.youtube.com/embed/<?php echo $a['id']; ?>?rel=<?php echo $a['rel']; ?>&loop=<?php echo $a['loop']; ?>&autoplay=<?php echo $a['autoplay']; ?>&controls=<?php echo $a['controls']; ?>&enablejsapi=1&origin=<?php echo urlencode($url); ?>"
      frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"></iframe>
    </div>
    <style>
      .embed-container { 
        position: relative; 
        padding-bottom: 56.25%;
        overflow: hidden;
        max-width: 100%;
        height: auto;
      } 

      .embed-container iframe,
      .embed-container object,
      .embed-container embed { 
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
      }
    </style>
  <?php else : ?>
    <p>Video ID not found</p>
  <?php endif; ?>
<?php
  return ob_get_clean();
}

function tb_youtube_video_map_to_wpbackery() {
  if(function_exists("vc_map")){
    vc_map([
        "name" => "Custom video",
        "base" => "tb-video",
        "vc_map" => "Custom video",
        "content_element" => true,
        "is_container" => false,
        "params" => [
          [
            "type" => "textfield",
            "class" => "",
            "heading" => __( "Video ID", "html5blank" ),
            "param_name" => "id",
          ],
          [
            "type"        => "checkbox",
            "class"       => "",
            "heading"     => __( "Rel", "html5blank" ),
            "param_name"  => "rel",
            "value"       => array(
              'Yes' => 1,
            ),
          ],
          [
            "type" => "checkbox",
            "class" => "",
            "heading" => __( "Loop", "html5blank" ),
            "param_name" => "loop",
            "value"       => array(
              'Yes' => 1,
            ),
          ],
          [
            "type" => "checkbox",
            "class" => "",
            "heading" => __( "Autoplay", "html5blank" ),
            "param_name" => "autoplay",
            "value"       => array(
              'Yes' => 1,
            ),
          ],
          [
            "type" => "checkbox",
            "class" => "",
            "heading" => __( "Controls", "html5blank" ),
            "param_name" => "controls",
            "value"       => array(
              'Yes' => 1,
            ),
          ],
          [
            "type" => "textfield",
            "class" => "",
            "heading" => __( "Width", "html5blank" ),
            "param_name" => "width",
            "value" => "100%", //Default
            "description" => __( "Default 100%. Values can be in px and %", "html5blank" ),
          ],
          [
            "type" => "textfield",
            "class" => "",
            "heading" => __( "Height", "html5blank" ),
            "param_name" => "height",
            "value" => "100%", //Default
            "description" => __( "Default 100%. Values can be in px and %", "html5blank" ),
          ],
        ]
    ]);
  }
}  


?>