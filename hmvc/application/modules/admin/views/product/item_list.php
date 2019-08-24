<?php  $page= $this->uri->segment(4); ?>
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>S.No.</th>
            <th>Product</th>
            <th>Price</th>
            <th colspan="2">Action</th>
            
        </tr>
    </thead>
    <tbody>
        <?php
        if(isset($records)){
            $i=1;
            $index='abs';
            foreach ($records as $value) { ?>
               <tr>
                    <td><?php $index = $pages+$i++; echo $index; ?></td>
                    <td><?php  echo $value->product_name; ?></td>
                    <td><?php  echo $value->price; ?></td>
                    <td>           
                        <a class="btn btn-block btn-info btn-xs" data-toggle="modal" onclick="editClick(this);" data-product_id="<?php echo $value->product_id;?>" data-product_name="<?php echo $value->product_name;?>" data-price="<?php echo $value->price;?>" data-image_name="<?php echo $value->product_image;?>">Edit</a>
                    </td>
                    <td>        
                        <a id="delete" class="btn btn-block btn-danger btn-xs" onclick="deleteClick(this)" data-product_id="<?php echo $value->product_id;?>" data-image_name="<?php echo $value->product_image;?>">Delete</a>
                    </td>
                </tr>                  
        <?php } }  ?>       
    </tbody>
</table>
<div>
   <?php echo $pagination;?>
</div>

<!-- Update Popup Modal for Product detail update -->
<div class="modal" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Profile Info</h5>
         </div>
         <div class="modal-body">
            <div class="status"></div>
            <form id="updateForm" enctype="multipart/form-data">
               <div class="box-body">
                  <div class="form-group">
                     <label for="exampleInputEmail1">Product Name</label>
                     <input class="form-control" name="productName" id="productName" type="text" value="">
                  </div>
                  <div class="form-group">
                     <label for="exampleInputPassword1">Price</label>
                     <input class="form-control" name="price" id="price" type="text" value="">
                  </div>
                  <div class="form-group">
                     <label for="exampleInputFile">Product Image</label>
                     <input type="file" name="productImage" id="productImage">
                     <input type="hidden" name="product_id" id="product_id" value="">
                     <input type="hidden" name="oldImage" id="oldImage" value="">
                     <p class="help-block">Example block-level help text here.</p>
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary"  id="updateItem">Update</button>
         </div>
      </div>
   </div>
</div>
<!-- end Modal -->

<script>
    function deleteClick(e){
        var $ele = $(e).parent().parent();
         swal({
            title: "Are you sure?",
            text: "You want to delete this Menu Item!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel pls!",
            closeOnConfirm: false,
            closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm==true) {
                    $.ajax({
                        url:"<?php echo base_url().'admin/Products/deleteProduct'; ?>",
                        type:'post',
                        data:{'product_id':$(e).data('product_id'),'productImage':$(e).data('image_name')},
                        dataType : "html",
                        success:function(res){
                            if (res){
                               //location.reload(true);
                               $ele.fadeOut().remove();
                               swal("Deleted!", "Menu Item has been Deleted.", "success");
                                //alert(res.status);                
                            }
                        }
                    });
                    
                } else {
                    swal("Cancelled", "Your Menu Item is safe :)", "error");
                }
            });
    }

    function editClick(e){

        $("#updateModal").modal('show');
        var id =$(e).data('product_id');
        var name =$(e).data('product_name');
        var price =$(e).data('price');
        var image_name =$(e).data('image_name');

        $("#product_id").val(id);
        $("#productName").val(name);
        $("#price").val(price);
        $("#oldImage").val(image_name);
    }

    $("#updateItem").click(function(){
        var url1= '<?php echo base_url().'admin/Products/itemList/'.$page; ?>';
        if (typeof FormData !== 'undefined') {
            var formData = new FormData( $("#updateForm")[0] );
        }
        $.ajax({
            url:"<?php  echo base_url().'admin/Products/updateProduct'; ?>",
            type:'post',
            data:formData,
            dataType : "json",
            //async : false,
            cache : false,
            contentType : false,
            processData : false,
            success:function(data){
                
                if (data.status==true){
                    $("#updateModal").modal('hide');
                    swal("Updated!", "Menu Item has been Updated.", "success");
                    ajax_fun(url1);

                }
                else{
                    $('.status').html(data.html);
                    $("#alertproduct").html(data.message);
                    $('#alertproduct').fadeOut(2000);

                }
            }           
        });
    });

</script>