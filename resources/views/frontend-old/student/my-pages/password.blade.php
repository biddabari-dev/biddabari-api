@extends('frontend.student-master')

@section('student-body')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h2>  পাসওয়ার্ড পরিবর্তন </h2>
                    <hr class="w-25 mx-auto bg-danger"/>
                </div>
                <div class="col-md-6 col-sm-8 mx-auto">
                    <div class="courses-item pt-5">
                        <div class="content">
                            <form class="" id="changePasswordForm" method="post" action="{{ route('front.student.change-student-password', ['id' => auth()->id()]) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-20">
                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
                                            <label for="">User Name</label>
                                            <input type="text" class="form-control" readonly value="{{ auth()->user()->name }}" placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
                                            <label for="">Old Password</label>
                                            <input type="text" class="form-control" name="old_password" required data-error="FirstName" placeholder="Old Password">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
                                            <label for="">New Password</label>
                                            <input type="text" class="form-control" name="new_password" required data-error="LastName" placeholder="New Password">
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
                                            <label for="">Confirm Password</label>
                                            <input type="text" class="form-control" name="confirm_password" required placeholder="Confirm Password">
                                            <span id="errorMsg" class="text-danger">.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-20">
                                    <div class="col-8 mt-2 mx-auto">
                                        <div class="form-group">
                                            <input class="form-control default-btn" type="submit" value="Update">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    @include('backend.includes.assets.plugin-files.date-time-picker')
    <script>
        $(document).on('submit', $('#changePasswordForm'), function () {
            event.preventDefault();
            var oldPassword = $('input[name="old_password"]').val();
            var newPassword = $('input[name="new_password"]').val();
            var confirmPassword = $('input[name="confirm_password"]').val();
            if (oldPassword == null || oldPassword == '')
            {
                return false;
            }
            if (newPassword == confirmPassword)
            {
                document.getElementById('changePasswordForm').submit();
            } else {
                $('#errorMsg').empty().append('Password mismatch');
            }
        })
    </script>
@endsection
