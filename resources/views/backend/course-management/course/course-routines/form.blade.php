<form action="{{ route('course-routines.store') }}" method="post" enctype="multipart/form-data" id="coursesForm">

    <input type="hidden" name="course_id" value="{{ request()->input('course_id') }}" />
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Course Routine</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    {{--                    <input type="hidden" name="category_id" >--}}
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2">
                <div class="col-md-6 mt-2">
                    <label for="">Content Name</label>
                    <input type="text" class="form-control" name="content_name" placeholder="Content Name" />
                    <span class="text-danger" id="content_name">{{ $errors->has('content_name') ? $errors->first('content_name') : '' }}</span>
                </div>
                <div class="col-md-6 mt-2 select2-div">
                    <label for="">Working Day</label>
                    <select name="day" class="form-control select2" data-placeholder="Select a day">
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                    </select>
                    <span class="text-danger" id="day">{{ $errors->has('day') ? $errors->first('day') : '' }}</span>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Date and Time</label>
                    <input type="text" class="form-control" id="dateTime" name="date_time" data-dtp="dtp_Nufud" value="" placeholder="Date and Time" />
                    <span class="text-danger" id="date_time">{{ $errors->has('date_time') ? $errors->first('date_time') : '' }}</span>
                </div>
                <div class="col-md-3 mt-3">
                    <label for="">Status</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionInfo" name="status" type="checkbox" checked />
                        <label for="someSwitchOptionInfo" class="label-info"></label>
                    </div>
                </div>
                <div class="col-md-3 mt-3">
                    <label for="">Is Fack</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionInfox" name="is_fack" type="checkbox" />
                        <label for="someSwitchOptionInfox" class="label-info"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary " value="save">Save</button>
    </div>
</form>

