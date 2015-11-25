<?php $this->load->view('users/include/header.php'); ?>	
<script src="<?php echo base_url(); ?>assets/frontend/js/developer.js"></script>
<script type = "text/javascript">
    function onclickSuggestFriend(){
        var email = $("#suggest_email").val();
        var category = $("#suggest_category").val();
        var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        var emailvalid = emailReg.test(email);
        if(emailvalid){
            $.ajax({
                url: "<?php echo base_url('home/ajaxSuggestFriend'); ?>",
                    type: "POST",
                    data: {
                        category: category,
                        email: email,
                        <?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
                    },
                    success: function(data){
                        alert("Thank you for your suggestion");
//                        bootbox.dialog({
//                            message: '<div class="row" style=" color:#666; font-size:18px; text-align:center;"> ' +
//                                    'Thank you for your suggestion' +
//                                    '</div>',
//                        });
                    }
            });
        }else{
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
            <?php
            	if(!empty($search_results)){
                foreach( $search_results as $profile ){
                    $user_id = ((( $profile->id * 26 ) + 5364 ) - 769 );
            ?>
                <div class="profile_page_back" style="padding:15px;">
                    <div class="profile_block_header">
                        <div class="profile_block_header_thumb"></div>
                        &nbsp;&nbsp; <font style="color:#333; font-size:16px;"><a href = "<?php echo base_url('home/talentProfile/'.$user_id); ?>"><?php echo $profile->name; ?></a></font><br>
                        &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $profile->country; ?></font><br>
                    </div>
                </div>
            <?php
                }
              }else{
            ?>
              	<div class="profile_page_back" style="padding:15px;">
                    <div class="profile_block_header">
                        &nbsp;&nbsp; <font style="color:#333; font-size:16px;">No Data Found</font><br>
                    </div>
                </div>
            <?php
              }
            ?>
            </div>


            <!-- online friend-->
            <div class="col-sm-4">
                <div class="friend_list_main">
                    <p>All Friends</p>
                    <div class="friend_block_y">
                        <div class="particular">
                            <div class="profile_block_header_thumb"></div>
                            &nbsp;&nbsp; <font style="color:#333; font-size:14px;">Admin name goes here</font><br>
                            &nbsp;&nbsp; <font style="color:#999; font-size:12px;">100 Followers</font>
                        </div>
                        <div class="particular">
                            <div class="profile_block_header_thumb"></div>
                            &nbsp;&nbsp; <font style="color:#333; font-size:14px;">Admin name goes here</font><br>
                            &nbsp;&nbsp; <font style="color:#999; font-size:12px;">100 Followers</font>
                        </div>
                        <div class="particular">
                            <div class="profile_block_header_thumb"></div>
                            &nbsp;&nbsp; <font style="color:#333; font-size:14px;">Admin name goes here</font><br>
                            &nbsp;&nbsp; <font style="color:#999; font-size:12px;">100 Followers</font>
                        </div>
                        <div class="particular">
                            <div class="profile_block_header_thumb"></div>
                            &nbsp;&nbsp; <font style="color:#333; font-size:14px;">Admin name goes here</font><br>
                            &nbsp;&nbsp; <font style="color:#999; font-size:12px;">100 Followers</font>
                        </div>
                        <div class="particular">
                            <div class="profile_block_header_thumb"></div>
                            &nbsp;&nbsp; <font style="color:#333; font-size:14px;">Admin name goes here</font><br>
                            &nbsp;&nbsp; <font style="color:#999; font-size:12px;">100 Followers</font>
                        </div>
                        <div class="particular">
                            <div class="profile_block_header_thumb"></div>
                            &nbsp;&nbsp; <font style="color:#333; font-size:14px;">Admin name goes here</font><br>
                            &nbsp;&nbsp; <font style="color:#999; font-size:12px;">100 Followers</font>
                        </div>
                        <div class="particular">
                            <div class="profile_block_header_thumb"></div>
                            &nbsp;&nbsp; <font style="color:#333; font-size:14px;">Admin name goes here</font><br>
                            &nbsp;&nbsp; <font style="color:#999; font-size:12px;">100 Followers</font>
                        </div>
                        <div class="particular">
                            <div class="profile_block_header_thumb"></div>
                            &nbsp;&nbsp; <font style="color:#333; font-size:14px;">Admin name goes here</font><br>
                            &nbsp;&nbsp; <font style="color:#999; font-size:12px;">100 Followers</font>
                        </div>
                        <div class="particular">
                            <div class="profile_block_header_thumb"></div>
                            &nbsp;&nbsp; <font style="color:#333; font-size:14px;">Admin name goes here</font><br>
                            &nbsp;&nbsp; <font style="color:#999; font-size:12px;">100 Followers</font>
                        </div>
                    </div>
                </div>

                <div class="friend_list_main profile_page_back">
                    <p>Suggest a Friend</p>
                    <div class="input-group" style="padding:15px;">
                        Category:
                        <select id="suggest_category" class="form-control">
                        <?php
                            foreach( $categories as $category ){
                                echo "<option value = '".$category->id."'>".$category->category_name."</option>";
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