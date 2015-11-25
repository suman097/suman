<?php $this->load->view('users/include/header.php'); ?>	

<script type = "text/javascript">
    function onclickSuggestFriend() {
        var email = $("#suggest_email").val();
        var category = $("#suggest_category").val();
        var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        var emailvalid = emailReg.test(email);
        if (emailvalid) {
            $.ajax({
                url: "<?php echo base_url('home/ajaxSuggestFriend'); ?>",
                type: "POST",
                data: {
                    category: category,
                    email: email,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
                },
                success: function (data) {
                    alert("Thank you for your suggestion");
//                        bootbox.dialog({
//                            message: '<div class="row" style=" color:#666; font-size:18px; text-align:center;"> ' +
//                                    'Thank you for your suggestion' +
//                                    '</div>',
//                        });
                }
            });
        } else {
            alert("Please enter a valid email");
//            bootbox.dialog({
//                message: '<div class="row" style=" color:#666; font-size:18px; text-align:center;"> ' +
//                        'Please enter a valid email' +
//                        '</div>',
//            });
        }
    }
</script>
<!--inner page content-->    
<div class="inner_page_container">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="profile_page_back" style="padding:15px;">
                    <form action = "<?php echo base_url('home/profileSearch'); ?>" method = "get">
                        <div class="input-group">       
                            <input type="text" class="form-control" name="search" placeholder="Search friend and send request....">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> &nbsp; Search</button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="profile_page_back">
                    <div style="width:100%; float:left; background:url(<?php echo base_url(); ?>assets/frontend/images/banner.jpg) #333 no-repeat center; background-size:cover; padding:180px 15px 15px 15px;">
                        <div class="profile_admin">
                    <?php
                        if(empty($profile->image)){
                    ?>
                            <img style="height:100%;" src="<?php echo base_url(); ?>assets/frontend/images/profile.jpg" alt="">
                    <?php
                        }else{
                    ?>
                            <img style="height:100%;" src="<?php echo base_url(); ?>images/users/<?php echo $friends->image; ?>" alt="">
                    <?php
                        }
                    ?>
                        </div>
                        <br><br><br><br>&nbsp;&nbsp; <font style="color:#ffffff; font-size:23px; margin-top:100px;"><?php echo $friends->name; ?></font>
                    </div>
                </div>
