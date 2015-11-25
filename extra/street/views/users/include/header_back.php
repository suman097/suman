<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

        <title>Welcome</title>

        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

        <!-- logo -->
        <link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>

        <link href="<?php echo base_url(); ?>assets/frontend/css/bootstrap.css" type="text/css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/frontend/css/style.css" type="text/css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/frontend/css/responsive.css" type="text/css" rel="stylesheet">



        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/demo.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/style3.css" />

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/rating.css" />


        <link href="<?php echo base_url(); ?>assets/frontend/assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLE CSS -->
        <link href="<?php echo base_url(); ?>assets/frontend/assets/css/style.css" rel="stylesheet" />



<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/default.css" />-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/component.css" />
        <script src="<?php echo base_url(); ?>assets/frontend/js/modernizr.custom.js"></script>
        <script type = "text/javascript">
                    function blurCheckNikName(name){
                    //alert(name);
                    $.ajax({
                    url: "<?php echo base_url('home/ajaxCheckNikName'); ?>",
                            type: "POST",
                            data: {
                            name: name,
                                    status: status,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
                            },
                            success: function(data){
                            //alert(data);
                            if (data == "exist"){
                            $("#error_nik_name").html("");
                                    $("#error_nik_name").html("Already taken.");
                            } else if (data == "space"){
                            $("#error_nik_name").html("");
                                    $("#error_nik_name").html("Space not allow in nikname.");
                            } else{
                            $("#error_nik_name").html("");
                            }
                            }
                    });
                            return false;
                    }

            function clickRegister(){
            var name = $("#name").val();
                    var email = $("#email").val();
                    var password = $("#password").val();
                    var cpassword = $("#cpassword").val();
                    var tram = $("#tram").val();
                    var redirect_url = $("#hid_redirect_location").val();
                    //alert("suman");
                    var arr_country = document.register_fom.country_chk.length;
                    var field = document.register_fom.country_chk;
                    //alert(arr_country);
                    var arr_final = "suman";
                    for (i = 0; i < arr_country; i++){
            if (field[i].checked == true){
            if (arr_final == "suman"){
            //alert("1st");
            var arr_final = $("#id_country_" + i).val();
            } else{
            //alert("2nd");
            var arr_final = arr_final + "," + $("#id_country_" + i).val();
            }
            }
            }
            //alert(arr_final);
            if(arr_final != "suman"){
            if (name != "" && password != "" && cpassword != ""){
            if ($("#tram").is(':checked')){
            if (password == cpassword){
            $.ajax({
            url: "<?php echo base_url('home/ajaxCheckNikName'); ?>",
                    type: "POST",
                    data: {
                    name: name,
                            status: status,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
                    },
                    success: function(data){
                    if (data == "exist"){
                    $("#error_nik_name").html("");
                            $("#error_nik_name").html("Already taken.");
                            alert("Please select another Nikname.");
                    } else if (data == "space"){
                    $("#error_nik_name").html("");
                            $("#error_nik_name").html("Space not allow in nikname.");
                            alert("Space not allow in nikname.");
                    } else{
                    $.ajax({
                    url: "<?php echo base_url('home/ajaxRegister'); ?>",
                            type: "POST",
                            data: {
                            name: name,
                                    email: email,
                                    password: password,
                                    country: arr_final,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
                            },
                            success: function(data){

                            $("#name").val("");
                                    $("#email").val("");
                                    $("#password").val("");
                                    $("#cpassword").val("");
                                    alert("Registration Successful");
                                    if (redirect_url != "home"){
                            self.location = "<?php echo base_url('home'); ?>/" + redirect_url;
                            } else{
                            self.location = "<?php echo base_url('home'); ?>";
                            }
                            }
                    });
                            return true;
                    }
                    }
            });
            } else{
            alert("Password not match.");
            }
            } else{
            alert("Please check the terms and coditions.");
            }
            } else{
            alert("Name and Password are required field.");
            }
            }else{
            alert("Please choose atleast one country.");
            }
            }

            function submitForumComment(name){
            var content = $("#comment_text").val();
                    $.ajax({
                    url: "<?php echo base_url('home/ajaxInsertComment'); ?>",
                            type: "POST",
                            data: {
                            content: content,
                                    nik: name,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
                            },
                            success: function(data){
                            //alert(data);
                            $("#comment_text").val("");
                                    $("#forum_chat").html("");
                                    $("#forum_chat").html(data);
                            }
                    });
                    return false;
            }

        </script>
        <!-- Custom styles for this template -->
        <!--  <link href="navbar.css" rel="stylesheet">-->

        <!-- Just for debugging purposes. Don't actually copy this line! -->
        <!--[if lt IE 9]><script src="<?php echo base_url(); ?>assets/frontend/js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>
        
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="<?php echo base_url('home'); ?>"><img src="<?php echo base_url(); ?>assets/frontend/images/logo_small.png" style="margin-top:5px;" alt=""></a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <a href = "<?php echo base_url('home'); ?>"<button type="button" class="btn btn-primary" >Home</button></a>
                        <?php
                        if (isset($users_type)) {
                            ?>		
                            <a href = "<?php echo base_url('home/usersLogout'); ?>"<button type="button" class="btn btn-primary" >Logout</button></a>
                            <?php
                        } else {
                            ?>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Login</button>
                            <?php
                        }
                        if (isset($users_type)) {
                            ?>
                            <a href = "<?php echo base_url('home/profile'); ?>"><button type="button" class="btn btn-primary" data-toggle="modal"  data-whatever="@mdo">Profile</button></a>
                            <?php
                        } else {
                            ?>
                            <!--                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2" data-whatever="@mdo">Register</button>-->
                            <?php
                        }
                        ?>


                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
            
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Please sign in</h4>
                    </div>
                    <?php
                    $server_url = $_SERVER['REQUEST_URI'];
                    $name_array = explode("/", $server_url);
                    $count_url = count($name_array);
                    
                    if ( $count_url >= 3 ) {
                        if($name_array[2] == "reportAbuse"){
                            $url_string = $name_array[2] . "/" . $name_array[3] . "/" . $name_array[4];
                        }else if($count_url == 3){
                            $url_string = $name_array[2];
                        }else{
                            $url_string = $name_array[2] . "/" . $name_array[3];
                        }
                    } else {
                        $url_string = "home";
                    }
                    ?>
                    <div class="modal-body">
                        <form class="form-signin" method = "post" action="<?php echo base_url('home/loginUsers'); ?>">

                            <label for="inputEmail" class="sr-only">Email address</label>
                            <input type="text" id="inputEmail" class="form-control" name = "name" placeholder="Nick Name" >
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input type="password" id="inputPassword" name = "password" style="margin-top:20px;" class="form-control" placeholder="Password">
                            <input type = "hidden" name = "hid_page" value = "<?php echo $url_string; ?>">
                            <br>
                            <h1 ><a href = "<?php echo base_url('home/forgetPassword'); ?>" style = "color: #48a5da;">Forget Password</a> </h1>
                            </div>
                            <div class="modal-footer">

                                <!-- <a href = ""  data-toggle="modal" data-target="#exampleModal2">Register</a>
                               <div class="col-xs-12 col-md-2"><input type="button" value="Post" class="btn btn-success btn-block btn-lg" tabindex="7" data-toggle="modal" data-target="#exampleModal2"></div>-->
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Sign in</button>
                            </div>
                        </form>
                        
                        <h1 style = "color: #48a5da;"> &nbsp; &nbsp; &nbsp; Create account for new users </h1> 
                        <form class="form-signin" name = "register_fom" method = "post" action = "">
                            <div class="modal-body">

                                <label for="inputEmail" >Name</label>
                                <input type="text" id="name" class="form-control" placeholder="Nick Name*" onblur = "return blurCheckNikName(this.value);" >
                                <span id = "error_nik_name" style = "color: red;"></span>
                                <br>
                                <input type = "hidden" id = "hid_redirect_location" value = "<?php echo $url_string; ?>">
                                <label for="inputEmail" >Email address</label>
                                <input type="email" id="email" class="form-control" style="margin-top:20px;" placeholder="Email address" required autofocus>
                                <span style = "color: #48a5da;">email wont be shared as per our policy</span>
                                <br><br>
                                <label for="inputEmail" >Select country priority(mandatory)</label>
                                
