$(function () {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    $('#studentLogin').validate({
        rules: {
            email: { required: true },
            password: { required: true }
        },
        messages: {
            email: { required: "email is required" },
            password: { required: "Password is required" }
        },
        submitHandler: function (form) {
            var url = $('meta[name="site_URL"]').attr('content');
            var formdata = new FormData(form); 
            $.ajax({
                url: url + "/student/student-login",
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
                            window.location.reload();
                        },1000);
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