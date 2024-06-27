@foreach($students as $key => $student)
    <tr>
        <td>{{ $student['students'][0]['first_name'] }}</td>
        <td>{{ $student['students'][0]['email'] }}</td>
        <td>{{ $student['students'][0]['mobile'] }}</td>
        <td>{{ $student['status'] == 1 ? 'Active' : 'Inactive' }}</td>
        <td>
            {{--                                            <a href="" data-course-id="{{ $course->id }}" class="btn btn-sm btn-warning edit-btn" title="Edit Course">--}}
            {{--                                                <i class="mdi mdi-circle-edit-outline"></i>--}}
            {{--                                            </a>--}}
            @can('detach-course-student')
                <form class="d-inline" action="{{ route('detach-student', $course->id) }}" method="post" onsubmit="return confirm('Are you sure to Detach this Student from this course?')">                                            @csrf
                    <input type="hidden" name="student_id" value="{{ $student['id'] }}">
                    <button type="submit" class="btn btn-sm btn-danger" title="Detach Student from this Course?">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            @endcan
        </td>
    </tr>
@endforeach
