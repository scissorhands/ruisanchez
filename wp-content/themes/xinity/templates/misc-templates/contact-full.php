<?php
global $ioa_helper, $ioa_meta_data,$post,$ioa_super_options;

$ioa_options = get_post_meta( $post->ID, 'ioa_options', true );

if( isset($ioa_options['rad_addresses']) )
$addresses = $ioa_options['rad_addresses'];

 $inpval = array();

 $addresses = explode('[ioa_mod]',$addresses);

      foreach ($addresses as $key => $value) {
        
        if($value!="")
        {
         
          $mods = explode('[inp]', $value); 
          
          foreach($mods as $m)
          {

            if($m!="")
            {
              $te = (explode('[ioas]',$m)); 
              if(isset($te[1]))
              $inpval[] = $te[1]; 
            }

            
          }
        }
      }

 ?>



<?php if($ioa_options['prop_address']!="") : ?>
 
        <div class="clearfix address-mutual-wrap">
         
          <div class="map-wrapper">
            <div id="map"></div>
          </div>

          <div class="  full-main-address">
              <div class="skeleton auto_align">
              <a href="" class="ioa-front-icon minus-2icon- trigger-address"></a>
                <div class="main-address ">
                 <div class="main-address-head">
                      <span><?php _e('Our Main Address','ioa') ?></span>
                      
                </div>
                <div class="main-address-body">
                    <?php echo stripslashes($ioa_options['prop_address']) ?>
                </div>
              </div>
              </div>
          </div>

        </div>

<?php endif; ?>




  
<div class="skeleton clearfix auto_align">
    <div class="mutual-content-wrap <?php  if($ioa_meta_data['layout']!="full") echo 'sidebar-layout has-sidebar has-'.$ioa_meta_data['layout'];  ?>">
      <?php  
        /**
         * Featured Media Items contained by parent width will appear here. 
         */
        if(! post_password_required()) // Check if Page is password protected
        switch($ioa_meta_data['featured_media_type'])
        {
          case 'slider' :
          case 'slideshow' :
          case 'video' :
          case 'proportional' :
          case 'none-contained' :
          case 'image' : get_template_part('templates/content-featured-media'); break;
        }
      ?>

      
      

      <?php  if(have_posts()): while(have_posts()) : the_post(); ?>
      
        <?php if(get_the_content()!="") : ?>
            <?php  the_content(); ?>
        <?php endif; ?>
    
      <?php endwhile; endif;  ?>
        
      
    </div>
    <?php get_sidebar(); ?>
  </div>


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
 <script type="text/javascript">
 var geocoder,map;

 function initialize() {
    
    geocoder = new google.maps.Geocoder();
    var address  = [ <?php $i=0; foreach ($inpval as $key => $addr) {
         if( count($inpval)-1 == $i )
          echo '"'.$addr.'"';
        else
          echo '"'.$addr.'",';
        $i++;
      } ?>  ];
    var mapOptions = {
      scrollwheel:false,
      zoom: <?php echo $ioa_options['map_zoom'] ?>,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
     mapTypeControl: true,
    mapTypeControlOptions: {
        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
        position: google.maps.ControlPosition.BOTTOM_CENTER
    },
    panControl: true,
    panControlOptions: {
        position: google.maps.ControlPosition.RIGHT_CENTER
    },
    zoomControl: true,
    zoomControlOptions: {
        style: google.maps.ZoomControlStyle.LARGE,
        position: google.maps.ControlPosition.LEFT_CENTER
    },
    scaleControl: true,
    scaleControlOptions: {
        position: google.maps.ControlPosition.TOP_LEFT
    },
    streetViewControl: false,
   
    };

    var styles = [
    {
      stylers: [
        { hue: "<?php echo $ioa_options['map_color'] ?>" },
        { saturation:0 }
      ]
    },{
      featureType: "road",
      elementType: "geometry",
      stylers: [
        { lightness: 0 },
        { visibility: "simplified" }
      ]
    },{
      featureType: "road",
      elementType: "labels",
      stylers: [
        { visibility: "off" }
      ]
    }
  ];
        

    var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});
    var image = '<?php echo $ioa_options['map_marker'] ?>';

    map = new google.maps.Map(document.getElementById("map"),  mapOptions);
    map.mapTypes.set('map_style', styledMap);
    map.setMapTypeId('map_style');

    for(var i=0;i<address.length;i++)
    geocoder.geocode( { 'address': address[i]}, function(results, status) {
    
    if (status == google.maps.GeocoderStatus.OK) {
        
      google.maps.visualRefresh = true;

      map.setCenter(results[0].geometry.location);

       new google.maps.Marker({
            map: map,
            position: results[0].geometry.location,
            icon: image
        });
      } 
    

    });

   



}
google.maps.event.addDomListener(window, 'load', initialize);
</script>


</div>
</div>