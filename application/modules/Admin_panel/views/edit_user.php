<?php $this->load->view('Admin_panel/head_c');?>
    <div class="wrapper">

        <?php
        $this->load->view('Admin_panel/leftMenu');
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Update User Information
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'Admin/dashboard' ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="<?= base_url() . 'Admin/user' ?>">Add user </a></li>
                    <li><a href="<?= base_url() . 'Admin/edit_user' ?>">Update user </a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="box">
                        <div class="box">
                            <div class="box-body">
                                <form action="<?=base_url()?>Admin_panel/update_user" method="post" enctype="multipart/form-data">
                                  <input type="hidden" name="id" value="<?= $adm->id?>">
                                    <div class="col-xs-12 col-md-12">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="u_name" class="form-control" value="<?= $adm->u_name?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" name="email" class="form-control" value="<?= $adm->email?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" name="password" class="form-control" value="">
                                            </div>
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control">
                                                  <option>Select Status</option>
                                                  <option value="1" <?php if($adm->status==1){echo "Selected";}?>>Active</option>
                                                  <option value="0" <?php if($adm->status==0){echo "Selected";}?>>Deactive</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label></label>
                                                <input type="submit" class="btn btn-primary btn-block" value="Update User">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                        
                  </section>
                  <!-- /.content -->
              </div>

          </div>
          <!-- ./wrapper -->

          <?php $this->load->view('footer_c');?>