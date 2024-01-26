$(function () {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000
    });
    
    $('#adminLogin').validate({
        rules: {
            admin: { required: true },
            password: { required: true }
        },
        messages: {
            admin: { required: "Username is required" },
            password: { required: "Password is required" }
        },
        submitHandler: function (form) {
            $('.error').remove();
            var url = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url+'/',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Logged In Succesfully.'
                        });
                        setTimeout(function(){
                            window.location.href = url + '/admin/dashboard';
                        },1500);
                    } else {
                        $.each(dataResult, function (i, error) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + error + '</span>'));
                        });
                    } 
                }
            });
        }
    });

});