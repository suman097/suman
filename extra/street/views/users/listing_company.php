<?php $this->load->view('users/include/header.php'); ?>
<div class="company_page_main">
    <div class="container">
        <div class="row">
            <!-- left row-->
            <?php
            if (isset($details_review)) {
                foreach ($details_review as $details) {
                    ?>
                    <div class="col-sm-8">
                        
                        <div class="row">
                            <div class="company_page_banner_main">
                                <div class="company_page_banner">
                                    <div class="company_page_banner_namepanel">
                                        <div class="company_page_banner_namepanel_logo">
                                            <?php
                                            if ($details->company_logo) {
                                                ?>
                                                <img src="<?php echo base_url(); ?>images/company/<?php echo $details->company_logo; ?>" alt="">
                                                <?php
                                            } else {
                                                ?>
                                                <img src="<?php echo base_url(); ?>images/icons/no_image.png" alt="">
                                                <?php
                                            }
                                            ?>	
                                        </div>
                                        <div class="company_page_banner_namepaneltext">
                                            <h1><a href="<?php echo base_url('home/companyDetails') . '/' . $details->id; ?>"><?php echo $details->company_name; ?></a></h1>
                                            <p><?php echo $details->weblink; ?></p>
                                            <p><?php echo $details->country; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mar_top3">
                            <div class="company_page_borderedbox">
                                <h1>Details about the Company</h1>
                                <p><?php echo $details->company_description; ?></p>
                                <?php
                                if ($details->count > 0) {
                                    $company_rating = floor($details->total / $details->count);
                                } else {
                                    $company_rating = 0;
                                }
                                ?>
                                <img src = "<?php echo base_url(); ?>images/icons/rating_<?php echo $company_rating; ?>.png">
                            </div>
                        </div>
                        <br><br>
<!--                        <div class="row" style="border-bottom:1px solid #CCC;">
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
                         
                    </div>
                    <?php
                }
            } else {
                ?>
                <div style = "height: 600px;">
                    <div style = "font-size: 40px;">No results found</div>
                </div>
                <?php
            }
            ?>
            <div class="col-sm-8">
                <div class="row mar_top3">
                    <div class="company_page_borderedbox">

                        <?php
                        $limit = ceil($total_row / $count);
                        if ($page > 1) {
                            $pre = $page - 1;
                            echo '<a href = "' . base_url('home/companyListing') . '/' . $pre . '"><<</a> &nbsp; &nbsp;';
                        }
                        for ($i = 1; $i <= $limit; $i++) {
                            if ($i == $page) {
                                echo "<span style = 'color: #5bdaff;font-weight: bold;'>" . $i . "</span> &nbsp; &nbsp;";
                            } else {
                                echo '<a href = "' . base_url('home/companyListing') . '/' . $i . '">' . $i . '</a> &nbsp; &nbsp;';
                            }
                        }
                        if ($page < $limit) {
                            $next = $page + 1;
                            echo '<a href = "' . base_url('home/companyListing') . '/' . $next . '">>></a> &nbsp; &nbsp;';
                        }
                        ?>
                    </div>
                </div> 
            </div>
            <!-- right row -->
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="chat-box-online-div">
                            <div class="chat-box-online-head">
                                ONLINE USERS Comments
                            </div>
                            <div class="panel-body chat-box-online" id = "forum_chat">
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
            </div>
        </div>




    </div>
</div>
</div>
<?php $this->load->view('users/include/footer.php'); ?>