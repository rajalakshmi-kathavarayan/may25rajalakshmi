@extends('layouts.app')
@section('content')
{{-- ============================ Student details Crud start ===================== --}}
<div class="d-flex justify-content-end  px-3">
    <button class="btn primary-bg text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
        <span class="d-flex align-items-center">
            <i class="fas fa-user-plus pe-1"></i>Add Student
        </span>
    </button>
</div>
<div class="activeInactiveTab mt-3 px-4">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active py-2 fw-bold " id="active-tab" data-bs-toggle="tab"
                data-bs-target="#active-tab-pane" type="button" role="tab" aria-controls="active-tab-pane"
                aria-selected="true">Active Students</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link py-2 fw-bold primary-text" id="inactive-tab" data-bs-toggle="tab"
                data-bs-target="#inactive-tab-pane" type="button" role="tab" aria-controls="inactive-tab-pane"
                aria-selected="false">Inactive Students</button>
        </li>
    </ul>
</div>
{{-- ================================================ Active and Inactive Tab Start ================================================= --}}

<div class="tab-content mt-4 px-4" id="myTabContent">
    {{-- ==================================================== Active Tab ================================================= --}}
    <div class="tab-pane table-responsive fade show active pb-4" id="active-tab-pane" role="tabpanel"
        aria-labelledby="active-tab" tabindex="0">
        <table class="table  table-striped table-responsive" id="activeTable" style="width:100%">
            <thead>
                <tr>
                    <th class="col">S.No</th>
                    <th class="col">Name</th>
                    <th class="col">Email</th>
                    <th class="col">Address</th>
                    <th class="col">Phone</th>
                    <th class="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($activeStudents)
                    @foreach ($activeStudents as $key => $student)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->address }}</td>
                            <td>{{ $student->phone_number }}</td>
                            <td>
                                <i class="bi bi-eye-fill viewStudent cursor" title="View" data-student-id="{{ $student->id }}"></i>
                                <i class="bi bi-pencil-square px-2 editStudent cursor" data-student-id="{{ $student->id }}" data-bs-target="#editoffcanvas" title="Edit"></i>
                                <i class="bi bi-person-fill-x inactiveStudentDetails fw-bold fs-5 cursor"
                                    data-student-id="{{ $student->id }}" title="Inactive"></i>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>No records found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    {{-- ==================================================== Inactive Tab ================================================= --}}
    <div class="tab-pane fade table-responsive pb-4" id="inactive-tab-pane" role="tabpanel" aria-labelledby="inactive-tab" tabindex="0">
        <table class="table table-striped table-responsive  py-3" id="inactiveTable">
            <thead>
                <tr class="table-heading">
                    <th class="col">S.No</th>
                    <th class="col">Name</th>
                    <th class="col">Email</th>
                    <th class="col">Address</th>
                    <th class="col">Phone</th>
                    <th class="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($inactiveStudents)
                    @foreach ($inactiveStudents as $key => $student)
                        <tr class="table-row">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->address }}</td>
                            <td>{{ $student->phone_number }}</td>
                            <td>
                                <i class="bi bi-person-check-fill px-2 activeStudent cursor"
                                    data-student-id="{{ $student->id }}" title="Active"></i>
                                <i class="bi bi-trash-fill deleteStudent  cursor"
                                    data-student-id="{{ $student->id }}" title="Delete"></i>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>No records found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

{{-- =============================================  Inactive modal  ==================================================== --}}
<div class="modal fade" id="exampleModalinactive" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#">
                    @csrf
                    <div class="text-center fw-bold fs-5 ">
                        <p class="primary-text">Do you want to inactivate this student?</p>
                        <input type="hidden" name="student_id" class="hiddenedStudentId">
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center border-0">
                <button type="button" class="btn btn-danger inactiveStudent">Inactivate</button>
            </div>
        </div>
    </div>
    <div id="Toastify"></div>
</div>
{{--============================================= Active Modal ========================================--}}
<div class="modal fade" id="exampleModalactive" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#">
                    @csrf
                    <div class="text-center fw-bold fs-5">
                        <p class="primary-text">Do you want to activate this student ?</p>
                        <input type="hidden" name="student_id" class="hiddenedactiveStudentId">
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center border-0">
                <button type="button" class="btn btn-success activateStudent">Activate</button>
            </div>
        </div>
    </div>
</div>

{{-- ================================================ Active and Inactive Tab End ================================================= --}}


