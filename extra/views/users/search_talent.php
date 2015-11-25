<?php $this->load->view('users/include/header.php'); ?>	
<script type = "text/javascript">
    function onclickAjaxSearchTalent(){
        var country = $("#country").val();
        var city = $("#city").val();
        var category = $("#category").val();
        $.ajax({
            url: "<?php echo base_url('home/onclickAjaxSearchTalent'); ?>",
                type: "POST",
                data: {
                    country: country,
                    city: city,
                    category: category,
                    <?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
                },
                success: function(data){
                    if( data == "no data" ){
                        $("#ajax_search_result").html("No data found");
                    }else{
                        $("#ajax_search_result").html(data);
                    }
                }
        });
        
    }
</script>
<!--inner page content-->    
<div class="inner_page_container">
    <div class="container">
        <div class="row">
            <div class="col-sm-8" id = "ajax_search_result">
                
        <?php
            foreach( $results as $result ){
                $user_id = ((( $result->users_id * 26 ) + 5364 ) - 769 );
        ?>
                <div class="profile_page_back" style="padding:15px;">
                    <div class="profile_block_header">
                        <div class="profile_block_header_thumb"></div>
                        &nbsp;&nbsp; <font style="color:#333; font-size:16px;"><a href = "<?php echo base_url('home/talentProfile/'.$user_id); ?>"><?php echo $result->title; ?></a></font> &nbsp; &nbsp; &nbsp; &nbsp; By <?php echo $result->name; ?><br>
                        &nbsp;&nbsp; <font style="color:#999; font-size:12px;">Category : <?php echo $result->category_name; ?>, <?php echo $result->country; ?>, <?php echo $result->city; ?></font><br>
                    </div>
                </div>
                
        <?php
            }
        ?>
            </div>
            <!-- online friend-->
            <div class="col-sm-4">
                

                <div class="friend_list_main profile_page_back">
                    <p>Search By</p>
                    <div class="input-group" style="padding:15px;">
                        Country:
                        <select id="country" class="form-control">
                        <?php
                            foreach( $countries as $country ){
                                echo "<option value = '".$country->id."'>".$country->country."</option>";
                            }
                        ?>   
                        </select>
                        <input type = "hidden" name = "search_category" id = "category" value = "<?php echo $searching_category; ?>">
                    </div>
                    <div class="input-group" style="padding:15px;">      
                        <input type="text" class="form-control" id="city" placeholder="City" required>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick = "return onclickAjaxSearchTalent();">Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('users/include/footer.php'); ?>