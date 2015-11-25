<?php $this->load->view('users/include/header.php'); ?>	


<!-- banner panel -->
<div class="banner_panel_main">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>Search thousands of talents</h1>
            </div>
        </div>
        <form action = "<?php echo base_url('home/searchTalent'); ?>" method="get">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <div class="input-group">
                    
                    <div class="input-group-btn search-panel">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                            <span id="search_concept">Search by</span>&nbsp;&nbsp; <i class="fa fa-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick = "return onclickSearchCategory('0', 'All');">All</a></li>
                        <?php
                            if(!empty($categories)){
                                foreach($categories as $category){

                        ?>
                            <li><a href="#" onclick = "return onclickSearchCategory('<?php echo $category->id; ?>', '<?php echo $category->category_name; ?>');"><?php echo $category->category_name; ?></a></li>
                        <?php
                                }
                            }
                        ?>
                        </ul>
                        
                    </div>
                    
                    <input type="hidden" id = "search_hidden_category" value = "0" name = "category">  
                    <input type="text" class="form-control" name="search" placeholder="Search talents...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> &nbsp; Search</button>
                    </span>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </form>
    </div>
</div>

<div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="homepage_postsection">
                    <font style="font-size:18px; float:left; text-transform:uppercase; color:#333; margin-top:10px;">Upload and Share your talents</font>
                    <a href="<?php echo base_url('home/postTalent'); ?>" class="btn btn-default pull-right" style="padding:8px 15px; font-size:14px;">Post Your Talent</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- category panel -->
<div class="category_panel_main">
    <div class="container">
        <div class="row">
            <div class="col-sm-12"><h1 class="wow fadeInRight" data-wow-delay="100ms">Select categories below</h1></div>
        </div>
        <!--<div class="row">
                <div class="col-sm-12" style="text-align:center;"><img class="wow fadeInLeft" data-wow-delay="300ms" src="images/line.jpg" alt=""></div>
        </div>-->
        <div class="row" style="margin-top:40px;">
            <div class="col-sm-2"></div>
        <?php
            $i = 1;
            if(!empty($categories)){
                foreach($categories as $category){
                    
        ?>
            
            <div class="col-sm-2 wow fadeInUp" data-wow-delay="100ms">
                <a href="<?php echo base_url('home/searchTalent'); ?>?category=<?php echo $category->id; ?>" style="text-decoration:none;">
                    <div class="thumbnail">
                        <img class="wow zoomIn" src="<?php echo base_url(); ?>assets/frontend/images/icon1.png" alt="">
                        <h2><?php echo $category->category_name; ?></h2>
                    </div>
                </a>
            </div>
        <?php
                    if($i%4 == 0){
                        echo '<div class="col-sm-2"></div>
                            </div>
                            <div class="row" style="margin-top:12px;">
                                <div class="col-sm-2"></div>';
                    }
                    $i++;
                }
            }
        ?>
            <div class="col-sm-2"></div>
        </div>
        
        
    </div>
</div>

<script type="text/javascript">
    function onclickSearchCategory(id, category){
        $("#search_concept").html(category);
        $("#search_hidden_category").val(id);
    }
</script>
<?php $this->load->view('users/include/footer.php'); ?>