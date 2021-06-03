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
           /* fileToUpload:{
              required:true,
              //accept: "image/"
            }*/
          

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
       // var link= { ajax_url : '../wp-admin/admin-ajax.php' }
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
            if(response.success==true){
                jQuery('register-form')[0].reset();
            }
            jQuery('#error').html('<span class="'+response.success+'">'+response.data+'</span>')     

            }
    });
    return false;
  }
      
    /* form submit */

});
 

