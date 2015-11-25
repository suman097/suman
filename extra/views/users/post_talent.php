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
                    <p>Post Talent</p>
                    <div class="post_talent_in">
                        <form action = "<?php echo base_url('home/postTalent'); ?>" method = "post" enctype = "multipart/form-data">
                            <div class="form-group">
                                <label><?php echo $this->session->flashdata('error_upload'); ?></label>
                            </div>
                            <div class="form-group">
                                <label>Post category</label>
                                <select name="category" class="form-control">
                                    <?php
                                    foreach ($categories as $category) {
                                        echo '<option value = "' . $category->id . '">' . $category->category_name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Post Title</label>
                                <input type="text" name = "title" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" style="height:150px; resize:none;" cols="" rows=""></textarea>
                            </div>
                            <div class="form-group">
                                <label>Speciality</label>
                                <input type="text" name = "speciality" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <select name="country" class="form-control">
                                    <?php
                                    foreach ($countries as $country) {
                                        echo '<option value = "' . $country->id . '">' . $country->country . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name ="city" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Upload Picture</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <span class="btn btn-info btn-block btn-file">
                                            Browse photo <input type="file" name = "photo1">
                                        </span>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="btn btn-info btn-block btn-file">
                                            Browse photo <input type="file" name = "photo2">
                                        </span>
                                    </div>
                                    <div class="col-sm-4">
                                        <span class="btn btn-info btn-block btn-file">
                                            Browse photo <input type="file" name = "photo3">
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Upload Video</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <span class="btn btn-warning btn-block btn-file">
                                            Browse video <input type="file" name = "video">
                                        </span>
                                    </div>
                                </div>
                            </div>
                                        
                                    
                            <div class="form-group">
                                <button type="submit" class="btn btn-default" name = "SUB">Post Your Talent</button>
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