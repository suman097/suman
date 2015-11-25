<?php $this->load->view('users/include/header.php'); ?>
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
                                    <!--<p><?php echo $details->email; ?></p>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>         
                <!--                <div class="row" style="border-bottom:1px solid #CCC;">
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
                                </div>-->


                <div class="row mar_top3">
                    <div class="company_page_borderedbox">
                        <div class="media">
                            <div>
                                
                                <?php
                                if (isset($users_type)) {
                                    ?>
                                    <h4 class="media-heading">Message To Email</h4>
                                    <form action = "<?php echo base_url('home/mailToUsers'); ?>" method = "post">
                                        <div class="form-group">
                                            <input type="hidden" name="title" id="display_name" class="form-control input-lg" value = "Message from user" tabindex="5" style="width: 100%;">
                                            <input type="hidden" name = "email" value = "<?php echo $details->email; ?>">
                                            <input type="hidden" name = "hid_profile" value = "<?php echo $nik_name_user; ?>">
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control input-lg" placeholder="Message" tabindex="4" name = "review"></textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12 col-md-10"></div>
                                            <div class="col-xs-12 col-md-2"><input type="submit" value="Mail" class="btn btn-success btn-block btn-lg" tabindex="7"></div>
                                        </div>
                                    </form>
                                    <?php
                                } else {
                                    echo "Please Login to message";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

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
<?php $this->load->view('users/include/footer.php'); ?>