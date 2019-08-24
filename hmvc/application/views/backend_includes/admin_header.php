<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>AdminLTE 2 | Starter</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend_assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend_assets/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend_assets/dist/css/skins/skin-blue.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend_assets/custom/sweetalert.css">
        <script src="<?php echo base_url(); ?>backend_assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script src="<?php echo base_url(); ?>backend_assets/custom/sweetalert.js"></script>
        
    </head>
    <!--
        BODY TAG OPTIONS:
        =================
        Apply one or more of the following classes to get the
        desired effect
        |---------------------------------------------------------|
        | SKINS         | skin-blue                               |
        |               | skin-black                              |
        |               | skin-purple                             |
        |               | skin-yellow                             |
        |               | skin-red                                |
        |               | skin-green                              |
        |---------------------------------------------------------|
        |LAYOUT OPTIONS | fixed                                   |
        |               | layout-boxed                            |
        |               | layout-top-nav                          |
        |               | sidebar-collapse                        |
        |               | sidebar-mini                            |
        |---------------------------------------------------------|
        -->
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <a href="index2.html" class="logo">
                    <span class="logo-mini"><b>A</b>LT</span>
                    <span class="logo-lg"><b>Admin</b>LTE</span>
                </a>
                <nav class="navbar navbar-static-top" role="navigation">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->
                                    <img src="<?php echo base_url(); ?>backend_assets/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs">
                                        <?php  echo $this->session->userdata('adminName'); ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="<?php echo base_url(); ?>backend_assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                        <p>
                                            <?php echo $this->session->userdata('adminName');?> - Web Developer
                                            <small>Member since Nov. 2012</small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="col-xs-12 text-center">
                                            <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#centralModalSm">
                                          Change Password
                                        </button>
                                        </div>
                                        
                                       <!--  <div class="col-xs-4 text-center">
                                            <a href="#">Friends</a>
                                        </div> -->
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <!-- <a href="#" class="btn btn-default btn-flat">Profile</a> -->
                                            <button type="button" class="btn btn-default btn-flat" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Profile</button>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?php echo base_url().'admin/logout'; ?>" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <section class="sidebar">
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url(); ?>backend_assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php if($this->session->userdata('loggedIn')==true){ 
                                echo $this->session->userdata('adminName'); }?> </p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form (Optional) -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu">
                        <li class="header">HEADER</li>
                        <li class="active treeview">
                            <a href="#">
                            <i class="fa fa-dashboard"></i> <span>Products</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url("admin/products/showItem"); ?>"><i class="fa fa-circle-o"></i> Show Products</a></li>
                                <li class="active"><a href="<?php echo base_url("admin/products/addProductPage"); ?>"><i class="fa fa-circle-o"></i> Add Products</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                            <i class="fa fa-files-o"></i>
                            <span>Layout Options</span>
                            <span class="label label-primary pull-right">4</span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-circle-o"></i> Top Navigation</a></li>
                                <li><a href=""><i class="fa fa-circle-o"></i> Boxed</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo base_url("admin/products/showItem"); ?>"><i class="fa fa-link"></i> <span>Products</span><small class="label pull-right bg-green">new</small>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                            <i class="fa fa-pie-chart"></i>
                            <span>Charts</span>
                            <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-circle-o"></i> ChartJS</a></li>
                                <li><a href=""><i class="fa fa-circle-o"></i> Morris</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                            <i class="fa fa-laptop"></i>
                            <span>UI Elements</span>
                            <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-circle-o"></i> General</a></li>
                                <li><a href=""><i class="fa fa-circle-o"></i> Icons</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                            <i class="fa fa-edit"></i> <span>Forms</span>
                            <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-circle-o"></i> General Elements</a></li>
                                <li><a href=""><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                            <i class="fa fa-table"></i> <span>Tables</span>
                            <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href=""><i class="fa fa-circle-o"></i> Simple tables</a></li>
                                <li><a href=""><i class="fa fa-circle-o"></i> Data tables</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="">
                            <i class="fa fa-calendar"></i> <span>Calendar</span>
                            <small class="label pull-right bg-red">3</small>
                            </a>
                        </li>
                        <li>
                            <a href="">
                            <i class="fa fa-envelope"></i> <span>Mailbox</span>
                            <small class="label pull-right bg-yellow">12</small>
                            </a>
                        </li>
                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

