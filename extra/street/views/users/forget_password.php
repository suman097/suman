<?php $this->load->view('users/include/header.php'); ?>

<div class="self_registation">
    <div class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                    <form role="form" method="post" action="" enctype="multipart/form-data">
                        <center>
                            <h2>Please fill your Nickname And Email Address</h2>
                            <h2>We will send your reset password to your email</h2>
                            <?php
                                if(!empty($_GET['error_msg'])){
                                    echo "<h2 style = 'color: red;' >".$_GET['error_msg']."</h2>";
                                }
                            ?>
                        </center>
                        <hr class="colorgraph">

                        <div class="form-group">
                            <input type="text" name="nikname" id="display_name" class="form-control input-lg" placeholder="Nickname" tabindex="3">
                            <?php echo form_error('company', '<span class="req">', '</span>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="text" name="email"  class="form-control input-lg" placeholder="Email Address" tabindex="3">
                        </div>
                        

                        <hr class="colorgraph">
                        <div class="row">
                            <div class="col-xs-12 col-md-6"></div>
                            <div class="col-xs-12 col-md-6"><input type="submit" value="Submit" class="btn btn-success btn-block btn-lg" tabindex="7"></div>
                        </div>
                    </form>
            </div>
        </div>
        
    </div>
    <!-- Modal -->
    <div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">I Agree</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
</div>
<?php $this->load->view('users/include/footer.php'); ?>