<!--                <div class="profile_page_back">
                    <div class="profile_banner">
                        <div class="profile_admin"></div>
                        <br><br><br><br>&nbsp;&nbsp; <font style="color:#ffffff; font-size:23px; margin-top:100px;"><?php echo $friends->name; ?></font>
                    </div>
                </div>-->
                <?php
                if (!empty($friends_status)) {
                    if ($friends_status->status == 0) {
                        $request_action = "Friend Request Send";
                        $action_target = "not set";
                    } else if($friends_status->status == 1){
                        $request_action = "Friend";
                        $action_target = "not set";
                    } else if($friends_status->status == 2){
                        $request_action = "Rejected";
                        $action_target = "not set";
                    }
                } else {
                    $request_action = "Add Friend";
                    $action_target = $friends_profile_id;
                }
                ?>
                <div>
                    <div class="homepage_postsection">
                        <?php
                        if ($action_target != "not set") {
                            ?>
                            <a href="<?php echo base_url(); ?>home/friendsAction/<?php echo $action_target; ?>" class="btn btn-default pull-right"><?php echo $request_action; ?></a>
                            <?php
                        } else {
                            ?>
                            <a href="" class="btn btn-default pull-right"><?php echo $request_action; ?></a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
                if (!empty($posts)) {
                    foreach ($posts as $post) {
                        ?>
                        <div class="profile_page_back" style="padding:15px;">
                            <div class="profile_block_header">
                                <div class="profile_block_header_thumb"></div>
                                &nbsp;&nbsp; <font style="color:#333; font-size:16px;"><?php echo $post->title; ?></font><br>
                                &nbsp;&nbsp; <font style="color:#999; font-size:12px;">Posted on : <?php echo $post->created_at; ?></font><br>
                                &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $post->description; ?></font><br><br>
                                <font style="color:#333; font-size:14px;">Speciality : <?php echo $post->speciality; ?></font><br>
                            </div>
                            <?php
                            if(!empty($post_contents[$post->id])){
                                foreach ($post_contents[$post->id] as $content) {
                                    if ($content->elements_type == 2) {
                                        ?>
                                        <div class="profile_block_body"><img src="<?php echo base_url(); ?>images/talent/<?php echo $content->elements; ?>" alt=""></div>
                                        <?php
                                    } else if ($content->elements_type == 3) {
                                        ?>
                                        <div class="profile_block_body"><iframe width="100%" height="315" src="<?php echo base_url(); ?>images/talent/<?php echo $content->elements; ?>" frameborder="0" allowfullscreen></iframe></div>
                                        <?php
                                    }
                                }
                            }
                            ?>

                            <div class="profile_block_footer">
                                <p style="border-bottom:1px solid #CCC; padding-bottom:10px;">
                                    <a href="#"><i class="fa fa-thumbs-o-up"></i> Like</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="#collapsexx" data-toggle="collapse" data-target="#collapsexx"><i class="fa fa-comments-o"></i> Comment</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="#"><i class="fa fa-share-square-o"></i> Share</a>
                                </p>

                                <div id="collapsexx" class="panel-collapse collapse" style="margin-top:15px;">
                                    <div style="width:100%; float:left; margin-top:10px;">
                                        <div class="profile_block_header_thumb"></div>
                                        &nbsp;&nbsp; <font style="color:#333; font-size:16px;">Admin name</font><br>
                                        &nbsp;&nbsp; <font style="color:#999; font-size:12px;">Posted on : 1st January 2015</font><br>
                                    </div> 
                                    <div style="width:100%; float:left; margin-top:10px;">
                                        <div class="profile_block_header_thumb"></div>
                                        &nbsp;&nbsp; <font style="color:#333; font-size:16px;">Admin name</font><br>
                                        &nbsp;&nbsp; <font style="color:#999; font-size:12px;">Posted on : 1st January 2015</font><br>
                                    </div>
                                    <div style="width:100%; float:left; margin-top:15px;">
                                        <div class="input-group">
                                            <input type="hidden" name="search_param" value="all" id="search_param">         
                                            <input type="text" class="form-control" name="x" placeholder="Post your comment...">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">Post</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>


            <!-- online friend-->
            <div class="col-sm-4">
                <div class="friend_list_main">
                    <p>All Friends</p>
                    <div class="friend_block_y">
                    <?php
                        if(!empty($friend_list)){
                            foreach($friend_list as $friends){
                                if( $friends_profile_id == $friends->profile_id1 ){
                                    $profile_id = $friends->profile_id2;
                                    $profile_name = $friends->profile_name2;
                                }else{
                                    $profile_id = $friends->profile_id1;
                                    $profile_name = $friends->profile_name1;
                                }
                                $profile_id = ((( $profile_id * 26 ) + 5364 ) - 769 );
                    ?>
                                <div class="particular">
                                    <div class="profile_block_header_thumb"><img height="100%" src="<?php echo base_url(); ?>assets/frontend/images/profile2.jpg" alt=""></div>
                                    &nbsp;&nbsp; <font style="color:#333; font-size:14px;"><a href = "<?php echo base_url('home/talentProfile/'.$profile_id); ?>" ><?php echo $profile_name; ?></a></font><br>
<!--                                &nbsp;&nbsp; <font style="color:#999; font-size:12px;">100 Followers</font>-->
                                </div>
                    <?php
                            }
                        }
                    ?>
                    </div>
                </div>

                <div class="friend_list_main profile_page_back">
                    <p>Suggest a Friend</p>
                    <div class="input-group" style="padding:15px;">
                        Category:
                        <select id="suggest_category" class="form-control">
                            <?php
                            foreach ($categories as $category) {
                                echo "<option value = '" . $category->id . "'>" . $category->category_name . "</option>";
                            }
                            ?>   
                        </select>
                    </div>
                    <div class="input-group" style="padding:15px;">      
                        <input type="email" class="form-control" id="suggest_email" placeholder="Enter mail ID...." required>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick = "return onclickSuggestFriend();">Suggest</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('users/include/footer.php'); ?>