<!-- Data Model -->
<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title" id="exampleModalLabel">Edit Profile</h2>
                <div class="user-panel">
                    <div class="user-header">
                        <img src="<?php echo base_url(); ?>backend_assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        <p>
                            <?php echo $this->session->userdata('adminName'); ?>
                             - Web Developer
                            <small>Member since Nov. 2012</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="statusMsg"></div>
                <form id="adminForm" enctype="multipart/forn-data">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Change Profile Name:</label>
                        <input type="text" class="form-control" name="profileName" value="<?php echo $this->session->userdata('adminName'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Change Profile Image:</label>
                        <input type="file" name="profileImage">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" id="profileUpdate">
                    Update
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Password Change Central Modal Small -->
<div class="modal" id="centralModalSm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">

    <!-- Change class .modal-sm to change the size of the modal -->
    <div class="modal-dialog modal-sm" role="document">


        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100" id="myModalLabel">Change Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" style="display: none;">
                    <strong>Success!</strong><p id="msg"></p>
                </div>
                <form id="passwordForm" >
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label">  Current Password</label>
                        <div class="col-sm-7">
                            <input type="password" id="password" name="password" class="form-control form-control-sm" placeholder="Current Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label">New Password</label>
                        <div class="col-sm-7">
                            <input type="password" name="newpass" id="newpass" class="form-control form-control-sm" placeholder=" Create New">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-5 col-form-label">Confirm Password</label>
                        <div class="col-sm-7">
                            <input type="password" name="confpass" id="confpass" class="form-control form-control-sm" placeholder="Confirm Password">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary btn-sm" id="changePwd">
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Central Modal Small -->

<script>
    /*----Script for Profile Update..------*/
    $("#profileUpdate").click(function(){
        if (typeof FormData !== 'undefined') {
            var formData = new FormData( $("#adminForm")[0] );
        }
        $.ajax({
            url:"<?php echo base_url().'admin/Dashboard/profileUpdate'; ?>",
            type:'post',
            data:formData,
            dataType : "json",
            async : false,
            cache : false,
            contentType : false,
            processData : false,
            success:function(data){
                $('.statusMsg').html(data.html);
                $("#alert").html(data.message);
                if (data.status==true){
                    alert(data.status);
                    location.reload(true);
                }
            }           
        });
    });/*----end Profile script---*/

    /*----Script for Password Change..------*/
    $("#changePwd").click(function(){
        var pass_regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
        var password = $('#password').val();
        var newpwd = $('#newpass').val();
        var confpwd= $('#confpass').val();

        if(password.length == 0 || newpwd.length == 0 || confpwd.length == 0){
            $('.alert').show();
            /*setTimeout(function() {
            $(".alert").hide();
            }, 3000);*/
            $("#msg").text('All field is required..');
            $("#password").focus();            
        }
        else if(!newpwd.match(pass_regex)){
            $('.alert').show();                
            /*setTimeout(function() {
            $(".alert").hide();
            }, 3000);*/    
            $("#msg").text('New password is not correct..');
            $("#newpass").focus();
            
        }
        else if(newpwd != confpwd){
            $('.alert').show();
            setTimeout(function() {
            $(".alert").hide();
            }, 3000);    
            $("#msg").text('confirm password does not matched..');
            $("#confpass").focus();    
           
        }
        else{
            $.ajax({
                url:"<?php echo base_url().'admin/Dashboard/changePassword'; ?>",
                type:'post',
                data:{'confpass':$("#confpass").val(),'password':$("#password").val()},
                dataType : "json",
                success:function(data){
                    if (data){
                        alert(data.status);
                        //location.reload(true);
                    }
                }           
            });
        }
    });
</script>