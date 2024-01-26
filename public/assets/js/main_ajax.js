$(function () {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.modal').on('hidden.bs.modal', function () {
        $('.modal form')[0].reset();
    });

    //get url from browser
    var origin = window.location.origin;
    var path = window.location.pathname.split( '/' );
    // var URL = origin+'/'+path[1]+'/';
    var URL = $('#url').val();
    // var uRL = origin+'/'+path[1]+'/';

    //alert plugin
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });


    // delete data common function
    function destroy_data(name, url) {
        var el = name;
        var id = el.attr('data-id');
        var dltUrl = url + id;
        if (confirm('Are you Sure Want to Delete This')) {
            $.ajax({
                url: dltUrl,
                type: "DELETE",
                cache: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        el.parent().parent('tr').remove();
                        Toast.fire({
                            icon: 'success',
                            title: 'Deleted Successfully'
                        });
                    }else{
                        Toast.fire({
                            icon: 'danger',
                            title: dataResult
                        });
                    }
                }
            });
        }
    }

    //show input error with ajax
    function show_formAjax_error(data){
        if (data.status == 422) {
            $('.error').remove();
            $.each(data.responseJSON.errors, function (i, error) {
                var el = $(document).find('[name="' + i + '"]');
                el.after($('<span class="error">' + error[0] + '</span>'));
            });
        }
    }

    // ========================================
    // script for Admin Logout
    // ========================================

    $('.admin-logout').click(function () {
        $.ajax({
            url: URL + '/admin/logout',
            type: "GET",
            cache: false,
            success: function (dataResult) {
                if (dataResult == '1') {
                    window.location.reload();
                    Toast.fire({
                        icon: 'success',
                        title: 'Logged Out Successfully.'
                    });
                }
            }
        });
    })



// ========================================
// script for Teachers module
// ========================================

        //add new teacher

    $('#addTeacher').validate({
        rules: {
            teacher_name: { required: true },
            registration: { required: true,digits:true },
            designation: { required: true },
            dob: { required: true },
            gender: { required: true },
            phone: { required: true,digits:true },
            address: { required: true },
            joining_date: { required: true },
            email: { required: true,email:true },
            password: { required: true },
        },
        messages: {
            teacher_name: { required: "Name is Required" },
            registration: { required: "Regsitration Number is Required" },
            designation: { required: "Select Designation" },
            dob: { required: "Date Of Birth is Required" }, 
            gender: { required: "Select Gender" },
            phone: { required: "Phone Number is Required" },
            address: { required: "Address is Required" },
            joining_date: { required: "Please Select Joining Date" }, 
            email: { required: "Email address is Required" },
            password: { required: "Password is Required" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: URL+'/admin/teachers',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Successfully.'
                        });
                        setTimeout(function(){
                            window.location.href = URL+'/admin/teachers';
                        },2000);
                    }
                },
                error: function (data) {
                    show_formAjax_error(data)
                }
            });
        }
    });

    //Update teacher

    $('#updateTeacher').validate({
        rules: {
            teacher_name: { required: true },
            designation: { required: true },
            dob: { required: true },
            gender: { required: true },
            phone: { required: true,digits:true },
            address: { required: true },
            joining_date: { required: true },
            email: { required: true,email:true },
        },
        messages: {
            teacher_name: { required: "Name is Required" },
            registration: { required: "Regsitration Number is Required" },
            designation: { required: "Select Designation" },
            dob: { required: "Date Of Birth is Required" }, 
            gender: { required: "Select Gender" },
            phone: { required: "Phone Number is Required" },
            address: { required: "Address is Required" },
            joining_date: { required: "Please Select Joining Date" }, 
            email: { required: "Email address is Required" },
            status: { required: "Select Status" },
        },

        submitHandler: function (form) {
            var formdata = new FormData(form);
            var url = window.location.href;
            var s_url = url.split('/');
            s_url.pop();
            var nUrl = s_url.join('/');
            $.ajax({
                url: nUrl,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Successfully.'
                        });
                        setTimeout(function(){
                            s_url.pop();
                            var rUrl = s_url.join('/');
                            window.location.href = rUrl;
                        },2000);
                    }
                },
                error: function (data) {
                    show_formAjax_error(data);
                }
            });
        }
    });

    //  delete teacher
    $(document).on("click", ".delete-teacher", function() {
        destroy_data($(this), window.location.href+'/');
    });

