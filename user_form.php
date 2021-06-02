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
    <button type="submit" class="btn btn-default" name="btn-save" id="btn-submit">
<span class="glyphicon glyphicon-log-in"></span>   Create Account
</button> 
</div>
  </form>
  <script>
    jQuery('document').ready(function($)
{
    
    /* validation */
    $("#register-form").validate({
        rules:
        {
            user_name: {
                required: true,
                minlength: 3
            },
            pwd: {
                required: true,
                minlength: 8,
                maxlength: 25
            },
            cpwd: {
                required: true,
                equalTo: '#pwd'
            },
            user_email: {
                required: true,
                email: true
            },
            fileToUpload:{
              required:true,
              //accept: "image/"
            }
          

        },
        messages:
        {
            user_name: "Enter Your Full name",
            pwd:{
                required: "Provide a Password",
                minlength: "Password Needs To Be Minimum of 8 Characters"
            },
            user_email: "Enter a Valid Email",

            cpwd:{
                required: "Retype Your Password",
                equalTo: "Password Mismatch! Retype"
            }

        },
        submitHandler: submitForm
    });
    /* validation */

    /* form submit */
    function submitForm()
    {
       
        var data = $("#register-form").serialize();
        var formData=new FormData;
       // var link= { ajax_url : '../../wp-admin/admin-ajax.php' }
        formData.append('action','userform_action');
        formData.append('userform_action',data);
        $.ajax({

            type : 'POST',
            url  : ajax_object.ajax_url,
            data : formData,
            processData:false,
            contentType:false,
            beforeSend: function()
            {
                $("#error").fadeOut();
                $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span>   sending ...');
            },
            success :  function(response) { 
            alert(response);   

            }
    });
    return false;
  }
      
    /* form submit */

});
 

  </script>
<?php 

 
 add_action( 'wp_ajax_userform_action', 'ajax_userform_action' );
add_action( 'wp_ajax_nopriv_userform_action', 'ajax_userform_action' );

function ajax_userform_action(){

    /*if (!wp_verify_nonce($_POST['_acf_nonce'], $_POST['action'])) {
      $error = 'Verification error, try again.';
    } else {*/
      $name = $_POST['user_name'];
      $email = $_POST['user_email'];
      $pwd = $_POST['pwd'];
      global $wpdb;
      $userdata = array(
    'user_login' =>  '$name',
    'user_email'   =>  '$email',
    'user_pass'  =>  $pwd // When creating an user, `user_pass` is expected.
);
      $user_id = wp_insert_user( $userdata ) ;
 
        // On success.
        if ( ! is_wp_error( $user_id ) ) {
            echo "User created : ". $user_id;
            wp_send_json_success("Data Inserted");
        }
        else{
          wp_send_json_success("Try again");

        }
              
     
     
    }
  }

?>