<!--                                <div class="form-group" style = "border: 1px solid #cccccc; height: 180px; overflow: auto; border-radius: 5px;" >

                                    <?php
                                    if (isset($country)) {
                                        $count = 0;
                                        foreach ($country as $try) {
                                            echo ' &nbsp; &nbsp; <input type = "checkbox" name = "country_chk" id = "id_country_' . $count . '" value = "' . $try->id . '" ><span style = "color: #666666; "> ' . $try->country . "</span><br>";

                                            $count++;
                                        }
                                    }
                                    ?>
                                    <?php echo form_error('country', '<span class="req">', '</span>'); ?>
                                </div>-->
                                <!--                                <div class="form-group">
                                                                    <label for="inputEmail" >Select country priority</label>( Use ctrl for multi select)
                                                                    <select name = "country[]" id = "country" class="form-control input-lg" placeholder="Country" tabindex="1" multiple>
                                                                        
                                <?php
                                if (isset($country)) {
                                    foreach ($country as $try) {
                                        echo '<option value = "' . $try->id . '" >' . $try->country . '</option>';
                                    }
                                }
                                ?>
                                                                    </select>
                                <?php echo form_error('country', '<span class="req">', '</span>'); ?>
                                                                </div>-->
                                <label for="inputPassword" >Password</label>
                                <input type="password" id="password" style="margin-top:20px;" class="form-control" placeholder="Password*" required>
                                <label for="inputPassword" class="sr-only">Confirm Password</label>
                                <input type="password" id="cpassword" style="margin-top:20px;" class="form-control" placeholder="Confirm Password*" required>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="remember-me" id = "tram"> By clicking this I accept terms &amp; conditions 
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onClick="return clickRegister();">Register</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Please Register</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-signin">

                                <label for="inputEmail" class="sr-only">Name</label>
                                <input type="text" id="name" class="form-control" placeholder="Nik Name*" onblur = "return blurCheckNikName(this.value);" >
                                <span id = "error_nik_name" style = "color: red;"></span>
                                <label for="inputEmail" class="sr-only">Email address</label>
                                <input type="email" id="email" class="form-control" style="margin-top:20px;" placeholder="Email address" required autofocus>
                                email wont be shared as per our policy
                                <label for="inputPassword" class="sr-only">Password</label>
                                <input type="password" id="password" style="margin-top:20px;" class="form-control" placeholder="Password*" required>
                                <label for="inputPassword" class="sr-only">Confirm Password</label>
                                <input type="password" id="cpassword" style="margin-top:20px;" class="form-control" placeholder="Confirm Password*" required>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="remember-me" id = "tram"> By clicking this I accept terms &amp; conditions 
                                    </label>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onClick="return clickRegister();">Register</button>
                        </div>
                    </div>
                </div>
            </div>


