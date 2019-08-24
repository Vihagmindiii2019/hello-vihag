<?php  $page= $this->uri->segment(4); ?>
   <!-- Content Header (Page header) -->
<section class="content-header">
            <h1>
                Products
                <small>advanced tables</small>
            </h1>
</section>
<!-- Main content -->
<section class="content">
    <!-- Search Product -->
    <div class="row">
        <div class="col-sm-6">
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div>
            <?php } ?>
        </div>
    </div>
    <!-- End Search -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-sm-9"><h3 class="box-title">Product Table</h3></div>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" name="search" id="search" class="form-control input-sm" placeholder="Search...">
                                <span class="input-group-addon"><i class="fa fa-search"></i>
                                </span> 
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" id="ajxData"></div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<script>
    $('.alert').fadeOut(4000);    
    ajax_fun('<?php echo base_url()."admin/Products/itemList/".$page; ?>');

    function ajax_fun(url){
        
        $.ajax({
            url: url,
            type:'post',
            data:{'search':$('#search').val()},
            success:function(data){
                $('#ajxData').html(data);
            /*<?php //if($this->session->userdata('loggedIn')!= true){ ?>
                location.reload(true);
            <?php } ?> */               
            }
        });
    }

    $('#search').keyup(function(){
        ajax_fun('<?php echo base_url()."admin/Products/itemList".$page; ?>');
    });

</script>