// ========================================
// script for Students module
// ========================================
    // add new student
    $('#addStudent').validate({
        rules: {
            student_name: { required: true },
            father_name: { required: true },
            dob: { required: true },
            gender: { required: true },
            phone: { required: true,digits:true },
            address: { required: true },
            register_no: { required: true },
            subjects: { required: true },
            email: { required: true,email:true },
            password: { required: true },
        },
        messages: {
            register_no: { required: "Please Enter Register Number" },
            student_name: { required: "Please Enter Student Name" },
            father_name: { required: "Please Enter Father Name" },
            dob: { required: "Please Select Date Of Birth" },
            gender: { required: "Please Select Gender" },
            phone: { required: "Please Enter Phone Number" },
            address: { required: "Please Enter Student address" },
            subjects: { required: "Please Select Subject Name" },
            email: { required: "Please Enter Email address" },
            password: { required: "Please Enter Password" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: URL+'/admin/students',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult){
                    if (dataResult == '1'){
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Successfully.'
                        });
                        setTimeout(function(){
                            window.location.href = URL + '/admin/students';
                        },2000);
                        
                    }
                },
                error: function (data) {
                    show_formAjax_error(data);
                }
            });
        }
    });

    // update student
    $('#updateStudent').validate({
        rules: {
            student_name: { required: true },
            father_name: { required: true },
            dob: { required: true },
            gender: { required: true },
            phone: { required: true },
            address: { required: true },
            subjects: { required: true },
            email: { required: true },
            status: { required: true },
        },
        messages: {
            student_name: { required: "Please Enter Student Name" },
            father_name: { required: "Please Enter Father Name" },
            dob: { required: "Please Enter Date Of Birth" },
            gender: { required: "Please Select Gender" },
            phone: { required: "Please Enter Phone Number" },
            address: { required: "Please Enter address" },
            subjects: { required: "Please Select Subject Name" },
            email: { required: "Please Enter Email address" },
            status: { required: "Please Select Status" },
        },
        submitHandler: function (form) {
            var url = window.location.href;
            var s_url = url.split('/');
            s_url.pop();
            var nUrl = s_url.join('/');
            var formdata = new FormData(form);
            $.ajax({
                url: nUrl,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Successfully.'
                        });
                        setTimeout(function(){
                            s_url.pop();
                            var rUrl = s_url.join('/');
                            window.location.href = rUrl;
                        },2000);
                    }
                },
                error: function (data) {
                    show_formAjax_error(data);
                }
            });
        }
    });

    //delete student
    $(document).on("click", ".delete-student", function() {
        destroy_data($(this), 'students/');
    });


// ========================================
// script for Subjects module
// ========================================


    //add new subject
    $('#add_subject').validate({
        rules: {
            sub_name: { required: true }
        },
        messages: {
            sub_name: { required: "Please Enter Subject Name" }
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Successfully.'
                        });
                        setTimeout(function(){
                            $('#modal-default').modal('hide');
                            window.location.reload();
                        },2000);
                    }
                },
                error: function (data) {
                    show_formAjax_error(data);
                }
            });
        }
    });

    //fill subject detail in modal for edit
    $(document).on('click', '.edit_subject', function() {
        var id = $(this).attr('data-id');
        var dltUrl = window.location.href+'/'+ id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult[0].subject_id);
                $('#modal-info input[name=sub_name]').val(dataResult[0].subject_name);
                $('#modal-info').modal('show');
            }
        });
    });

    // update subject
    $("#edit_subject").validate({
        rules: { sub_name: { required: true } },
        messages: { sub_name: { required: "Please Enter Subject Name" } },

        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: window.location.href+'/'+$('input[name=id]').val(),
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Successfully.'
                        });
                        setTimeout(function(){
                            $('#modal-info').modal('hide');
                            window.location.reload();
                        },2000);
                    }
                },
                error: function (data) {
                    show_formAjax_error(data);
                }
            });
        }
    });

    //delete subject
    $(document).on("click", ".delete-subject", function() {
        destroy_data($(this), window.location.href+'/')
    });

// ========================================
// script for General Setting module
// ========================================
    //update general settings
    $('#updateGeneralSetting').validate({
        rules: {
            site_name: { required: true },
            site_title: { required: true },
            email: { required: true },
            phone: { required: true },
            footer: { required: true },
        },
        messages: {
            site_name: { required: "Site Name is Required" }, 
            site_title: { required: "Site Title is Required" },
            email: { required: "Site Email is Required" },
            phone: { required: "Site Phone is Required" },
            footer: { required: "Footer Copyright Text is Required" }
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    setTimeout(function () {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Successfully.'
                        });
                        window.location.reload();
                    }, 1000);
                },
                error: function (data) {
                    show_formAjax_error(data);
                }
            });
        }
    });
    //update profile settings
    $('#updateProfile').validate({
        rules: {
            admin_name: { required: true },
            username: { required: true },
            email: { required: true },
        },
        messages: {
            admin_name: { required: "Admin Name is Required" }, 
            username: { required: "Username is Required" },
            email: { required: "Email is Required" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    setTimeout(function () {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Successfully.'
                        });
                        window.location.reload();
                    }, 1000);
                },
                error: function (data) {
                    show_formAjax_error(data);
                }
            });
        }
    });
    //change password
    $('#changePassword').validate({
        rules: {
            old_password: { required: true },
            new_password: { required: true },
            con_password: { required: true,equalTo:"#password" },
        },
        messages: {
            old_password: { required: "Old Password is Required" }, 
            new_password: { required: "New Password is Required" },
            com_password: { required: "Confirm New Password is Required" },
        },
        submitHandler: function (form) {
            $('.error').remove();
            var formdata = new FormData(form);
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if(dataResult == '1'){
                        $('<div class="alert alert-success">Password Updated Successfully. Now Login With New Password.</div>').insertAfter($('.update-pass'));
                        setTimeout(function () {
                            Toast.fire({
                                icon: 'success',
                                title: 'Updated Successfully.'
                            });
                            window.location.reload();
                        }, 1500);
                    }else{
                        $.each(dataResult, function (i) {
                            var el = $(document).find('[name="' + i + '"]');
                            el.after($('<span class="error">' + dataResult[i] + '</span>'));
                        });
                    }
                },
                error: function (data) {
                    show_formAjax_error(data);
                }
            });
        }
    });

