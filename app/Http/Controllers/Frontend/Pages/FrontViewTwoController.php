<?php

namespace App\Http\Controllers\Frontend\Pages;

use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
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
        if (auth()->check())
        {
            $this->parentOrders = ParentOrder::where(['user_id' => auth()->id(), 'ordered_for' => 'course', 'status' => 'approved'])->get();
            foreach ($this->parentOrders as $parentOrder)
            {
                foreach ($parentOrder->course->courseSections as $courseSection)
                {
                    foreach ($courseSection->courseSectionContents as $courseSectionContent)
                    {
                        if (showDate($courseSectionContent->available_at) == showDate(now()))
                        {
                            if ($courseSectionContent->content_type != 'exam' && $courseSectionContent->content_type != 'written_exam')
                            {
                                array_push($this->courseClassContents, $courseSectionContent);
                            }
                        }
                    }
                }
            }
            $this->data = [
                'courseClassContents'   => $this->courseClassContents
            ];
            return ViewHelper::checkViewForApi($this->data, 'frontend.student.todays-section.today-class');
        } else {
            return back()->with('error', 'Please Login First');
        }
    }

    public function todayExams()
    {
        if (auth()->check())
        {
            $this->parentOrders = ParentOrder::where(['user_id' => auth()->id(), 'status' => 'approved'])->where('ordered_for', '!=', 'product')->get();
            foreach ($this->parentOrders as $parentOrder)
            {
                if ($parentOrder->ordered_for == 'course')
                {
                    foreach ($parentOrder->course->courseSections as $courseSection)
                    {
                        foreach ($courseSection->courseSectionContents as $courseSectionContent)
                        {
                            if (showDate($courseSectionContent->available_at) == showDate(now()))
                            {
                                if ($courseSectionContent->content_type == 'exam' || $courseSectionContent->content_type == 'written_exam')
                                {
                                    array_push($this->courseExams, $courseSectionContent);
                                }
                            }
                        }
                    }
                } elseif ($parentOrder->ordered_for == 'batch_exam')
                {
                    foreach ($parentOrder->batchExam->batchExamSections as $batchExamSection)
                    {
                        foreach ($batchExamSection->batchExamSectionContents as $batchExamSectionContent)
                        {
                            if (showDate($batchExamSectionContent->available_at) == showDate(now()))
                            {
                                array_push($this->batchExams, $batchExamSectionContent);
                            }
                        }
                    }
                }
            }
            $this->data = [
                'courseExams'   => $this->courseExams,
                'batchExams'   => $this->batchExams,
            ];
            return ViewHelper::checkViewForApi($this->data, 'frontend.student.todays-section.today-exams');
        } else {
            return back()->with('error', 'Please Login First');
        }
    }
}
