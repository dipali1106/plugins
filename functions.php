<?php
/**
 * Functions
 *
 * @author      dipali
 * @category    Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'wp_ajax_userform_action', 'ajax_userform_action' );
add_action( 'wp_ajax_nopriv_userform_action', 'ajax_userform_action' );

function ajax_userform_action(){

    if (!wp_verify_nonce($_POST['_acf_nonce'], $_POST['action'])) {
      $error = 'Verification error, try again.';
    } else {
      $name = $_POST['user_name'];
      $email = $_POST['user_email'];
      $pwd = $_POST['pwd'];
      $target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
      global $wpdb;
      global $table_prefix;
      $userdata = array(
     'user_login' =>  '$name',
     'user_email'   =>  '$email',
     'user_pass'  =>  $pwd // When creating an user, `user_pass` is expected.
);
      $user_id = wp_insert_user( $userdata ) ;
      if($uploadOk == 1){
        add_user_meta( $user_id, '_user_image', $target_file);

      }
      

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