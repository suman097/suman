<?php $this->load->view('users/include/header.php'); ?>
<script type = "text/javascript">
    function clickUpdatePassword(){
        
        var old_password = $("#old_password").val();
        var new_password = $("#new_password").val();
        var retype_password = $("#retype_password").val();
        //alert(new_password);
        //alert(retype_password);
        if( new_password != retype_password ){
            alert("Please retype your password.New password and Retype password not match.");
            return false;
        }else{
            $.ajax({
                url: "<?php echo base_url('home/ajaxUpdatePassword'); ?>",
                        type: "POST",
                        data: {
                        old_password: old_password,
                        new_password: new_password,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
                        },
                        success: function(data){
                            //alert(data);
                            if(data == "password not match"){
                                alert("Old password not match");
                                return false;
                            }else{
                                alert("password change successfully.");
                                self.location = "<?php echo base_url('home/profile'); ?>";
                            }
                        }
                });
        }
    }
    
</script>
<div class="company_page_main">
    <div class="container">
        <div class="row">
            <!-- left row-->
            <div class="col-sm-8">
                <div class="row">
                    <div class="company_page_banner_main">
                        <div class="company_page_banner">
                            <div class="company_page_banner_namepanel">
                                <div class="company_page_banner_namepanel_logo">
                        <?php
                            if(!empty($details->image)){
                        ?>
                                <img src="<?php echo base_url(); ?>images/users/thumb<?php echo $details->image; ?>" style = "height: 100px;" alt="">
                        <?php
                            }else{
                        ?>
                                    <img src="<?php echo base_url(); ?>images/icons/administrator.png" alt="">
                        <?php
                            }
                        ?>

                                </div>
                                <div class="company_page_banner_namepaneltext">
                                    <h1><?php echo $details->nikname; ?></h1>
                                    <p><?php echo $details->email; ?></p>
                                    <p><a href = ""  data-toggle="modal" data-target="#exampleModal23" data-whatever="@mdo">Edit and upload picture</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>         
                <!-- <div class="row" style="border-bottom:1px solid #CCC;">
                     <div class="col-sm-2">
                     <div class="row">
                          <div class="company_pahe_reviews">
                                <a href="#"><h1>5.1k</h1>
                                <p>Reviews</p></a>
                          </div>
                     </div>
                     </div>
                     <div class="col-sm-2">
                     <div class="row">
                          <div class="company_pahe_reviews">
                                <a href="#"><h1>9.6k</h1>
                                <p>Comments</p></a>
                          </div>
                     </div>
                     </div>
                     <div class="col-sm-2">
                     <div class="row">
                          <div class="company_pahe_reviews">
                                <a href="#"><h1>10.7k</h1>
                                <p>Trusts</p></a>
                          </div>
                     </div>
                     </div>
                </div> -->
                <?php
                if (isset($company)) {
                    foreach ($company as $com) {
                        ?>
                        <div class="row mar_top3">
                            <div class="company_page_borderedbox">
                                <h1><a href = "<?php echo base_url('home/companyDetails/').$com->id; ?>"><?php echo $com->company_name; ?></h1>
                                <p><?php echo $com->weblink; ?></p>
                                <p><?php echo $com->company_description; ?></p>
                                <?php
                                if ($company_details[$com->id]->count > 0) {
                                    $comp_rating = floor($company_details[$com->id]->total / $company_details[$com->id]->count);
                                } else {
                                    $comp_rating = 0;
                                }
                                ?>
                                <img src = "<?php echo base_url(); ?>images/icons/rating_<?php echo $comp_rating; ?>.png">
                                <?php
                                $link = ((((($com->id * 99) + 78) * 65) - 49) + 54);
                                ?>
                                <a href = "<?php echo base_url('home/updateCompany/' . $link); ?>" style = "float: right;">Edit</a>
                            </div>
                        </div> 
                        <?php
                    }
                }
                ?>

            </div>
            <!-- right row -->
            <div class="col-sm-4">

                <div class="row mar_top3">
                    <div class="col-sm-12">
                        <div class="chat-box-online-div">
                            <div class="chat-box-online-head">
                                Online users
                            </div>
                            <div class="panel-body chat-box-online forum_chat" id = "forum_chat">
                                <?php
                                if (isset($forum)) {
                                    $c = 0;
                                    foreach ($forum as $for) {
                                        $c++;
                                        if ($c % 2 != 0) {
                                            ?>
                                            <div class="chat-box-online-left">
                                                <a href = "<?php echo base_url('home/userProfile') . '/' . $for->nik; ?>"><img src="<?php echo base_url(); ?>images/icons/administrator.png" alt="bootstrap Chat box user image" class="img-circle" />
                                                    -  <?php echo $for->nik; ?></a>
                                                <br />
                                                <?php echo $for->content; ?>
                                                <br>
                                                ( <small><?php echo $for->date; ?></small> )
                                            </div>
                                            <hr class="hr-clas-low" />
                                            <?php
                                        } else {
                                            ?>
                                            <div class="chat-box-online-right">
                                                <a href = "<?php echo base_url('home/userProfile') . '/' . $for->nik; ?>"><img src="<?php echo base_url(); ?>images/icons/administrator.png" alt="bootstrap Chat box user image" class="img-circle" />
                                                    -  <?php echo $for->nik; ?></a>
                                                <br />
                                                <?php echo $for->content; ?>
                                                <br>
                                                ( <small><?php echo $for->date; ?></small> )
                                            </div>
                                            <hr class="hr-clas-low" />

                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="form_panel"  style="height: 52px;">
                                <?php
                                if (isset($users_type)) {
                                    ?>
                                    <form action = "" method="post" onsubmit = "return submitForumComment('<?php echo $users_nikname; ?>');">
                                        <div style="width:80%; float:left;">
                                            <input type="text" class="form-control" placeholder="write your comment" id = "comment_text">
                                        </div>
                                        <div style="width:20%; float:left;">
                                            <button type="submit" class="btn btn-default">Post</button>
                                        </div>
                                    </form>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
                <br>
                <div class="col-sm-12">
                    <div class="company_page_borderedbox">
                        <font size="3" color="#333333">Some of Popular Companies</font>

                        <?php
                        if ($related_company) {
                            foreach ($related_company as $rel_com) {
                                if ($rel_company_details[$rel_com->id]->count > 0) {
                                    $comp_rating = floor($rel_company_details[$rel_com->id]->total / $rel_company_details[$rel_com->id]->count);
                                } else {
                                    $comp_rating = 0;
                                }
                                ?>
                                <div class="media">
                                    <div class="media-left">
                                        <?php
                                        if ($rel_com->company_logo) {
                                            ?>
                                            <a href="<?php echo base_url('home/companyDetails') . "/" . $rel_com->id; ?>"><img class="media-object"  src="<?php echo base_url(); ?>images/company/<?php echo $rel_com->company_logo; ?>" alt="" height = "50" width = "50"></a>
                                            <?php
                                        } else {
                                            ?>
                                            <a href="<?php echo base_url('home/companyDetails') . "/" . $rel_com->id; ?>"><img class="media-object"  src="<?php echo base_url(); ?>images/icons/no_image.png" alt="" height = "50" width = "50"></a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php echo $rel_com->company_name; ?></h4>
                                        <img src = "<?php echo base_url(); ?>images/icons/rating_<?php echo $comp_rating; ?>.png">
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="exampleModal23" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Update your profile</h4>
            </div>
            <form class="form-signin" method = "post" action = "<?php echo base_url('home/updateProfileInfo'); ?>" enctype="multipart/form-data">
            <div class="modal-body">
                
                    <label for="inputEmail" class="sr-only">Email address</label>
                    Email Address: 
                    <input type="email" id="email" class="form-control" style="margin-top:20px;" name ="mail" value ="<?php echo $details->email; ?>" required autofocus>
                    <span style = "color: #48A5DA;">email wont be shared as per our policy</span>
                    <br><br> &nbsp; &nbsp; 
               <?php
                if(!empty($details->image)){
                    echo '<img src="'.base_url().'images/users/thumb'.$details->image.'" alt="" height = "75" width = "60">';
                }else{
                    echo '<img src="'.base_url().'images/icons/administrator.png" alt="" height = "75" width = "60">';
                }
            ?>
                    <input type="file" name = "image">
                    <br><br>
                    <a href = "" data-toggle="modal" data-target="#exampleModal23456" data-whatever="@mdo" style = "color: #48A5DA;">Edit country preference</a>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" >Update</button>
            </div>
            </form>
            <div class="modal-body">
                <form class="form-signin">
                    <label for="inputPassword" class="sr-only">Old Password</label>
                    <input type="password" id="old_password" style="margin-top:20px;" class="form-control" placeholder="Old Password*" required>
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="new_password" style="margin-top:20px;" class="form-control" placeholder="New Password*" required>
                    <label for="inputPassword" class="sr-only">Confirm Password</label>
                    <input type="password" id="retype_password" style="margin-top:20px;" class="form-control" placeholder="Confirm Password*" required>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onClick="return clickUpdatePassword();">Change Password</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal23456" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Update your profile</h4>
            </div>
            <form class="form-signin" method = "post" action = "<?php echo base_url('home/updateProfileCheck'); ?>" enctype="multipart/form-data">
                <div class="modal-body" style="text-align: justify;">
                    <table>
                        <tr>
                <?php
                    $country_array = explode("," , $details->country);
                    $c = 0;
                    foreach($country as $coun){
                        $c++;
                         
                        echo "<td><input type = 'checkbox' name = 'country[]' value = '".$coun->id."' ";
                        if(in_array($coun->id, $country_array)){
                            echo "checked";
                        }
                        echo " >".$coun->country."</td>";
                    
                        if($c == 3){
                            echo "</tr><tr>";
                            $c = 0;
                        }
                    }
                ?>
                        </tr>
                    </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" >Update</button>
            </div>
            </form>
        </div>
    </div>
</div>


<?php $this->load->view('users/include/footer.php'); ?>