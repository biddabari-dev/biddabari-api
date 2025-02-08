<?php

namespace App\Http\Controllers\Frontend\Pages;

use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
use App\Models\Backend\Course\CourseSectionContent;
use App\Models\Backend\Gallery\Gallery;
use App\Models\Backend\OrderManagement\ParentOrder;
use Illuminate\Http\Request;

class FrontViewTwoController extends Controller
{
    public $todaysClasses = [], $todaysExams = [], $parentOrders = [], $data = [], $courseExams = [], $courseClassContents = [], $batchExams = [];
    public function GalleryImageView()
    {
        $this->galleries = Gallery::where(['status' => 1])->select('id', 'title', 'sub_title', 'banner')->get();

        $this->data = [
            'galleries' => $this->galleries
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.basic-pages.gallery.galleries');
    }

    public function GalleryImages($id)
    {
        $this->data = [
            'gallery'   => Gallery::where(['id' => $id])->select('id', 'title')->with(['galleryImages' => function($galleryImages) {
                $galleryImages->select('id', 'gallery_id', 'image_url')->get();
            }])->first()
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.basic-pages.gallery.gallery-details');
    }

    public function guideline()
    {
        return view('frontend.basic-pages.guideline');
    }

    public function todayClasses()
    {
        if (auth()->check()) {
            $this->courseClassContents = CourseSectionContent::whereHas('courseSection.course.parentOrders', function ($query) {
                $query->where('user_id', auth()->id())
                      ->where('ordered_for', 'course')
                      ->where('status', 'approved');
            })
            ->where('content_type', '!=', 'exam')
            ->where('content_type', '!=', 'written_exam')
            ->whereDate('available_at', now())
            ->get();
            if(!$this->courseClassContents){
                return response()->json([
                    'status'   => false,
                    'message'   => "There are no scheduled classes available today.",
                ],404);
            }

            $this->data = [
                'courseClassContents' => $this->courseClassContents
            ];

            return ViewHelper::checkViewForApi($this->data, 'frontend.student.todays-section.today-class');
        } else {
            return response()->json([
                'status'   => false,
                'message'   => "Please Login First!",
            ], 404);
        }

    }

    public function todayExams()
    {
        if (auth()->check()) {
            // Fetch parent orders with necessary relationships
            $this->parentOrders = ParentOrder::where('user_id', auth()->id())
                ->where('status', 'approved')
                ->where('ordered_for', '!=', 'product')
                ->with([
                    'course.courseSections.courseSectionContents' => function ($query) {
                        $query->whereDate('available_at', now())
                              ->whereIn('content_type', ['exam', 'written_exam']);
                    },
                    'batchExam.batchExamSections.batchExamSectionContents' => function ($query) {
                        $query->whereDate('available_at', now());
                    },
                ])
                ->get();

            if(!$this->parentOrders){
                return response()->json([
                    'status'   => false,
                    'message'   => "There are no scheduled classes available today.",
                ],404);
            }
            // Prepare course exams and batch exams
            $this->courseExams = [];
            $this->batchExams = [];

            foreach ($this->parentOrders as $parentOrder) {
                if ($parentOrder->ordered_for == 'course') {
                    foreach ($parentOrder->course->courseSections as $courseSection) {
                        $this->courseExams = array_merge(
                            $this->courseExams,
                            $courseSection->courseSectionContents->toArray()
                        );
                    }
                } elseif ($parentOrder->ordered_for == 'batch_exam') {
                    foreach ($parentOrder->batchExam->batchExamSections as $batchExamSection) {
                        $this->batchExams = array_merge(
                            $this->batchExams,
                            $batchExamSection->batchExamSectionContents->toArray()
                        );
                    }
                }
            }

            // Set data for response
            $this->data = [
                'courseExams' => $this->courseExams,
                'batchExams'  => $this->batchExams,
            ];

            return ViewHelper::checkViewForApi($this->data, 'frontend.student.todays-section.today-class');
        } else {
            return response()->json([
                'status'   => false,
                'message'   => "Please Login First!",
            ], 404);
        }

    }
}
