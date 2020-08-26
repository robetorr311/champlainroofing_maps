<?php
/*
  Plugin Name: champlainroofing_maps
  Plugin URI: https://www.champlainroofing.com
  Description: Custom plugin for champlainroofing site
  Version: 1
  Author: Robert Torres
  Author URI: https://robetorr.net
*/
  function mapchamplainroofing_install(){
    global $wpdb;
    $table_locations= $wpdb->prefix . "locations";
    $sql1 = "CREATE TABLE $table_locations ( id int(11) NOT NULL, name text NOT NULL, type text NOT NULL, address text NOT NULL, description text NOT NULL, latitude text NOT NULL, longitude text NOT NULL, image text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $sql2= "ALTER TABLE $table_locations ADD PRIMARY KEY(id);";
    $sql3="ALTER TABLE $table_locations MODIFY id INT(11) NOT NULL AUTO_INCREMENT;";
    $wpdb->query($sql1);
    $wpdb->query($sql2);
    $wpdb->query($sql3);
  }
  function mapchamplainroofing_uninstall(){
    global $wpdb; 
    $table_locations= $wpdb->prefix . "locations";
    $sql1 = "DROP TABLE $table_locations";
    $wpdb->query($sql1);
  }
  function champlainroofing_maps_general_settings(){
    global $wpdb;
    $table_locations= $wpdb->prefix . "locations";
    $results_locations = $wpdb->get_results("SELECT * FROM $table_locations;"); 
    include('template/general_settings.php');
  }
  function save_location(){
    global $wpdb;
    $table_locations= $wpdb->prefix . "locations";
    $name=$_POST['name'];
    $type=$_POST['type'];
    $address=$_POST['address'];
    $description=$_POST['description'];
    $latitude=$_POST['latitude'];
    $longitude=$_POST['longitude'];
    $picture=$_POST['picture'];
    $data_location= array('name'=> $name,
          'type'=> $type,
          'address'=> $address,
          'description'=> $description,
          'latitude'=> $latitude,
          'longitude'=> $longitude,
          'image'=> $picture);
    $format_location = array('%s','%s','%s','%s','%s','%s','%s');
    $wpdb->insert($table_locations,$data_location,$format_location);
    $my_id = $wpdb->insert_id;
    if($my_id>0){
      $output="Success";
    }
    else {
      $output=$wpdb->last_error;;
    }
    echo $output;
    wp_die();
   } 
  function get_locations(){
    global $wpdb;
    $table_locations= $wpdb->prefix . "locations";
    $results_locations = $wpdb->get_results("SELECT * FROM $table_locations;");
    $output="[";
    foreach ($results_locations as $key) {
      $output.= '{"id":"'.$key->id.'", "name": "'.$key->name.'", "type":"'.$key->type.'", "address": "'.$key->address.'", "description": "'.$key->description.'", "latitude": '.$key->latitude.', "longitude": '.$key->longitude.', "image":"'.$key->image.'"},';      
    }
    $output=substr($output, 0, -1);      
    $output.="]";
    echo $output;
      wp_die();
  }
  function delete_location(){
      global $wpdb; 
      $id=$_POST['id'];
      $table_locations= $wpdb->prefix . "locations";
      $sql="DELETE from $table_locations WHERE id=$id;";
      $wpdb->query($sql);
      echo "Success"; 
      wp_die();
  }
   function compressImage($source, $destination, $quality) {

     $info = getimagesize($source);

     if ($info['mime'] == 'image/jpeg') 
       $image = imagecreatefromjpeg($source);

     elseif ($info['mime'] == 'image/gif') 
       $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png') 
      $image = imagecreatefrompng($source);

     imagejpeg($image, $destination, $quality);
     return $destination;
   }  
  function uploadfile(){
    global $wpdb;
    $dir = plugin_dir_path( __DIR__ );
    $output_dir = $dir."champlainroofing_map/template/assets/uploads/";
    $filename = $_FILES["myfile"]["name"];
    move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$filename);
    echo $filename ;
    wp_die();       
  }     
  function view_map(){
    global $wpdb;
    include('template/view_map_template.php');
  }
  add_shortcode( 'cr_view_map', 'view_map_shortcode' );
  function view_map_shortcode() {
    ob_start();
    view_map();
    return ob_get_clean();
  }
  function replace_core_jquery_version() {
    wp_deregister_script( 'jquery' );
    // Change the URL if you want to load a local copy of jQuery from your own server.
    wp_register_script( "jquery", plugin_dir_url( __FILE__ ) . '/template/assets/js/jquery.min.js', array(), '1.11.1' );
  }
  function bootstrap_load_styles(){
    wp_register_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css');
    wp_enqueue_style( 'bootstrap' );
  }    
  function bootstrap_load_scripts() {
    wp_enqueue_script( "bootstrap", 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js' , array( 'jquery' ) ); 
  }  
  function maps_load_scripts() {
    wp_enqueue_script( "maps", 'https://maps.googleapis.com/maps/api/js?key=', array('jquery'), true );
    wp_enqueue_script( "locations", plugin_dir_url( __FILE__ ) . '/template/assets/js/locations.js' , array( 'jquery','maps' ) ); 
  }  
  function validate_load_styles(){
    wp_register_style('screen', plugin_dir_url( __FILE__ ) . 'template/assets/css/screen.css');
    wp_register_style('reset', plugin_dir_url( __FILE__ ) . 'template/assets/css/reset.css');
    wp_register_style('cmxform', plugin_dir_url( __FILE__ ) . 'template/assets/css/cmxform.css');
    wp_register_style('cmxformtemplate', plugin_dir_url( __FILE__ ) . 'template/assets/css/cmxformTemplate.css');
    wp_register_style('core', plugin_dir_url( __FILE__ ) . 'template/assets/css/core.css');
    wp_enqueue_style( 'screen' );
  }
  function upload_load_styles(){
    wp_register_style('upload', plugin_dir_url( __FILE__ ) . 'template/assets/css/jquery-file-upload.css');
    wp_enqueue_style( 'upload' );
  }
  function uploadfile_load_styles(){
    wp_register_style('uploadfile', plugin_dir_url( __FILE__ ) . 'template/assets/css/uploadfile.css');
    wp_enqueue_style( 'uploadfile' );
  }
  function datatables_load_styles(){
    wp_register_style('datatables', plugin_dir_url( __FILE__ ) . 'template/assets/css/jquery.dataTables.min.css');
    wp_enqueue_style( 'datatables' );
  }      
  function validate_load_scripts() {
  wp_enqueue_script( "jquery-validate", plugin_dir_url( __FILE__ ) . 'template/assets/js/jquery.validate.js', array( 'jquery' ) );
  }
  function upload_load_scripts() {
    wp_enqueue_script( "upload", plugin_dir_url( __FILE__ ) . 'template/assets/js/jquery-file-upload.min.js', array( 'jquery' ) );
  }
  function datatables_load_scripts() {
    wp_enqueue_script( "datatables", plugin_dir_url( __FILE__ ) . 'template/assets/js/jquery.dataTables.min.js', array( 'jquery' ) );
  }
  function datatables_bootstrap_load_scripts() {
    wp_enqueue_script( "datatables", plugin_dir_url( __FILE__ ) . 'template/assets/js/jquery.dataTables.bootstrap.min.js', array( 'jquery' ) );
  }
  function champlainroofing_maps_add_menu(){   
      if (function_exists('add_options_page')) {
         //add_menu_page
         add_options_page('Champlainroofing maps- General Settings', 'Champlainroofing maps general settings', 8, basename(__FILE__), 'champlainroofing_maps_general_settings');
      }
  }  
  if (function_exists('add_action')) {
    add_action('admin_menu', 'champlainroofing_maps_add_menu');
  }
  add_action( 'wp_enqueue_scripts', 'replace_core_jquery_version' );
  add_action('wp_head', 'maps_load_scripts');
  add_action('admin_head', 'bootstrap_load_scripts');
  add_action('admin_head', 'datatables_load_scripts');
  add_action('admin_head', 'datatables_bootstrap_load_scripts');
  add_action('admin_head', 'upload_load_scripts');
  add_action('admin_head', 'validate_load_scripts');
  add_action('wp_ajax_get_locations', 'get_locations' );     
  add_action('wp_ajax_save_location', 'save_location' );     
  add_action('wp_ajax_nopriv_save_location', 'save_location' );     
  add_action('wp_ajax_delete_location', 'delete_location');
  add_action('wp_ajax_nopriv_delete_location', 'delete_location');
  add_action('wp_ajax_nopriv_get_locations', 'get_locations');
  add_action('wp_ajax_uploadfile', 'uploadfile');
  add_action( 'wp_ajax_nopriv_uploadfile', 'uploadfile' );  
  add_action('activate_champlainroofing_map/champlainroofing_maps.php','mapchamplainroofing_install');
  add_action('deactivate_champlainroofing_map/champlainroofing_maps.php', 'mapchamplainroofing_uninstall');
?>