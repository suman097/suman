
<?php $this->load->view('users/include/header.php'); ?>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/frontend/js/typeahead.min.js"></script>
<script type="text/javascript">
	var jr = $.noConflict();
   jr(document).ready(function(){
   	    		
    	jr('#my-input').typeahead({
        name: 'company',
        // data source
        prefetch: '<?php echo base_url(); ?>company.php',
      // max item numbers list in the dropdown
        limit: 10
      });
    }); 
		function onclickTrust(company, ip) {

		$.ajax({
		url: "<?php echo base_url('home/ajaxCheckIPTrust'); ?>",
						type: "POST",
						data: {
						company: company,
										ip: ip,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
						},
						success: function (data) {
						alert(data);
						}
		});
						return false;
		}



		function clickCountrySelect(country) {
		//alert(country);
		$("#hid_country").val(country);
						var country_name = $("#country_name_" + country).val();
						//alert(country_name);
						$("#selected_country_name").html("");
						$("#selected_country_name").html(country_name);
						//$('#cbp-hrmenu').modal('hide');
						return false;
		}

		function submitCheckCountry(country) {
		var coun = $("#hid_country").val();
						if (coun == "") {
		alert("Please Select Country.");
						return false;
		} else {
		return true;
		}
		}

		function keyupAutoSagetion(search) {
		var country = $("#hid_country").val();
						//alert(country);
						$.ajax({
						url: "<?php echo base_url('home/ajaxAutoSearchCompany'); ?>",
										type: "POST",
										data: {
										key: search,
														country: country,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
										},
										success: function (data) {
										//alert(data);
										$(".auto_sagetion").html(data);
														$(".auto_sagetion").css('display', 'block');
										}
						});
						return false;
		}

		function onclickAutoSagetion(key){
		//alert(key);
		$("#search_company").val();
						$("#search_company").val(key);
						$(".auto_sagetion").css('display', 'none');
						return false;
		}

		function offMsgBox(){
		$(".error_msg_box").css('display', 'none');
		}

 
</script>
<div class="banner_panel_main">
		<div class="container mar_top4">
				<div class="row">
						<div class="col-sm-8">
								<div class="row">
										<?php
										if (!empty($_GET['msg'])) {
												?>
												<div class="alert alert-success error_msg_box" role="alert" >
														<div style = "float: right; cursor: pointer;" onclick = "return offMsgBox();">X</div>
														<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
														<span class="sr-only">Error:</span>
														<?php echo $_GET['msg']; ?>
												</div>
												<?php
										}
										if (!empty($_GET['msg_error'])) {
												?>
												<div class="alert alert-danger error_msg_box" role="alert" >
														<div style = "float: right; cursor: pointer;" onclick = "return offMsgBox();">X</div>
														<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
														<span class="sr-only">Error:</span>
														<?php echo $_GET['msg_error']; ?>
												</div>
												<?php
										}
										?>
										<div class="col-sm-12">
												<div class="logo" >
														<?php echo $details->banner_text; ?>
												</div>
										</div>
								</div>
								<div class="row mar_top3">
										<div class="col-sm-12">
												<nav class="navbar navbar-default" role="navigation">
														<div id="dropdown-thumbnail-preview">
																<form action="<?php echo base_url('home/searchCompany'); ?>" method="post" onSubmit="return submitCheckCountry();">
																		<div class="input-group">
																			<input type="text" name = "search" class="form-control" id ="my-input" placeholder="Which company are you looking for?"  autocomplete="off">
																				<input type="hidden" name = "country" id = "hid_country" value = 2>
																				<span class="input-group-btn">
																						<button type="submit" class="btn btn-default" style="margin-right:-1px;">Search</button>
																				</span>
																		</div>
																</form>
														</div><!-- /.navbar-collapse -->
												</nav>
										</div>
								</div>
								<div class="row">
										<div class="col-sm-12">
												<div class="logo_secend">
														To register new company<br>
														<a href = "<?php echo base_url('home/companyRegister'); ?>"><input type = "button" value = "Register" class="btn btn-success"></a>
												</div>
										</div>
								</div>
						</div>

						<div class="col-sm-4">
								<div class="row">
										<div class="col-sm-12">
												<div class="chat-box-online-div">
														<div class="chat-box-online-head">
																Online users
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
																								<a href = "<?php echo base_url('home/userProfile') . '/' . $for->nik; ?>"> <img src="<?php echo base_url(); ?>images/icons/administrator.png" alt="bootstrap Chat box user image" class="img-circle" />
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
														<div class="form_panel">
																<?php
																if (isset($users_type)) {
																		?>
																		<form action = "" method="post" onsubmit = "return submitForumComment('<?php echo $users_nikname; ?>');">
																				<div class="input-group" style="padding:3px;">
																						<input type="hidden" name="search_param" value="all" id="search_param">         
																						<input type="text" class="form-control" id = "comment_text" placeholder="write your comment">
																						<span class="input-group-btn">
																								<button class="btn btn-default" type="submit">Post</button>
																						</span>
																				</div>
																		</form>
																		<?php
																} else {
																		echo "<div style = 'width: 100%; text-align: center; color: #48a5da;'>Please login to chat</div>";
																}
																?>
														</div>
												</div>
										</div>
								</div>
						</div>
				</div>
				<div class = "auto_sagetion" style="display: none; ">

				</div>


		</div>
