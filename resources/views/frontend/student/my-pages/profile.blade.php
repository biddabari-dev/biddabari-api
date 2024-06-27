@extends('frontend.student-master')

@section('student-body')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="section-title text-center">
                <h2> আমার প্রোফাইল</h2>
                <hr class="w-25 mx-auto bg-danger" />
            </div>
            <div class="col-lg-12 col-md-6">
                <div class="courses-item pt-5">
                    <div class="content">
                        <form class="form" id="" method="post" action="{{ route('front.student.profile-update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-20">
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label for="">User Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ isset($user) ? $user->name : '' }}" name="name" required
                                            data-error="Username" placeholder="Username">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label for="">First Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ isset($student) ? $student->first_name : '' }}" name="first_name"
                                            required data-error="FirstName" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label for="">Last Name</label>
                                        <input type="text" class="form-control"
                                            value="{{ isset($student) ? $student->last_name : '' }}" name="last_name"
                                            required data-error="LastName" placeholder="Last Name">
                                    </div>
                                </div>

                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label for="">Mobile</label>
                                        <input type="text" class="form-control" readonly
                                            value="{{ isset($user) ? $user->mobile : '' }}" name="mobile" required
                                            data-error="Please enter Phone " placeholder="Please Enter Phone">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-20">
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input class="form-control" type="email"
                                            value="{{ isset($user) ? $user->email : '' }}" name="email"
                                            placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label for="">Profile Image</label>
                                        <input class="form-control" type="file" id="profileImage" name="image"
                                            accept="image/*" />
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <img src="{{ isset($user) && !empty($student->image) ? asset($student->image) : '' }}"
                                            id="imagePreview"
                                            style="{{ isset($user) && !empty($student->image) ? 'height: 100px;' : '' }}"
                                            alt="show profile image" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-20">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Date Of Birth</label>
                                        <input type="text" class="form-control" name="dob" id="dateTime1"
                                            value="{{ isset($student) ? $student->dob : '' }}"
                                            placeholder="date of birth">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Gender : </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="mt-2">
                                            <input class="" type="radio" name="gender" value="male" {{ isset($student)
                                                && $student->gender == 'male' ? 'checked' : '' }} {{ isset($student) &&
                                            $student->gender == null ? 'checked' : '' }}> &nbsp;&nbsp; Male
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <input class="" type="radio" name="gender" value="female" {{ isset($student)
                                                && $student->gender == 'female' ? 'checked' : '' }}> &nbsp;&nbsp; Female
                                            <input class="" type="radio" name="gender" value="other" {{ isset($student)
                                                && $student->gender == 'other' ? 'checked' : '' }}> &nbsp;&nbsp; Other
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-20">
                                <div class="col-3 mt-2">
                                    <div class="form-group">
                                        <input class="form-control default-btn" type="submit" value="Update">
                                    </div>
                                </div>
                                <div class="col-3 mt-2">
                                    <div class="form-group">
                                        <input class="form-control btn btn-info" type="reset" value="Reset">
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

@push('style')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
@endpush

@push('script')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(function () {
        $("#dateTime1").datepicker();
    });
</script>
<script>
    $(document).ready(function () {
        $('#profileImage').change(function () {
            var imgURL = URL.createObjectURL(event.target.files[0]);
            $('#imagePreview').attr('src', imgURL).css({
                height: 150 + 'px',
                width: 150 + 'px',
                marginTop: '5px',
                display: 'block'
            });
        });
    });
</script>
@endpush