
@foreach($sectionContents as $index => $sectionContent)
    <div class="row card-body border-0 py-1" >
        <h3 class="col-sm-8">
            @if(count($sectionContent->courseSectionContents) > 0)
                <i class="fa-solid fa-arrow-circle-down f-s-16"></i>
            @endif
            <span class="f-s-18 section-content-title">
                @if($sectionContent->content_type == 'pdf')
{{--                    <i class="fa-regular fa-file-pdf"></i>--}}
                    <img src="{{ asset('/') }}backend/assets/images/icons-bb/pdf.jpg" alt="pdf icon" class="img-16" />
                @endif
                @if($sectionContent->content_type == 'video')
                    <i class="fa-solid fa-video"></i>
                @endif
                @if($sectionContent->content_type == 'note')
                    <i class="fa-regular fa-note-sticky"></i>
                @endif
                @if($sectionContent->content_type == 'live')
{{--                    <i class="fa-solid fa-tower-broadcast"></i>--}}
                        <img src="{{ asset('/') }}backend/assets/images/icons-bb/live-icon.jpg" alt="pdf icon" class="img-16" />
                @endif
                @if($sectionContent->content_type == 'link')
                    <i class="fa-solid fa-link"></i>
                @endif
                @if($sectionContent->content_type == 'assignment')
{{--                    <i class="fa-regular fa-copy"></i>--}}
                        <img src="{{ asset('/') }}backend/assets/images/icons-bb/Assignment.jpg" alt="pdf icon" class="img-16" />
                @endif
                @if($sectionContent->content_type == 'testmoj')
                    <i class="fa-regular fa-copy"></i>
                @endif
                @if($sectionContent->content_type == 'exam')
{{--                    <i class="fa-regular fa-note-sticky"></i>--}}
                        <img src="{{ asset('/') }}backend/assets/images/icons-bb/MCQ.jpg" alt="pdf icon" class="img-16" />
                @endif
                @if($sectionContent->content_type == 'written_exam')
{{--                    <i class="fa-regular fa-paste"></i>--}}
                        <img src="{{ asset('/') }}backend/assets/images/icons-bb/Written-exam-icon.jpg" alt="pdf icon" class="img-16" />
                @endif
                &nbsp;{{ $sectionContent->title }}
            </span>
        </h3>
        <div class="col-sm-4">
            <div class="float-end">
{{--                @can('create-course-section-content')--}}
{{--                    <button type="button"  data-section-id="{{ $sectionContent->courseSection->id }}" class="btn btn-sm btn-info --}}{{--add-sub-category-btn--}}{{-- open-section-content-form-modal" title="Add Section Content">--}}
{{--                        <i class="fa-solid fa-plus-square"></i>--}}
{{--                    </button>--}}
{{--                @endcan--}}

                <a href="{{ route('change-order-number', ['model_name' => 'course_section_content', 'model_id' => $sectionContent->id, 'order' => 'up']) }}" class="btn btn-sm btn-secondary " title="Change Order top One level">
                    <i class="fa-solid fa-arrow-up-long"></i>
                </a>
                <a href="{{ route('change-order-number', ['model_name' => 'course_section_content', 'model_id' => $sectionContent->id, 'order' => 'down']) }}" class="btn btn-sm btn-secondary " title="Change Order Bottom One level">
                    <i class="fa-solid fa-arrow-down-long"></i>
                </a>

                @if($sectionContent->content_type == 'exam' || $sectionContent->content_type == 'written_exam')
                    <a href="{{ route('content-exam-ranking-download-page',['req_from' => 'course', 'content_id' => $sectionContent->id]) }}" data-section-content-id="{{ $sectionContent->id }}" data-xm-type="{{ $sectionContent->content_type }}" class="btn btn-sm btn-primary" title="Download Rankings">
                        <i class="fe fe-printer"></i>
                    </a>
                    <a href="{{ route('show-xm-attendance',['req_from' => 'course', 'content_id' => $sectionContent->id]) }}" data-section-content-id="{{ $sectionContent->id }}" data-xm-type="{{ $sectionContent->content_type }}" class="btn btn-sm btn-primary" title="Student Attendance">
                        <i class="fe fe-users"></i>
                    </a>
                @endif
                @if($sectionContent->content_type == 'video')
                    <a href="{{ route('content-exam-ranking-download-page',['req_from' => 'course_class_exam', 'content_id' => $sectionContent->id]) }}" data-section-content-id="{{ $sectionContent->id }}" data-xm-type="{{ $sectionContent->content_type }}" class="btn btn-sm btn-primary" title="Download Rankings">
                        <i class="fe fe-printer"></i>
                    </a>
                    <a href="{{ route('show-xm-attendance',['req_from' => 'course_class_exam', 'content_id' => $sectionContent->id]) }}" data-section-content-id="{{ $sectionContent->id }}" data-xm-type="{{ $sectionContent->content_type }}" class="btn btn-sm btn-primary" title="Student Attendance">
                        <i class="fe fe-users"></i>
                    </a>
                @endif
                @if($sectionContent->content_type == 'pdf' || $sectionContent->content_type == 'video')
                    <a href="" data-course-id="{{ $sectionContent->id }}" data-content-type="{{ $sectionContent->content_type }}" @if($sectionContent->content_type == 'pdf') data-pdf-url="{{ isset($sectionContent->pdf_link) ? $sectionContent->pdf_link : (isset($sectionContent->pdf_file) ? $sectionContent->pdf_file : '') }}" @endif @if($sectionContent->content_type == 'video') data-video-vendor="{{ $sectionContent->video_vendor }}" data-video-url="{{ $sectionContent->video_link }}" @endif class="btn btn-sm mt-1 btn-warning show-pdf-video-btn" title="View Pdf Or Video" >
                        <i class="fa-solid fa-eye"></i>
                    </a>
                @endif
                    @can('add-question-to-course-section-content')
                        @if($sectionContent->content_type == 'exam' || $sectionContent->content_type == 'written_exam')
{{--                            <a href="" data-section-content-id="{{ $sectionContent->id }}" data-xm-type="{{ $sectionContent->content_type }}" class="btn btn-sm btn-warning view-participants" title="View Participants">--}}
{{--                                <i class="fa-solid fa-eye"></i>--}}
{{--                            </a>--}}
                            <a href="" data-section-content-id="{{ $sectionContent->id }}" data-xm-type="{{ $sectionContent->content_type }}" class="btn btn-sm btn-primary add-question-modal-btn" title="Add Exam Questions">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                        @endif
                    @endcan
                    @can('add-question-to-course-section-content-class')
                        @if($sectionContent->has_class_xm == 1)
                            <a href="" data-section-content-id="{{ $sectionContent->id }}" data-xm-of="{{ $sectionContent->course_section_content_id }}" class="btn btn-sm btn-secondary add-class-question-modal-btn" title="Add Class Exam Questions">
                                <i class="fa-solid fa-plus-circle"></i>
                            </a>
                        @endif
                    @endcan
                    @can('show-course-section-content')
                        <a href="" data-section-content-id="{{ $sectionContent->id }}" class="btn btn-sm btn-success show-btn" title="Show Course">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    @endcan
                @can('edit-course-section-content')
                    <button type="button" data-section-content-id="{{ $sectionContent->id }}" class="btn btn-sm btn-warning section-content-edit-btn" title="Edit Section Content">
                        <i class="fa-solid fa-edit"></i>
                    </button>
                    @endcan
                @can('delete-course-section-content')
                    <form class="d-inline" action="{{ route('course-section-contents.destroy', $sectionContent->id) }}" method="post" >
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-danger data-delete-form" title="Delete Course Section Content">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                    @endcan
            </div>
        </div>
    </div>
    @if(isset($sectionContent->courseSectionContents))
        <div class="ps-5">
            @include('backend.course-management.course.course-sections.show-nested-cats', ['sectionContents' => $sectionContent->courseSectionContents, 'child' => $child + $child])
        </div>
    @endif
@endforeach
