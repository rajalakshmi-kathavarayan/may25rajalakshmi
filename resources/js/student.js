// ======================== Jquery for student details ================//

$(document).ready(function() {

 // =================================== Inactive  Student =====================================//
 $(".inactiveStudentDetails").on('click', function(){
    let studentId = $(this).attr("data-student-id");

    $.ajax({
        url : "/inactive-student-details",
        method : "get",
        data: {
            studentId : studentId,
        },
        dataType : "JSON",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    })
    .done(function(response){
        $(".hiddenedStudentId").val(response.id);
        $("#exampleModalinactive").modal("show");
    })
    .fail(function(xhr, status, error){
        console.log(status);
        var jsonResponse = xhr.responseJSON;
        toastr.error(jsonResponse.error);
    })
});

$(".inactiveStudent").on('click', function(){
    let inactiveStudentId = $(".hiddenedStudentId").val();

    $.ajax({
        url: "/inactive-student",
        method: "post",
        data: {
            studentId: inactiveStudentId,
        },
        dataType: "JSON",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    })
    .done(function(response){
        if(response.status === "Success"){
            toastr.success(response.message);
            setTimeout(function(){
                $(".modal-dialog").hide();
                window.location.href = "/student";
            }, 1000);
        } else {
            toastr.error(response.message);
        }
    })
    .fail(function(xhr, status, error){
        console.log(status);
        var jsonResponse = xhr.responseJSON;
        toastr.error(jsonResponse.message);

        setTimeout(function(){
            $(".modal-dialog").hide();
            window.location.href = "/student";
        }, 3000);
    })
});

//================================== active  Student ===============================//
$(".activeStudent").on('click', function(){
    let $studentId = $(this).attr("data-student-id");
    // console.log($studentId);

    $.ajax({
        url : "/active-student-details",
        method : "get",
        data: {
            studentId : $studentId,
        },
        dataType : "JSON",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    })
    .done(function(response){
        $(".hiddenedactiveStudentId").val(response.id);
        $("#exampleModalactive").modal("show");
    })
    .fail(function(xhr, status, error){
        // console.log(status);
        var jsonResponse = xhr.responseJSON;
        toastr.error(jsonResponse.error);
    })
});

$(".activateStudent").on('click',function(){
    let $activeStudentId = $(".hiddenedactiveStudentId").val();
    $.ajax({
        url : "/active-student",
        method : "post",
        data: {
            studentId : $activeStudentId,
        },
        dataType : "JSON",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    })
    .done(function(response){
        if(response.status == "Success"){
            toastr.success(response.message);
            setTimeout(function(){
                $(".modal-dialog").hide();
                window.location.href = "/student";
            }, 1000);
        }
        else{
            toastr.error(response.message);
        }
    })
    .fail(function(xhr, status, error){
        // console.log(status);
        var jsonResponse = xhr.responseJSON;
        toastr.error(jsonResponse.error);
    })
})


    // =====================  add dynamic row for the table =========================//
    $("#addRowBtn").click(function(e) {
        e.preventDefault();

        var newRow =
        `<tr>
            <td><input type="text" class="form-control subjectName" name="subjectName"><span class="subjectError"></span></td>
            <td><input type="text" class="form-control mark" name="mark"><span class="markError"></span></td>
            <td><input type="text" class="form-control grade" name="grade"><span class="gradeError"></span></td>
            <td><button class="btn btn-danger removeRow"><i class="bi bi-trash-fill"></i></button></td>
        </tr>`;

        $("#subjectTable tbody").append(newRow);
    });

    $(document).on("click", ".removeRow", function () {
        $(this).closest("tr").remove();
    });

    // ----------clear inputs fields ------//
    function clearFields() {
        $('.form-control').val('');
    }

    $('.btn-close').click(function() {
        clearFields();
    });

    // ======================== Add student form validation and ajax call ===================== //
    $("#studentForm").submit(function(e) {
        e.preventDefault();
        // alert("hiii")
        var studentName = $("#studentName").val();
        var studentMail = $("#studentMail").val();
        var studentNumber = $("#studentNumber").val();
        var address = $("#address").val();
        var city = $("#city").val();
        var state = $("#state").val();
        var country = $("#country").val();

        var subjectName = $("input[name='subjectName']").val();
        var mark = $("input[name='mark']").val();
        var grade = $("input[name='grade']").val();

        var subjectNameNew = $(".subjectName").val();
        var markNew = $(".mark").val();
        var gradeNew = $(".grade").val();

        // console.log(subjectNameNew);
        // console.log(subjectName);
        // console.log(studentName);
        var isValid = true;

        $('#nameError').text('');
        $('#emailError').text('');
        $('#contactError').text('');
        $('#addressError').text('');
        $('#cityError').text('');
        $('#stateError').text('');
        $('#countryError').text('');
        $('#subjectError').text('');
        $('#markError').text('');
        $('#gradeError').text('');
        $('.subjectError').text('');
        $('.markError').text('');
        $('.gradeError').text('');

        if (studentName === '') {
            $('#nameError').text('Name is required').css('color', 'red');
            isValid = false;
        }

        $('#studentName').on('input', function() {
            var value = $(this).val();
            var filteredValue = value.replace(/[^a-zA-Z]/g, '');
            $(this).val(filteredValue);
        });
        if (studentMail === '') {
            $('#emailError').text('Email is required').css('color', 'red');
            isValid = false;
        }else {
            var emailExp = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailExp.test(studentMail)) {
                $('#emailError').text('Please enter a valid email address').css('color', 'red');
                isValid = false;
            }
        }
        if (studentNumber === '') {
            $('#contactError').text('Contact number is required').css('color', 'red');
            isValid = false;
        } else if (!/^\d{10}$/.test(studentNumber)) {
            $('#contactError').text('Contact number must be exactly 10 digits').css('color', 'red');
            isValid = false;
        }
        if (address === '') {
            $('#addressError').text('Address is required').css('color', 'red');
            isValid = false;
        }
        if (city === '') {
            $('#cityError').text('City is required').css('color', 'red');
            isValid = false;
        }
        if (state === '') {
            $('#stateError').text('State is required').css('color', 'red');
            isValid = false;
        }
        if (country === '') {
            $('#countryError').text('State is required').css('color', 'red');
            isValid = false;
        }
        if (subjectName === '') {
            $('#subjectError').text('Subject is required').css('color', 'red');
            isValid = false;
        }
        if (mark === '') {
            $('#markError').text('mark is required').css('color', 'red');
            isValid = false;
        }
        if (grade === '') {
            $('#gradeError').text('grade is required').css('color', 'red');
            isValid = false;
        }
        if (subjectNameNew === '') {
            $('.subjectError').text('subject is required').css('color', 'red');
            isValid = false;
        }
        if (gradeNew === '') {
            $('.gradeError').text('grade is required').css('color', 'red');
            isValid = false;
        }
        if (markNew === '') {
            $('.markError').text('mark is required').css('color', 'red');
            isValid = false;
        }
        if(isValid){
            var studentData = {
            studentName: $("#studentName").val(),
            studentMail: $("#studentMail").val(),
            studentNumber: $("#studentNumber").val(),
            address: $("#address").val(),
            city: $("#city").val(),
            state: $("#state").val(),
            country: $("#country").val(),
            subjects: []
        };

        $("#subjectTable tbody tr").each(function() {
            var subject = {
                subjectName: $(this).find('input[name="subjectName"]').val(),
                mark: $(this).find('input[name="mark"]').val(),
                grade: $(this).find('input[name="grade"]').val(),
            };
            studentData.subjects.push(subject);
        });
        $.ajax({
            url: "/store-student",
            type: "POST",
            data: studentData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                setTimeout(function () {
                    toastr.success('Student details added successfully');
                    $('#offcanvasExample').offcanvas('hide');
                    window.location.reload();
                }, 1000);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.studentMail) {
                        toastr.error(errors.studentMail[0]);
                    }
                    if (errors.studentNumber) {
                        toastr.error(errors.studentNumber[0]);
                    }
                } else if (xhr.responseJSON && xhr.responseJSON.error) {
                    toastr.error(xhr.responseJSON.error);
                } else {
                    toastr.error(' while saving the student details.');
                }
            }
        });
        }

    });

    // ========================= view student details ajax call ==========================//
    $('.viewStudent').click(function() {
        var studentId = $(this).data('student-id');

        $.ajax({
            url: '/student/' + studentId,
            type: 'GET',
            success: function(response) {

                $('.studentName').text(response.name);
                $('.studentEmail').text(response.email);
                $('.studentAddress').text(response.address);
                $('.studentPhone').text(response.phone_number);
                $('.studentCity').text(response.city);
                $('.studentState').text(response.state);
                $('.studentCountry').text(response.country);

                $('.studentSubjects').empty();

                response.subjects.forEach(function(subject) {
                    var subjectItem = `
                        <li class="list-group-item">
                            <p><strong>Subject:</strong> ${subject.name}</p>
                            <p><strong>Mark:</strong> ${subject.mark}</p>
                            <p><strong>Grade:</strong> ${subject.grade}</p>
                        </li>
                    `;
                    $('.studentSubjects').append(subjectItem);
                });


                $('#studentDetailsModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    //  =========================== view modal end =====================================//

    // ========================== Edit modal ajax call start ==============================//

    // ================== append row for edit modal form ==============//

        $("#addEditRowBtn").click(function(e) {
            e.preventDefault();

            var newRow =
            `<tr>
                <td><input type="text" class="form-control subjectName" name="subjectName"><span class="subjectError"></span></td>
                <td><input type="text" class="form-control mark" name="mark"><span class="markError"></span></td>
                <td><input type="text" class="form-control grade" name="grade"><span class="gradeError"></span></td>
                <td><button class="btn btn-danger removeRow"><i class="bi bi-trash-fill"></i></button></td>
            </tr>`;

            $("#editSubjectTable tbody").append(newRow);
        });

        $(document).on("click", ".removeRow", function() {
            $(this).closest("tr").remove();
        });

        $(document).ready(function() {
            $(".editStudent").click(function() {
                var studentId = $(this).data("student-id");

                $.ajax({
                    url: "/edit-student/" + studentId,
                    type: "GET",
                    success: function(response) {

                        $("#editStudentId").val(response.student.id);
                        $("#editStudentName").val(response.student.name);
                        $("#editStudentMail").val(response.student.email);
                        $("#editStudentNumber").val(response.student.phone_number);
                        $("#editAddress").val(response.student.address);
                        $("#editCity").val(response.student.city);
                        $("#editState").val(response.student.state);
                        $("#editCountry").val(response.student.country);


                        $("#editSubjectTable tbody").empty();
                        var subjects = response.student.subjects;
                        if (subjects && subjects.length > 0) {
                            subjects.forEach(function(subject) {
                                var newRow =
                                    `<tr>
                                        <td><input type="text" class="form-control" name="subjectName" value="${subject.name}"></td>
                                        <td><input type="text" class="form-control" name="mark" value="${subject.mark}"></td>
                                        <td><input type="text" class="form-control" name="grade" value="${subject.grade}"></td>
                                        <td><button class="btn btn-danger removeRow"><i class="bi bi-trash-fill"></i></button></td>
                                    </tr>`;
                                $("#editSubjectTable tbody").append(newRow);
                            });
                        }

                        $("#editOffcanvas").offcanvas("show");


                        $('#editStudentForm').off('submit').on('submit', function(event) {
                            event.preventDefault();
                            var isValid = true;

                            if (isValid) {
                                var studentData = {
                                    studentName: $("#editStudentName").val(),
                                    studentMail: $("#editStudentMail").val(),
                                    studentNumber: $("#editStudentNumber").val(),
                                    address: $("#editAddress").val(),
                                    city: $("#editCity").val(),
                                    state: $("#editState").val(),
                                    country: $("#editCountry").val(),
                                    subjects: []
                                };

                                $("#editSubjectTable tbody tr").each(function() {
                                    var subject = {
                                        subjectName: $(this).find('input[name="subjectName"]').val(),
                                        mark: $(this).find('input[name="mark"]').val(),
                                        grade: $(this).find('input[name="grade"]').val(),
                                    };
                                    studentData.subjects.push(subject);
                                });

                                $.ajax({
                                    url: "/update-student/" + studentId,
                                    type: "PUT",
                                    contentType: "application/json",
                                    data: JSON.stringify(studentData),
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(response) {
                                        setTimeout(function() {
                                            toastr.success('Student Updated Successfully');
                                            $('#editOffcanvas').offcanvas('hide');
                                            window.location.reload();
                                        }, 1000);
                                    },
                                    error: function(xhr) {
                                        toastr.error('An error occurred while updating the student.');
                                    }
                                });
                            }
                        });

                        // Handle removing subject rows
                        $(document).on('click', '.removeRow', function() {
                            $(this).closest('tr').remove();
                        });
                    },
                    error: function(xhr) {
                        toastr.error('An error occurred while fetching the student details.');
                    }
                });
            });

        });



    // ========================== Edit modal ajax call End ==============================//


    // ============================ delete modal ajax call start =========================//
    $('.deleteStudent').click(function() {
        let studentId = $(this).attr("data-student-id");
        $('#confirmDeleteBtn').attr("data-student-id", studentId);
        $('#deleteStudentModal').modal('show');
    });

    $('#confirmDeleteBtn').click(function() {
        let studentId = $(this).attr("data-student-id");

        $.ajax({
            type: 'DELETE',
            url: "/student-delete/" + studentId,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(response) {
                if (response.status === "Success") {
                    toastr.success('Student deleted successfully.');
                    setTimeout(function () {
                        window.location.href = "/student";
                    }, 1000);
                } else {
                    toastr.error('Failed to delete student.');
                    console.log(response.message);
                }
            },
            error: function(error) {
                console.log(error);
                toastr.error('Failed to delete student.')
            }
        });

        $('#deleteStudentModal').modal('hide');
    });
    // ============================ Delete Modal End======================================//
    let activeTable = new DataTable('#activeTable');
    let inactiveTable = new DataTable('#inactiveTable');
});
