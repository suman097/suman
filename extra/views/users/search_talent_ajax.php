
        <?php
            foreach( $results as $result ){
                $user_id = ((( $result->users_id * 26 ) + 5364 ) - 769 );
        ?>
                <div class="profile_page_back" style="padding:15px;">
                    <div class="profile_block_header">
                        <div class="profile_block_header_thumb"></div>
                        &nbsp;&nbsp; <font style="color:#333; font-size:16px;"><a href = "<?php echo base_url('home/talentProfile/'.$user_id); ?>"><?php echo $result->name; ?></a></font><br>
                        &nbsp;&nbsp; <font style="color:#999; font-size:12px;">Category : <?php echo $result->category_name; ?>, <?php echo $result->country; ?>, <?php echo $result->city; ?></font><br>
                    </div>
                </div>
                
        <?php
            }
        ?>
            