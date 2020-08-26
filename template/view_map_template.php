<script type="text/javascript">
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>"; 
    var markerimageurl= "<?php echo plugin_dir_url( __FILE__ ) . 'assets/img/'; ?>";  
    var uploadimageurl= "<?php echo plugin_dir_url( __FILE__ ) . 'assets/uploads/'; ?>";
</script>
    <style>
      html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
      }
      #map {
        height: 600px;
        width: 100%;
      }
      #legend {
        font-family: Arial, sans-serif;
        background: #ffffff; 
        color:#102e43; 
        border: 1px solid #102e43;
      }
      #legend h3 {
        margin-top: 0;
      }
      #legend img {
        vertical-align: middle;
      }
    </style>
<div id="map"></div>
<div id="legend"><h3>Legend</h3></div>
  <script type="text/javascript">

  </script>