</div>

<div class="some_company_main">
		<div class="container">
				<div class="row">
						<div class="col-sm-12">
								<h2>Some of our latest Added Companies</h2>
						</div>
				</div>

				<div class="row mar_top3">
						<div class="col-sm-12">
								<div class="row">

										<?php
										$c = 0;
										foreach ($company_details as $com) {
												$c++;
												if ($c == 7) {
														echo "</div>
				<div class='row'>";
												}
												if ($company_details[$com->id]->count > 0) {
														$comp_rating = floor($company_details[$com->id]->total / $company_details[$com->id]->count);
												} else {
														$comp_rating = 0;
												}
												?>
												<div class="col-sm-2">
														<div class="thumbnail">
																<?php
																if ($com->company_logo) {
																		?>
																		<a href = "<?php echo base_url('home/companyDetails') . "/" . $com->id; ?>"><img src="<?php echo base_url(); ?>images/company/<?php echo $com->company_logo; ?>" alt=""></a>
																		<?php
																} else {
																		?>
																		<a href = "<?php echo base_url('home/companyDetails') . "/" . $com->id; ?>"><img src="<?php echo base_url(); ?>images/icons/no_image.png" alt=""></a>
																		<?php
																}
																?>

																<div class="caption">
																		<h3><a href = "<?php echo base_url('home/companyDetails') . "/" . $com->id; ?>"><?php echo $com->company_name; ?></a></h3>
																		<div class="rating_main">
																				<img src = "<?php echo base_url(); ?>images/icons/rating_<?php echo $comp_rating; ?>.png">
																		</div>
																		<h4><a href=" " onclick = "return onclickTrust('<?php echo $com->id; ?>', '<?php echo $_SERVER["REMOTE_ADDR"]; ?>')"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> <?php echo $com->trust; ?> trust</a></h4>
																</div>
														</div>
												</div>

												<?php
												if ($c >= 12) {
														break;
												}
										}
										?>

								</div>
						</div>
				</div>



				<div class="row mar_top2">
						<div class="col-sm-12" style="text-align:center;">
								<a href = "<?php echo base_url('home/companyListing'); ?>"><button type="button" class="btn btn-default">View More</button></a>
						</div>
				</div>
		</div>
</div>



<div class="about_panel_main">
		<div class="container">
				<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-8">
								<h1>Welcome to our company</h1>
								<p><?php echo $home_about->content; ?></p>
						</div>
						<div class="col-sm-2"></div>
				</div>

				<div class="row mar_top2">
						<div class="col-sm-12" style="text-align:center;">
								<a href="<?php echo base_url('home/content/aboutUs'); ?>"><button type="button" class="btn btn-default">View More</button></a>
								<br><br>
						</div>
				</div>
		</div>
</div>

<?php $this->load->view('users/include/footer.php'); ?>
