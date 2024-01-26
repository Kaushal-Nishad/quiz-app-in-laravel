$(function () {
    $('#teacherLogin').validate({
        rules: {
            email:{ required: true },
            password: { required: true }
        },
        messages: {
            email: { required: "Email Address is required" },
            password: { required: "Password is required" }
        },
        submitHandler: function (form) {
            var url = $('meta[name="site_URL"]').attr('content');
            var formdata = new FormData(form);
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        window.location.reload();
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