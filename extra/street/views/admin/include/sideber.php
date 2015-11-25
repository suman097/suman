<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
        <?php
			$url = $_SERVER['REQUEST_URI'];
		?>
		<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->        
			<ul class="page-sidebar-menu">
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li>
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<form class="sidebar-search">
						<div class="input-box">
							<a href="javascript:;" class="remove"></a>
							<input type="text" placeholder="Search..." />
							<input type="button" class="submit" value=" " />
						</div>
					</form>
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
                
                <!--start menu for admin-->
                <!--start menu for admin-->
                <!--start menu for admin-->
        <?php
			if($users_type == 1){
		?>
				<li <?php if (strpos($url, "dashboard") !== false){ echo 'class="active"'; } ?>>
                    <a href="<?php echo base_url('dashboard'); ?>">
                        <i class="icon-home"></i> 
                        <span class="title">Dashboard</span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li <?php if (strpos($url, "company") !== false){ echo 'class="active"'; } ?>>
                    <a href="javascript:;">
                        <i class="icon-cogs"></i> 
                        <span class="title">Company </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li >
                            <a href="<?php echo base_url('company'); ?>">
                                Company Register
                            </a>
                        </li>
                        <li >
                            <a href="<?php echo base_url('company/manageCompany'); ?>">
                                Manage Company
                            </a>
                        </li>
                        <li >
                            <a href="<?php echo base_url('company/popularCompany'); ?>">
                                Popular Company
                            </a>
                        </li>
                        <li >
                            <a href="<?php echo base_url('company/manageReview'); ?>">
                                Manage Review
                            </a>
                        </li>
                        <li >
                            <a href="<?php echo base_url('company/manageUsers'); ?>">
                                Users Manage
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li <?php if (strpos($url, "page") !== false){ echo 'class="active"'; } ?>>
                    <a href="javascript:;">
                        <i class="icon-cogs"></i> 
                        <span class="title">Content Management </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li >
                            <a href="<?php echo base_url('page'); ?>">
                                Page Management
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li <?php if (strpos($url, "image") !== false){ echo 'class="active"'; } ?>>
                    <a href="javascript:;">
                        <i class="icon-cogs"></i> 
                        <span class="title">Settings </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li >
                            <a href="<?php echo base_url('image'); ?>">
                                Banner Text
                            </a>
                        </li>
                    </ul>
                </li>
                
                
        <?php
			}
		?>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
		<!-- END SIDEBAR -->