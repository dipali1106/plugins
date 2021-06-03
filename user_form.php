<?php
/*
    Plugin Name: user_form
    Plugin URI: 
    Author: dipali
    Version: 1.0
    Author URI: http://xyz.com
    text-domain:rest
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;// Exit if accessed directly 
}
function userform_add_script() {

  wp_enqueue_script('custom-js',plugin_dir_url( __FILE__ ) .'/assets/js/custom.js',array('jquery'));
  wp_enqueue_script('jQuery-validate','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js',array('jquery'));
   wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
  
  wp_localize_script( 'userform-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

  
}
add_action('wp_enqueue_scripts', 'userform_add_script');

add_shortcode('user-form','callback_function_two');
function callback_function_two($atts,$content=null){

 
  
  //wp_enqueue_style( 'style1-css', plugin_dir_url( __FILE__ ) .'/css/style1.css' );
?>

<form id="register-form" class="signup-form" method="post" enctype="multipart/form-data">
      <h2 Class="form-heading" >User Signup form</h2>
    <div  id="error">
  
  </div>
    <div class="form-group">
      
      <input type="text" class="form-control" id="user_name" placeholder="Enter Your Full name" name="user_name">
    </div>
    <div class="form-group">
      <input type="email" class="form-control" id="user_email" placeholder="Enter email" name="user_email">
    </div>
    <div class="form-group">
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
    </div>
    <div class="form-group" >
      <input type="password" class="form-control" id="cpwd" placeholder="Confirm password" name="cpwd">
     
    </div>
    <div class="form-group" >
      <label >Upload image</label>
    <input type="file" name="fileToUpload" id="fileToUpload">
  </div>
    <div class="form-group">
      <input type="hidden" name="action" value="userform_action" />
      <?php wp_nonce_field('userform_action', '_acf_nonce', true, false) ?>

        <input type="hidden" name="action" value="userform_action" />
    <button type="submit" class="btn btn-default" name="btn-save" id="btn-submit">
<span class="glyphicon glyphicon-log-in"></span>   Create Account
</button> 
</div>
  </form>
  
<?php 

 
 
  }
  ?>
