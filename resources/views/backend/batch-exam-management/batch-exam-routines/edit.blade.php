<form action="{{ isset($batchExamRoutine) ? route('batch-exam-routines.update', $batchExamRoutine->id) : route('batch-exam-routines.store') }}" method="post" enctype="multipart/form-data" id="coursesForm">
    @if(isset($batchExamRoutine))
        @method('put')
    @endif
        <input type="hidden" name="batch_exam_id" value="{{ isset($batchExamRoutine) ? $batchExamRoutine->batch_exam_id : request()->input('batch_exam_id') }}" />
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Batch Exam Routine</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
    </div>
    {{--                    <input type="hidden" name="category_id" >--}}
    <div class="modal-body">
        <div class="card card-body">
            <div class="row mt-2">
                <div class="col-md-6 mt-2 select2-div">
                    <label for="">Working Day</label>
                    <select name="day" class="form-control select2" data-placeholder="Select a day">
                        <option value="Saturday" {{ isset($batchExamRoutine) && $batchExamRoutine->day == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                        <option value="Sunday" {{ isset($batchExamRoutine) && $batchExamRoutine->day == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                        <option value="Monday" {{ isset($batchExamRoutine) && $batchExamRoutine->day == 'Monday' ? 'selected' : '' }}>Monday</option>
                        <option value="Tuesday" {{ isset($batchExamRoutine) && $batchExamRoutine->day == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                        <option value="Wednesday" {{ isset($batchExamRoutine) && $batchExamRoutine->day == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                        <option value="Thursday" {{ isset($batchExamRoutine) && $batchExamRoutine->day == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                        <option value="Friday" {{ isset($batchExamRoutine) && $batchExamRoutine->day == 'Friday' ? 'selected' : '' }}>Friday</option>
                    </select>
                </div>
                <div class="col-md-6 mt-2">
                    <label for="">Date and Time</label>
                    <input type="text" class="form-control" id="dateTime" name="date_time" data-dtp="dtp_Nufud" value="{{ isset($batchExamRoutine) ? $batchExamRoutine->date_time : '' }}" placeholder="Date and Time" />
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Status</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionInfo" name="status" type="checkbox" {{ isset($batchExamRoutine) && $batchExamRoutine->status == 0 ? '' : 'checked' }} />
                        <label for="someSwitchOptionInfo" class="label-info"></label>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <label for="">Is Fack</label>
                    <div class="material-switch">
                        <input id="someSwitchOptionInfox" name="is_fack" type="checkbox" {{ isset($batchExamRoutine) && $batchExamRoutine->is_fack == 0 ? '' : 'checked' }} />
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