// ========================================
// script for Quizzy module
// ========================================
    //add new quiz
    $('#addQuizzy').validate({
        rules: {
            qui_title: { required: true },
            description: { required: true },
            instruction: { required: true },
            duration: { required: true },
            status: { required: true },
        },
        messages: {
            qui_title: { required: "Please Enter Quiz Title" },
            description: { required: "Please Enter Quiz Description" },
            instruction: { required: "Please Enter Quiz Instruction" },
            duration: { required: "Please Enter Quiz Duration" },
            status: { required: "Please Select Status" },
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == "duration" ){
                error.insertAfter(".input-group");
            }else if  (element.attr("name") == "status" ){
                error.insertAfter(".select2-container");
            }else{
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: URL+'/teacher/quizzes',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Successfully.'
                        });
                        setTimeout(function(){
                            window.location.href = URL+'/teacher/quizzes';
                        },2000)
                    }
                },
                error: function (data) {
                    show_formAjax_error(data);
                }
            });
        }
    });

    //update quiz
    $('#updateQuizzy').validate({
        rules: {
            qui_title: { required: true },
            description: { required: true },
            instruction: { required: true },
            duration: { required: true },
            status: { required: true },
        },
        messages: {
            teacher: { required: "Please Select The teacher" },
            qui_title: { required: "Please Enter Quiz Title" },
            description: { required: "Please Enter a Quiz Description" },
            instruction: { required: "Please Enter a Quiz Instructions" },
            status: { required: "Select Status" },
            duration: { required: "Select Status" },
        },
        submitHandler: function (form) {
            var url = window.location.href;
            var s_url = url.split('/');
            s_url.pop();
            var nUrl = s_url.join('/');
            var formdata = new FormData(form);
            $.ajax({
                url: nUrl,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Successfully.'
                        });
                        setTimeout(function(){
                            s_url.pop();
                            var rUrl = s_url.join('/');
                            window.location.href = rUrl;
                        },2000)
                    }
                },
                error: function (data) {
                    show_formAjax_error(data);
                }
            });
        }
    });


