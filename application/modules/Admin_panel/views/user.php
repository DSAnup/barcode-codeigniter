<?php $this->load->view('head_c');?>
    <div class="wrapper">

        <?php
        $this->load->view('leftMenu');
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Add New User
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'Admin_panel/dashboard' ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="<?= base_url() . 'Admin_panel/user' ?>">Add user </a></li>
                    
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="box">
                        <div class="box">
                            <div class="box-body">
                                <form action="<?=base_url()?>Admin_panel/add_user" method="post" enctype="multipart/form-data">
                                    <div class="col-xs-12 col-md-12">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="u_name" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" name="email" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="text" name="password" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control">
                                                  <option>Select Status</option>
                                                  <option value="1">Active</option>
                                                  <option value="0">Deactive</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label></label>
                                                <input type="submit" class="btn btn-primary btn-block" value="Add User">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                        <div class="row" style="padding: 5px">
                            <div class="box">
                                <div class="box">
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="col-md-12" style="color: #79a0e0">
                                            <h3>User List</h3>
                                        </div>
                                        <table id="example1" class="table table-bordered table-striped" border="1">
                                            <thead style="background-color: #79a0e0">
                                                <tr>
                                                    <th width="5%">SL</th>
                                                    <th width="20%">Name</th>
                                                    <th width="35%">Email</th>
                                                    <th width="25%">Status</th>
                                                    <th width="15%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="itembody">
                                              <?php $i=0; foreach ($adm as $s) {?>
                                                <tr>
                                                  <td><?= ++$i;?></td>
                                                  <td><?= $s->u_name;?></td>
                                                  <td><?= $s->email;?></td>
                                                  <td><?php if($s->status==1){echo "Active";}else{echo "Deactive";} ;?></td>
                                                  <td><a href="<?=base_url().'Admin_panel/edit_user/'.$s->id?>">Edit |<a href="<?=base_url().'Admin_panel/delete_user/'.$s->id?>" onclick="return confirm('are you sure?')" style="color:red">Delete</a></td>
                                              </tr>
                                              <?php } ?>
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </section>
                  <!-- /.content -->
              </div>

          </div>
          <!-- ./wrapper -->

          <?php $this->load->view('footer_c');?>