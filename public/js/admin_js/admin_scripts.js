

$(document).ready(function(){
    $('#current_pwd').keyup(function(){
        var current_pwd = $('#current_pwd').val();
        //alert(current_pwd);
        $.ajax({
            type:'post',
            url:'/admin/check-current-pwd',
            data:{current_pwd:current_pwd},
            success:function(resp){
                if(resp == "false"){
                    $("#checkCurrentPwd").html("<font color=red>Le mot de passe saisi est incorrect</font>");
                }else if(resp == "true"){
                    $("#checkCurrentPwd").html("<font color=green>Le mot de passe saisi est correct</font>");
                }
            },error:function(){
                alert('Erreur')
            }
        })
    })


    $(".updateSectionStatus").click(function(){
        var status = $(this).text();
        var section_id = $(this).attr('section_id');
        $.ajax({
            type:'post',
            url: '/admin/update-section-status',
            data:{status:status,section_id:section_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#section-"+section_id).html("<a href='javascript:void(0)' class='updateSectionStatus'>Inactif</a>")
                }else if(resp['status']==1){
                    $("#section-"+section_id).html("<a href='javascript:void(0)' class='updateSectionStatus'>Actif</a>")
                }
            },error:function(){
                alert("Erreur")
            }
        })
    })

    $(".updateCategoryStatus").click(function(){
        var status = $(this).text();
        var category_id = $(this).attr('category_id');
        $.ajax({
            type:'post',
            url: '/admin/update-category-status',
            data:{status:status,category_id:category_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#category-"+category_id).html("<a href='javascript:void(0)' class='updateCategoryStatus'>Inactif</a>")
                }else if(resp['status']==1){
                    $("#category-"+category_id).html("<a href='javascript:void(0)' class='updateCategoryStatus'>Actif</a>")
                }
            },error:function(){
                alert("Erreur")
            }
        })
    })

    $(".updateProductStatus").click(function(){
        var status = $(this).text();
        var product_id = $(this).attr('product_id');
        $.ajax({
            type:'post',
            url: '/admin/update-product-status',
            data:{status:status,product_id:product_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#product-"+product_id).html("<a href='javascript:void(0)' class='updateProductStatus'>Inactif</a>")
                }else if(resp['status']==1){
                    $("#product-"+product_id).html("<a href='javascript:void(0)' class='updateProductStatus'>Actif</a>")
                }
            },error:function(){
                alert("Erreur")
            }
        })
    })

    $(".updateAttributeStatus").click(function(){
        var status = $(this).text();
        var attribute_id = $(this).attr('attribute_id');
        $.ajax({
            type:'post',
            url: '/admin/update-attribute-status',
            data:{status:status,attribute_id:attribute_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#attribute-"+attribute_id).html("Inactif")
                }else if(resp['status']==1){
                    $("#attribute-"+attribute_id).html("Actif")
                }
            },error:function(){
                alert("Erreur")
            }
        })
    })

    $(".updateImageStatus").click(function(){
        var status = $(this).text();
        var image_id = $(this).attr('image_id');
        $.ajax({
            type:'post',
            url: '/admin/update-image-status',
            data:{status:status,image_id:image_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#image-"+image_id).html("Inactif")
                }else if(resp['status']==1){
                    $("#image-"+image_id).html("Actif")
                }
            },error:function(){
                alert("Erreur")
            }
        })
    })

    $('#section_id').change(function(){
        var section_id = $(this).val();
        $.ajax({
            type:'post',
            url:'/admin/append-categories-level',
            data:{section_id:section_id},
            success:function(resp){
                $("#appendCategoriesLevel").html(resp)
            },error:function(){
                alert('Erreur');
            }
        })
    })




    $(".updateBannerStatus").click(function(){
        var status = $(this).text();
        var banner_id = $(this).attr('banner_id');
        $.ajax({
            type:'post',
            url: '/admin/update-banner-status',
            data:{status:status,banner_id:banner_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#banner-"+banner_id).html("<a href='javascript:void(0)' class='updateBannerStatus'>Inactif</a>")
                }else if(resp['status']==1){
                    $("#banner-"+banner_id).html("<a href='javascript:void(0)' class='updateBannerStatus'>Actif</a>")
                }
            },error:function(){
                alert("Erreur")
            }
        })
    })

    $(".updateCouponStatus").click(function(){
        var status = $(this).text();
        var coupon_id = $(this).attr('coupon_id');
        $.ajax({
            type:'post',
            url: '/admin/update-coupon-status',
            data:{status:status,coupon_id:coupon_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#coupon-"+coupon_id).html("<a href='javascript:void(0)' class='updateCouponStatus'>Inactif</a>")
                }else if(resp['status']==1){
                    $("#coupon-"+coupon_id).html("<a href='javascript:void(0)' class='updateCouponStatus'>Actif</a>")
                }
            },error:function(){
                alert("Erreur")
            }
        })
    })

    $(".updateShippingStatus").click(function(){
        var status = $(this).text();
        var shipping_id = $(this).attr('shipping_id');
        $.ajax({
            type:'post',
            url: '/admin/update-shipping-status',
            data:{status:status,shipping_id:shipping_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#shipping-"+shipping_id).html("<a href='javascript:void(0)' class='updateShippingStatus'>Inactif</a>")
                }else if(resp['status']==1){
                    $("#shipping-"+shipping_id).html("<a href='javascript:void(0)' class='updateShippingStatus'>Actif</a>")
                }
            },error:function(){
                alert("Erreur")
            }
        })
    })


    $("#manualCoupon").click(function(){
        $("#couponField").show();
    })

    $("#automaticCoupon").click(function(){
        $("#couponField").hide();
    })




    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><input required style="width: 120px; margin: 1px" type="text" name="size[]" value=""/><input required style="width: 120px; margin: 1px" type="text" name="sku[]" value=""/><input required style="width: 120px; margin: 1px" type="text" name="price[]" value=""/><input required style="width: 120px; margin: 1px" type="text" name="stock[]" value=""/><a href="javascript:void(0);" class="remove_button">Supprimer</a></div>'; //New input required field html
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});

$(document).on("click",".confirmDelete", function(){
    var record = $(this).attr("record")
    var recordid = $(this).attr("recordid")
    Swal.fire({
        title: 'Etes-vous sur de vouloir supprimer ceci ?',
        text: "Vous ne pourrez pas revenir en arriere!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, le supprimer!'
      }).then((result) => {
        if (result.value) {
          window.location.href="/admin/delete-"+record+"/"+recordid;
        }
    })
})

$("#courrier_name").hide()
$("#tracking_number").hide()
$("#order_status").on("change", function(){
    if(this.value=="En cours de livraison")
    {
        $("#courrier_name").show()
        $("#tracking_number").show()
    }else{
        $("#courrier_name").hide()
        $("#tracking_number").hide()
    }
})





