
// ================ Jquery for authentication login and registration ==============//
$(document).ready(function() {

    toastr.otpions = {
        closeButton: true,
        newestOnTop: false,
        progressBar: true,
        positionClass: "toast-top-right",
        preventDuplicates: false,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };

    //  ===================== Ajax call for login form ==================//
    $('#loginForm').on('submit', function(event){
        event.preventDefault();
        var userEmail = $('#userEmail').val().trim();
        var userPassword = $('#userPassword').val().trim();
        console.log(userEmail);
        console.log(userPassword);

        var isValid = true;
        if (userEmail === '') {
            $('#emailError').text('Email is required').css('color', 'red');
            isValid = false;
        } else {
            var emailExp = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailExp.test(userEmail)) {
                $('#emailError').text('Please enter a valid email address').css('color', 'red');
                isValid = false;
            }
        }
        if (userPassword === '') {
            $('#passwordError').text('Password is required').css('color', 'red');
            isValid = false;
        } else {
            var passwordExp = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (!passwordExp.test(userPassword)) {
                $('#passwordError').text('Password should contain at least one alphabet, one number, and one special character').css('color', 'red');
                isValid = false;
            }
        }

        if (isValid) {
            $.ajax({
                url: '/check-email',
                method: 'POST',
                data: {
                    email: userEmail
                },
                dataType: 'JSON',
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(response) {
                    if (response.exists) {

                        $.ajax({
                            url: '/login',
                            method: 'POST',
                            data: {
                                email: userEmail,
                                password: userPassword
                            },
                            dataType: 'JSON',
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                            success: function(response) {
                                if (response.authenticated) {
                                    toastr.success('Login Success.');
                                    window.location.href = '/student';
                                } else {
                                    toastr.error('Invalid email or password.');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    } else {
                        toastr.error('Email not found. Please Sign Up.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });

    // ====================== Ajax call for register form ==============//

    $('#registerForm').on('submit', function(event) {
        event.preventDefault();

        var userName = $('#userName').val().trim();
        var userEmail = $('#userEmail').val().trim();
        var userPassword = $('#userPassword').val().trim();
        var userCpassword = $('#userCpassword').val().trim();
        var userContact = $('#userContact').val().trim();

        console.log(userName);
        console.log(userEmail);
        console.log(userPassword);
        console.log(userCpassword);
        console.log(userContact);

        var isValid = true;

        $('#nameError').text('');
        $('#emailError').text('');
        $('#passwordError').text('');
        $('#cpasswordError').text('');
        $('#contactError').text('');

        if (userName === '') {
            $('#nameError').text('Name is required').css('color', 'red');
            isValid = false;
        }

        $('#userName').on('input', function() {
            var inputValue = $(this).val();
            var alphaExp = /^[a-zA-Z\s]*$/;

            if (!alphaExp.test(inputValue)) {
                $(this).val(inputValue.replace(/[^a-zA-Z\s]/g, ''));
            }
        });

        if (userEmail === '') {
            $('#emailError').text('Email is required').css('color', 'red');
            isValid = false;
        } else {
            var emailExp = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailExp.test(userEmail)) {
                $('#emailError').text('Please enter a valid email address').css('color', 'red');
                isValid = false;
            }
        }

        if (userPassword === '') {
            $('#passwordError').text('Password is required').css('color', 'red');
            isValid = false;
        } else {
            var passwordExp = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (!passwordExp.test(userPassword)) {
                $('#passwordError').text('Password should contain at least one alphabet, one number, and one special character').css('color', 'red');
                isValid = false;
            }
        }

        if (userCpassword === '') {
            $('#cpasswordError').text('Confirm password is required').css('color', 'red');
            isValid = false;
        } else if (userCpassword !== userPassword) {
            $('#cpasswordError').text('Passwords do not match').css('color', 'red');
            isValid = false;
        }

        if (userContact === '') {
            $('#contactError').text('Contact number is required').css('color', 'red');
            isValid = false;
        } else if (!/^\d{10}$/.test(userContact)) {
            $('#contactError').text('Contact number must be exactly 10 digits').css('color', 'red');
            isValid = false;
        }
        // ========================= register  form post route ajax call ====================//
        if(isValid){
            var formData = {
                name: $('#userName').val(),
                email: $('#userEmail').val(),
                password: $('#userPassword').val(),
                cpassword: $('#userCpassword').val(),
                contact: $('#userContact').val(),
                _token: $('input[name="_token"]').val()
            };
            $.ajax({
                type: 'POST',
                url: '/register',
                data: formData,
                dataType : "JSON",
                success: function(response) {
                    toastr.success('Registered successfully');
                    window.location.href = "/";
                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.email) {
                        toastr.error(xhr.responseJSON.errors.email[0]);
                    } else {
                        toastr.error('Failed to register');
                    }
                }
            });
        }
    });

});





