<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Create Product Form 
        <small>Preview</small>
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <!-- <h3 class="box-title">Product Detail Fill Here</h3> -->
                    <?php if ($this->session->flashdata('error')) { ?>
                        <div class="alert alert-danger"> <?php echo $this->session->flashdata('error'); ?> </div>
                    <?php } ?>
                </div>
                <form method="post" action="<?php echo base_url('admin/Products/addProduct'); ?>" enctype="multipart/form-data" >
                    <div class="box-body">
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" class="form-control" name="productName" id="productName" placeholder="Product Name">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" name="price" id="price" placeholder="00.00">
                        </div>
                        <div class="form-group">
                            <label for="productImage">Product Image</label>
                            <input type="file" name="productImage" id="productImage">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>    
    $('.alert').fadeOut(3000);    
</script>