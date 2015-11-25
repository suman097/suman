<?php $this->load->view('users/include/header.php'); ?>
<div class="company_page_main">
	<div class="container" style = "min-height: 550px;">
    	<div class="row">
        	<!-- left row-->
            
			<div class="row">
                        <?php
                            if(empty($details_review)){
                        ?>
                                <div style = "font-size: 30px; padding-left: 14px; color: #48a5da; ">Results not found</div>
                        <?php
                            }
                            if(isset($users_type)){
                        ?>
                                <div class="col-xs-6 col-md-8"><div style = "width: 50%; float: left; padding-top: 16px; color: #48a5da; ">Correct details not found?<br>We will help you call for reviews by simply </div><div style = "width: 40%; float: left;"><a href="<?php echo base_url('home/companyRegister'); ?>" style = "text-decoration: none; "><input type="button" style ="width: 140px; padding: 5px; margin-top: 26px;" value = "Click Here" class="btn btn-success" ></a></div> </div>
                        <?php
                            }else{
                        ?>
                                <div class="col-xs-6 col-md-8"><div style = "width: 50%; float: left; padding-top: 16px; color: #48a5da; ">Correct details not found?<br>We will help you call for reviews by simply </div><div style = "width: 40%; float: left;"><input type="button" style ="width: 140px; padding: 5px; margin-top: 26px;" value = "Click Here" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"></div> </div
                                
                        <?php
                            }
                        ?>
			</div>
        <?php
			if(isset($details_review)){
			foreach($details_review as $details){
		?>
        	<div class="col-sm-8">
            	<div class="row">
                		<div class="company_page_banner_main">
                            <div class="company_page_banner">
                                <div class="company_page_banner_namepanel">
                                    <div class="company_page_banner_namepanel_logo">
                            <?php
                                if($details->company_logo){
							?>
                                    <img src="<?php echo base_url(); ?>images/company/<?php echo $details->company_logo; ?>" alt="">
                            <?php
								}else{
							?>
                            		<img src="<?php echo base_url(); ?>images/icons/no_image.png" alt="">
                            <?php
								}
							?>	
                                    </div>
                                    <div class="company_page_banner_namepaneltext">
                                        <h1><a href="<?php echo base_url('home/companyDetails').'/'.$details->id; ?>"><?php echo $details->company_name; ?></a></h1>
                                        <p><?php echo $details->weblink; ?></p>
                                        <p>
                                <?php
                                    if( !empty( $details->company_city)){ ?>
                                        <?php echo $details->company_city; ?>,
                                <?php
                                    }
                                ?>
                                    <?php echo $details->country; ?></p>
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
                <div class="row mar_top3">
                	<div class="company_page_borderedbox">
                    	<h1>Details about the Company</h1>
                        <p><?php echo $details->company_description; ?></p>
                        <?php
							if($details->count>0){
								$company_rating = floor( $details->total/$details->count);
							}else{
								$company_rating = 0;
							}
						?>
                    	<img src = "<?php echo base_url(); ?>images/icons/rating_<?php echo $company_rating; ?>.png">
						<div class="row">
							<div class="col-xs-12 col-md-8"></div>
							<div class="col-xs-12 col-md-4"><a href="<?php echo base_url('home/companyDetails').'/'.$details->id; ?>" style = "text-decoration: none; "><input type="button" value = "View Comments & Post" class="btn btn-success btn-block btn-lg" ></a></div>
						</div>
                        
                    </div>
                </div> 
                </div>
            <?php
			}
			}
			?>
            <!-- right row -->
            <div class="col-sm-4">
            	
<!--              	<div class="row mar_top3">
                	<div class="col-sm-12">
                                <div class="chat-box-online-div">
                                    <div class="chat-box-online-head">
                                        Online users
                                    </div>
                                    <div class="panel-body chat-box-online forum_chat" id = "forum_chat">
                        <?php
                            if(isset($forum)){
                                $c = 0;
                                foreach($forum as $for){
                                    $c++;
                                    if($c%2 != 0){
                        ?>
                                        <div class="chat-box-online-left">
                                            <a href = "<?php echo base_url('home/userProfile').'/'.$for->nik; ?>"><img src="<?php echo base_url(); ?>images/icons/administrator.png" alt="bootstrap Chat box user image" class="img-circle" />
                                            -  <?php echo $for->nik; ?></a>
                                            <br />
                                            <?php echo $for->content; ?>
                                            <br>
                                            ( <small><?php echo $for->date; ?></small> )
                                        </div>
                                        <hr class="hr-clas-low" />
                        <?php
                                    }else{
                        ?>
                                        <div class="chat-box-online-right">
                                            <a href = "<?php echo base_url('home/userProfile').'/'.$for->nik; ?>"><img src="<?php echo base_url(); ?>images/icons/administrator.png" alt="bootstrap Chat box user image" class="img-circle" />
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
                                        if(isset($users_type)){
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
                </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('users/include/footer.php'); ?>