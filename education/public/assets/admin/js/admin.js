$(document).ready(function() {

    $('.add-new-class').click(function(e) {
        var newClassName = $('#new_class_name');

        if(newClassName.val() != '') {
            newClassName.css('border-color', '');

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: '/classes',
                data: {
                    'class_name': newClassName.val(),
                },
                success: function(returnedData) {
                    if(returnedData.success) {
                        window.location.reload();
                    }else {
                        alert("There's some problem with the request.");
                    }
                }
            });
        }else{
            newClassName.css('border-color', 'red');
            return false;
        }
    });



    $('.show-devies').click(function (e){

            //Send request
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: '/price-alert',
                data: {'pid':productId,'alert':priceAlertSwitchState},
                success: function (returnedData) {
                    if (returnedData.success) {
                        //Success
                    } else {
                        //$('#product-price-alert-message-container').html('<div class="alert alert-danger">There\'s some problem with the request.</div>');
                    }
                },
                error: function (returnedData) {

                    //If authorized request
                    if(returnedData.status == 403){
                        //priceAlertSwitch.checked = false;
                        $('#login-register').modal('show');
                    }else{
                        $('#product-price-alert-message-container').html('<div class="alert alert-danger">There\'s some problem with the request.</div>');
                    }
                }
            });
        }
    );

});