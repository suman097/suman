<?php $this->load->view('users/include/header.php'); ?>
<div class="company_page_main">
    <div class="container">
        <div class="row">
            <!-- left row-->
            <div class="col-sm-8">
                <div class="row mar_top3">
                    <div class="company_page_borderedbox">
                        <div class="media">
                            <div>
                                <h4 class="media-heading">Please specify</h4>
                                <form action = "" method = "post">
                                    <div class="form-group">
                                        <textarea class="form-control input-lg" placeholder="Reasons" tabindex="4" name = "reason"></textarea>
                                    </div>
                                    <input type = "hidden" name = "hid_id" value = "<?php echo $report_id; ?>">
                                    <input type = "hidden" name = "hid_company" value = "<?php echo $company_id; ?>">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-10"></div>
                                        <?php
                                        if (isset($users_type)) {
                                            ?>
                                            <div class="col-xs-12 col-md-2"><input type="submit" value="Submit" class="btn btn-success btn-block btn-lg" tabindex="7"></div>
                                            <?php
                                        } else {
                                            ?>
<!--                                            <div class="col-xs-12 col-md-2"><input type="button" value="Post" class="btn btn-success btn-block btn-lg" tabindex="7" onClick="alert('Please login for post review');"></div>-->
                                            <div class="col-xs-12 col-md-2"><input type="button" value="Submit" class="btn btn-success btn-block btn-lg" tabindex="7" data-toggle="modal" data-target="#exampleModal"></div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </form>
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
                <br><br><br><br><br><br><br><br><br><br><br>
                
            </div>
        </div>
    </div>
</div>
</div>
<?php $this->load->view('users/include/footer.php'); ?>