// ========================================
// script for Question module
// ========================================

    //add choice input 
    var c = 1;
    $('.add-choice').click(function(){
        c++;
        var choice = `<div class="input-group">
                        <input type="text" class="form-control" id="ch`+c+`" name="choice[]">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="radio" id="cr`+c+`" name="correct">
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-danger remove-choice m-0 ml-2"><i class="fa fa-times"></i></button>
                    </div>`;
        $('.choice-container').append(choice);
    });

    $(document).on('click','.remove-choice',function(){
        $(this).parent('.input-group').remove();
    })



    //add new question
    $('#addQuestion').validate({
        rules: {
            question: { required: true },
            quizzy: { required: true },
        },
        messages: {
            question: { required: "Please Enter Question Title" },
            quizzy: { required: "Please Select Quiz Name" },
        },
        submitHandler: function (form) {
            $('.er-message').addClass('d-none');
            
            var choices = [];
            $("input[name='choice[]']").each(function() {
                choices.push($(this).val());
            }); 
            if(choices.length < 2){
                $('.er-message').html('<li>Please Enter Minimum Two Choices</li>');
                $('.er-message').removeClass('d-none');
            }
            var correct = '';
            
            $("input[name='correct']").each(function() {
                if(correct == ''){
                    if($(this).prop("checked")){
                        var id = $(this).attr('id');
                        correct = id.slice(2);
                    }else{
                        correct = '';
                    }
                }
            });
            
            if(correct == ''){
                if($('.er-message').hasClass('d-none')){
                    $('.er-message').html('Please Select Correct Answer');
                    $('.er-message').removeClass('d-none');
                }else{
                    $('.er-message').append('<li>Please Select Correct Answer</li>');
                }
            }
            var formdata = new FormData(form);
            formdata.append('choices',JSON.stringify(choices));
            formdata.append('correct',correct);
            if(choices.length > 1 && correct != ''){
                $.ajax({
                    url: URL+'/teacher/questions',
                    type: 'POST',
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function (dataResult){
                        console.log(dataResult);
                        if (dataResult == '1') {
                            Toast.fire({
                                icon: 'success',
                                title: 'Added Successfully.'
                            });
                            setTimeout(function(){
                                window.location.href = URL +'/teacher/questions';
                            },2000)
                        }
                    },
                    error: function (data) {
                        show_formAjax_error(data)
                    }
                });
            }
        }
    });

    //update question
    $('#updateQuestion').validate({
        rules: {
            question: { required: true },
            quizzy: { required: true },
        },
        messages: {
            question: { required: "Please Enter Question Title" },
            quizzy: { required: "Please Select Quiz Name" },
        },
        submitHandler: function (form) {
            $('.er-message').addClass('d-none');
            
            var choices = [];
            $("input[name='choice[]']").each(function() {
                choices.push($(this).val());
            }); 
            if(choices.length < 2){
                $('.er-message').html('<li>Please Enter Minimum Two Choices</li>');
                $('.er-message').removeClass('d-none');
            }
            var correct = '';
            
            $("input[name='correct']").each(function() {
                if(correct == ''){
                    if($(this).prop("checked")){
                        var id = $(this).attr('id');
                        correct = id.slice(2);
                    }else{
                        correct = '';
                    }
                }
            });
            
            if(correct == ''){
                if($('.er-message').hasClass('d-none')){
                    $('.er-message').html('Please Select Correct Answer');
                    $('.er-message').removeClass('d-none');
                }else{
                    $('.er-message').append('<li>Please Select Correct Answer</li>');
                }
            }
            var formdata = new FormData(form);
            formdata.append('choices',JSON.stringify(choices));
            formdata.append('correct',correct);
            var url = window.location.href;
            var s_url = url.split('/');
            s_url.pop();
            var nUrl = s_url.join('/');
            $.ajax({
                url: nUrl,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult){
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Successfully.'
                        });
                        setTimeout(function(){
                            s_url.pop();
                            var rUrl = s_url.join('/');
                            window.location.href = rUrl;
                        },2000)
                    }
                },
                error: function (data) {
                    show_formAjax_error(data)
                }
            });
        }
    });

    //delete question
    $(document).on("click", ".delete-question", function() {
        destroy_data($(this), 'questions/')
    });


// ========================================
// script for Mailbox module
// ========================================
    //add new message
    $('#addMailbox').validate({
        rules: {
            receiver: { required: true },
            title: { required: true },
            description: { required: true },
        },
        messages: {
            receiver: { required: "Please Enter Recevier Name" },
            title: { required: "Please Enter a Title Name" },
            description: { required: "Please Enter a Description" },
        },
        submitHandler: function (form) {
            
            var formdata = new FormData(form);
            $.ajax({
                url: URL+'/teacher/mailbox',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult){
                    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Sended Successfully.'
                        });
                        setTimeout(function(){
                            window.location.href = URL+'/teacher/mailbox/sent';
                        },2000)
                    }
                },
                error: function (data) {
                    show_formAjax_error(data)
                }
            });
        }
    });
    
// ========================================
// script for student Mailbox module
// ========================================
    $('#addStudentmailbox').validate({
        rules: {
            recevier: { required: true },
            title: { required: true },
            description: { required: true },
        },
        messages: {
            recevier: { required: "Please Select Teacher Name" },
            title: { required: "Please Enter a Title" },
            description: { required: "Please Enter a Description" },
        },
        submitHandler: function (form) {
            var url = $('.url').val();
            var rdt_url = $('.rdt-url').val();
            var formdata = new FormData(form);
            //alert(url);
            //alert(rdt_url);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Sended Successfully.'
                        });
                        setTimeout(function(){
                            window.location.href = rdt_url;
                        },2000)
                    }
                },
                error: function (data) {
                    show_formAjax_error(data)
                }
            });
        }
    });

// ========================================
// script for update teacher deatils by teacher
// ========================================

    $('#modifyTeacher').validate({
        rules: {
            teacher_name:{ required: true },
            teacher_phone: { required: true },
            teacher_dob: { required: true },
            teacher_address: { required: true },
        },
        messages: {
            teacher_name:{ required: "This Field is Required." },
            teacher_phone: { required: "This Field is Required." },
            teacher_dob: { required: "This Field is Required." },
            teacher_address: { required: "This Field is Required." },
        },
        submitHandler: function (form) {
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
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Successfully.'
                        });
                        setTimeout(function(){
                            window.location.reload();
                        },2000)
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