<?php $this->load->view('users/include/header.php'); ?>	

<!--inner page content-->    
<!--inner page content-->    
<div class="inner_page_container">
    <div class="container">
        <div class="row">
            <div class="col-sm-2"></div>
            <!-- post talent-->
            <div class="col-sm-8">
                <div class="friend_list_main">
                    <p>Edit Your Profile</p>
                    <div class="post_talent_in">
                        <form action = "<?php echo base_url('home/editProfile'); ?>" method = "post" enctype = "multipart/form-data">
                            <div class="form-group">
                                <label><?php echo $this->session->flashdata('error_upload'); ?></label>
                            </div>
                            
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name = "name" class="form-control" placeholder="" value = "<?php echo $profile->name; ?>">
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <select name="country" class="form-control">
                                    <?php
                                    foreach ($countries as $country) {
                                        if( $profile->country == $country->id ){
                                            echo '<option value = "' . $country->id . '" selected>' . $country->country . '</option>';
                                        }else{
                                            echo '<option value = "' . $country->id . '">' . $country->country . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name = "name" class="form-control" placeholder="" value = "<?php echo $profile->city; ?>">
                            </div>
                            <div class="form-group">
                                <label>Profile picture</label>
                                <br>
                        <?php
                            if(!empty($profile->image)){
                        ?>
                                <img src = "<?php echo base_url(); ?>images/users/<?php echo $profile->image; ?>" >
                        <?php
                            }else{
                        ?>
                                <img style="height:100%;" src="<?php echo base_url(); ?>assets/frontend/images/profile.jpg" alt="">
                        <?php
                            }
                        ?>
                                
                                <input type="file" name = "image"  >
                            </div>
                                        
                                    
                            <div class="form-group">
                                <button type="submit" class="btn btn-default" >Save Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</div>
<?php $this->load->view('users/include/footer.php'); ?>