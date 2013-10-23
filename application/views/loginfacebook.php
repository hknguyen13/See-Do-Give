<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<div class="fb-login-button" onclick="get_login();" scope="email,user_checkins,user_location,publish_stream,user_birthday,offline_access">
        Login with Facebook
</div>

<div id="fb-root"></div>
     <!-- <script src="http://connect.facebook.net/en_US/all.js"></script>-->
      <script>
     
    var fbApiInitialized=false;
   
    window.fbAsyncInit = function() {
        FB.init({
          appId: '437151896301252',
          cookie: true,
          logging: false,
          status:true,
          xfbml: true,
          //session:'SESSION ID',
          oauth: true,
        });
    
};
      (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
          '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());
  

  function get_login(){
          FB.getLoginStatus(function(response) {
          if (response.status === 'connected') {
              //alert(response.status);
            //return false;
              window.location.href="<?php echo base_url().'login/flogin'; ?>";
         }else{
             FB.Event.subscribe('auth.login', function(response) {
         
               FB.api('/me', function(response) {
                window.location.href="<?php echo base_url().'login/flogin'; ?>";
               });
            });
         }
        });     
      }
</script>
</body>
</html>