{{-- ======================================= Add student modal start[CREATE]=================================== --}}
<div class="student-container">

    <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h4 class="offcanvas-title fw-semibold primary-text" id="offcanvasExampleLabel">Add Student</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="studentForm">
                <section class="row py-1">
                    <div class="col-lg-6 py-2">
                        <label for="studentName" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control w-100" id="studentName" name="studentName" autocomplete="off">
                        <div id="nameError"></div>
                    </div>
                    <div class="col-lg-6 py-2">
                        <label for="studentMail" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="studentMail" name="studentMail" autocomplete="off">
                        <div id="emailError"></div>
                    </div>
                    <div class="col-lg-6 py-2">
                        <label for="studentNumber" class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="studentNumber" name="studentNumber" autocomplete="off">
                        <div id="contactError"></div>
                    </div>
                    <div class="col-lg-6 py-2">
                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="address" name="address" autocomplete="off">
                        <div id="addressError"></div>
                    </div>
                    <div class="col-lg-6 py-2">
                        <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="city" name="city" autocomplete="off">
                        <div id="cityError"></div>
                    </div>
                    <div class="col-lg-6 py-2">
                        <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="state" name="state" autocomplete="off">
                        <div id="stateError"></div>
                    </div>
                    <div class="col-lg-6 py-2">
                        <label for="country" class="form-label " >Country <span class="text-danger">*</span></label>
                        <input type="text" class="form-control phone-num-validate" id="country" name="country" autocomplete="off">
                        <div id="countryError"></div>
                    </div>
                </section>

                <section class="mt-5" id="">
                    <div class="d-flex justify-content-between">
                        <h5 class="primary-text fw-semibold">Subjects</h5>
                        <button class="primary-bg text-white rounded-1 px-1 py-1 outline-0 border-0" id="addRowBtn">
                            <i class="fas fa-plus pe-1"></i>Add
                        </button>
                    </div>
                    <table class="table" id="subjectTable">
                        <thead>
                            <tr>
                                <th class="">Name</th>
                                <th class="">Mark Scored</th>
                                <th class="">Grade</th>
                                <th class=""></th>
                            </tr>
                        </thead>
                        <tbody id="">
                            <td><input type="text" class="form-control" name="subjectName"autocomplete="off"><div id="subjectError"></div></td>
                            <td><input type="text" class="form-control" name="mark" autocomplete="off"><div id="markError"></div></td>
                            <td><input type="text" class="form-control" name="grade" autocomplete="off"><div id="gradeError"></div></td>
                            <td>
                                <button class="btn btn-danger" disabled><i class="bi bi-trash-fill"></i></button>
                            </td>
                        </tbody>
                    </table>
                </section>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn primary-bg text-white px-4" id="studentSubmit">Submit</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
{{-- ===================================== End Add modal========================================== --}}

{{-- ==================================== View modal start [READ] ====================================== --}}
    <div class="modal fade" id="studentDetailsModal" tabindex="-1" aria-labelledby="studentDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title primary-text fw-semibold" id="studentDetailsModalLabel">Student Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Name:</strong> <span class="studentName"></span></p>
                        <p><strong>Email:</strong> <span class="studentEmail"></span></p>
                        <p><strong>Address:</strong> <span class="studentAddress"></span></p>
                        <p><strong>Phone No:</strong> <span class="studentPhone"></span></p>
                        <p><strong>City:</strong> <span class="studentCity"></span></p>
                        <p><strong>State:</strong> <span class="studentState"></span></p>
                        <p><strong>Country:</strong> <span class="studentCountry"></span></p>
                        <div id="subjectsContainer">
                            <ul class="list-group studentSubjects"></ul>
                        </div>
                    </div>
                </div>
            </div>
    </div>

        {{-- ============================ End view Modal ========================== --}}


        {{-- =========================== Edit modal start [UPDATE]================ --}}

        {{-- ======================================= Edit student modal start=================================== --}}
    <div class="student-container">
        <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="editOffcanvas" aria-labelledby="editOffcanvasLabel">
            <div class="offcanvas-header">
                <h4 class="offcanvas-title fw-semibold primary-text" id="editOffcanvasLabel">Edit Student</h4>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form id="editStudentForm">
                    <input type="hidden" id="editStudentId" name="studentId">
                    <section class="row py-1">
                        <div class="col-lg-6 py-2">
                            <label for="editStudentName" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control w-100" id="editStudentName" name="studentName" autocomplete="off">
                            <div id="editNameError" class="text-danger"></div>
                        </div>
                        <div class="col-lg-6 py-2">
                            <label for="editStudentMail" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="editStudentMail" name="studentMail" autocomplete="off">
                            <div id="editEmailError" class="text-danger"></div>
                        </div>
                        <div class="col-lg-6 py-2">
                            <label for="editStudentNumber" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editStudentNumber" name="studentNumber" autocomplete="off">
                            <div id="editContactError" class="text-danger"></div>
                        </div>
                        <div class="col-lg-6 py-2">
                            <label for="editAddress" class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editAddress" name="address" autocomplete="off">
                            <div id="editAddressError" class="text-danger"></div>
                        </div>
                        <div class="col-lg-6 py-2">
                            <label for="editCity" class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editCity" name="city" autocomplete="off">
                            <div id="editCityError" class="text-danger"></div>
                        </div>
                        <div class="col-lg-6 py-2">
                            <label for="editState" class="form-label">State <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editState" name="state" autocomplete="off">
                            <div id="editStateError" class="text-danger"></div>
                        </div>
                        <div class="col-lg-6 py-2">
                            <label for="editCountry" class="form-label " >Country <span class="text-danger">*</span></label>
                            <input type="text" class="form-control phone-num-validate" id="editCountry" name="country" autocomplete="off">
                            <div id="editCountryError" class="text-danger"></div>
                        </div>
                    </section>

                    <section class="mt-5" id="">
                        <div class="d-flex justify-content-between">
                            <h5 class="primary-text fw-semibold">Subjects</h5>
                            <button type="button" class="primary-bg text-white rounded-1 px-1 py-1 outline-0 border-0" id="addEditRowBtn">
                                <i class="fas fa-plus pe-1"></i>Add
                            </button>
                        </div>
                        <table class="table" id="editSubjectTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Mark Scored</th>
                                    <th>Grade</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="editSubjectTable">
                            </tbody>
                        </table>
                    </section>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn primary-bg text-white px-4" id="editStudentSubmit">Update</button>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    </div>

        {{-- ================================ Edit Modal End=========================  --}}

        {{-- =========================== Delete modal start [DELETE] ===================== --}}
        <div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="deleteStudentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center fw-bold fs-5 primary-text">
                        Do you want delete this Student ?
                    </div>
                    <div class="modal-footer border-0 d-flex justify-content-center">
                        <button type="button" class="btn btn-danger " id="confirmDeleteBtn">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- ========================== Delete Modal End ======================== --}}
@vite(['resources/js/student.js'])
@endsection
