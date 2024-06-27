<?php


namespace App\helper;


use App\Models\Backend\BatchExamManagement\BatchExam;
use App\Models\Backend\BatchExamManagement\BatchExamResult;
use App\Models\Backend\BatchExamManagement\BatchExamSection;
use App\Models\Backend\BatchExamManagement\BatchExamSectionContent;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseClassExamResult;
use App\Models\Backend\Course\CourseExamResult;
use App\Models\Backend\Course\CourseSection;
use App\Models\Backend\ExamManagement\ExamOrder;
use App\Models\Backend\ExamManagement\SubscriptionOrder;
use App\Models\Backend\OrderManagement\ParentOrder;
use App\Models\Frontend\CourseOrder\CourseOrder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class ViewHelper
{
    protected static $loggedUser, $courseOrder, $examOrder,$examOrders = [], $subscriptionPackage, $subscriptionOrder, $status = 'false';

    public static function checkViewForApi ($data=[], $viewPath = null, $jsonErrorMessage = null)
    {
        if (str()->contains(url()->current(), '/api/'))
        {
            if (str()->contains(url()->current(), '/v1/'))
            {
                if (empty($data))
                {
                    return response()->json(isset($jsonErrorMessage) ? $jsonErrorMessage : 'Something went wrong. Please try again.', 400);
                }
                return response()->json($data, 200);
            }
        } else {

            return view($viewPath, $data);
        }
    }

    public static function returEexceptionError ($message = null)
    {
        if (str()->contains(url()->current(), '/api/'))
        {
            return response()->json(['error' => $message], 400);
        } else {
            return back()->with('error', $message);
        }
    }
    public static function returnSuccessMessage ($message = null)
    {
        if (str()->contains(url()->current(), '/api/'))
        {
            return response()->json(['success' => $message], 200);
        } else {
            return back()->with('success', $message);
        }
    }

    public static function authCheck()
    {
        if (str_contains(url()->current(), '/api/'))
        {
            return auth('sanctum')->check();
        } else {
            return auth()->check();
        }
    }

    public static function loggedUser()
    {
        if (str_contains(url()->current(), '/api/'))
        {
            return auth('sanctum')->user();
        } else {
            return auth()->user();
        }
    }

    public static function checkIfCourseIsEnrolled($course)
    {
        if (self::authCheck())
        {

            self::$loggedUser = ViewHelper::loggedUser();

             self::$courseOrder = ParentOrder::where(['user_id' => self::$loggedUser->id, 'ordered_for' => 'course'])->where('parent_model_id', $course->id)->first();
            if (!empty(self::$courseOrder))
            {
                if (self::$courseOrder->status == 'pending')
                {
                    return 'pending';
                } elseif (self::$courseOrder->status == 'approved')
                {
                    return self::$status = 'true';
                }
            } else {
                return self::$status = 'false';
            }
        }
        return self::$status = 'false';
    }
    public static function checkIfProductIsPurchased($product)
    {
        if (self::authCheck())
        {

            self::$loggedUser = ViewHelper::loggedUser();

             self::$courseOrder = ParentOrder::where(['user_id' => self::$loggedUser->id, 'ordered_for' => 'product'])->where('parent_model_id', $product->id)->first();
            if (!empty(self::$courseOrder))
            {
                if (self::$courseOrder->status == 'pending')
                {
                    return 'pending';
                } elseif (self::$courseOrder->status == 'approved')
                {
                    return self::$status = 'true';
                }
            } else {
                return self::$status = 'false';
            }
        }
        return self::$status = 'false';
    }

    public static function checkIfExamCategoryIsEnrolled($examCategory = null)
    {
        if (self::authCheck())
        {
            if (str_contains(url()->current(), '/api/'))
            {
                self::$loggedUser = auth('sanctum')->user();
            } else {
                self::$loggedUser = auth()->user();
            }
            if (!empty(self::$loggedUser->examSubscriptionPackages))
            {
                foreach (self::$loggedUser->examSubscriptionPackages as $examSubscriptionPackage)
                {
                    if ($examSubscriptionPackage->valid_to >= Carbon::today()->format('Y-m-d'))
                    {
                        self::$status = 'true';
                    }
                }
                if (self::$status == 'false')
                {
                    self::$status = self::checkUserExamOrderEnrollment(self::$loggedUser, $examCategory);
                }
            } else
            {
                self::$status = self::checkUserExamOrderEnrollment(self::$loggedUser, $examCategory);
            }
            return self::$status;
        } else {
            return 'false';
        }
    }

    public static function checkUserBatchExamIsEnrollment ($loggedUser, $exam)
    {
        if (self::authCheck())
        {
            if (!empty($loggedUser->parentOrders))
            {
                self::$examOrder = ParentOrder::where([ 'user_id' => $loggedUser->id, 'ordered_for' => 'batch_exam', 'parent_model_id' => $exam->id])->first();
                if (!empty(self::$examOrder))
                {
                    if (self::$examOrder->status == 'approved')
                    {
                        return self::$status = 'true';
                    } elseif (self::$examOrder->status == 'pending')
                    {
                        return self::$status = 'pending';
                    }

                }
            }
        }
        return self::$status = 'false';
    }

    public static function checkIfBatchExamIsEnrollmentAndHasValidity ($loggedUser, $batchExam)
    {
        if (!empty($loggedUser->parentOrders))
        {
            self::$examOrders = ParentOrder::where(['ordered_for' => 'batch_exam', 'parent_model_id' => $batchExam->id, 'user_id' => $loggedUser->id])->get();
//            return self::$examOrder = ParentOrder::where('ordered_for' , 'batch_exam')->where('parent_model_id' , $batchExam->id)->where('user_id' , $loggedUser->id)->first();
            if (isset(self::$examOrders))
            {
                foreach (self::$examOrders as $examOrder)
                {
                    $expireDate = $examOrder->updated_at->addDays($examOrder->batchExamSubscription->package_duration_in_days ?? 0);
                    if (Carbon::parse($expireDate)->format('Y-m-d H:i') > Carbon::now()->format('Y-m-d H:i'))
                    {
                        if ($examOrder->status == 'approved')
                        {
                            return self::$status = 'true';
                        } elseif ($examOrder->status == 'pending')
                        {
                            return self::$status = 'pending';
                        }
                    }
                }
            }
        }
        return self::$status = 'false';
    }

    public static function checkIfUserHasValidSubscription ()
    {
        if (str_contains(url()->current(), '/api/'))
        {
            self::$loggedUser = auth('sanctum')->user();
        } else {
            self::$loggedUser = auth()->user();
        }
        if (!empty(self::$loggedUser->subscriptionOrders))
        {
            foreach (self::$loggedUser->subscriptionOrders as $subscriptionOrder)
            {
                if ($subscriptionOrder->examSubscriptionPackage->valid_to > Carbon::today()->format('d-m-Y'))
                {
                    self::$status = 'true';
                    break;
                }
            }
        }
        return self::$status;
    }

    public static function checkIfSubscriptionIsPurchased($subscription)
    {
        if (self::authCheck())
        {
            if (str_contains(url()->current(), '/api/'))
            {
                self::$loggedUser = auth('sanctum')->user();
            } else {
                self::$loggedUser = auth()->user();
            }
            if (isset($subscription))
            {
                self::$subscriptionOrder = SubscriptionOrder::where(['exam_subscription_package_id' => $subscription->id, 'user_id' => self::$loggedUser->id])->first();
                if (!empty(self::$subscriptionOrder))
                {
                    return self::$status = 'true';
                }
            }
        } else {
            return self::$status = 'false';
        }
        return self::$status;
    }

    public static function checkClassXmStatus($courseSectionContent)
    {
        $userExistClassXm = CourseClassExamResult::where(['course_section_content_id' => $courseSectionContent->id, 'user_id' => auth()->id()])->first();
        if (isset($userExistClassXm))
        {
            if ($userExistClassXm->status == 'pass')
            {
                return '1';
            } else {
                return '0';
            }
        } else {
            return '0';
        }
    }

    public static function checkCourseExamParticipateStatus($contentId)
    {
        self::$status = 'false';
        $existExamResult = CourseExamResult::where(['course_section_content_id' => $contentId, 'user_id' => ViewHelper::loggedUser()->id])->first();
        if (!empty($existExamResult))
        {
            return self::$status = 'true';
        }
        return self::$status;
    }

    public static function checkBatchExamParticipateStatus($contentId)
    {
        self::$status = 'false';
        $existExamResult = BatchExamResult::where(['batch_exam_section_content_id' => $contentId, 'user_id' => ViewHelper::loggedUser()->id])->first();
        if (!empty($existExamResult))
        {
            return self::$status = 'true';
        }
        return self::$status;
    }

    public static function checkIfCourseOrBatchExamHasValidDiscount($modelName, $modelId)
    {
        if ($modelName == 'course')
        {
            $course = Course::find($modelId);
            if ($course)
            {
                if ($course->discount_amount > 0 && $course->discount_start_date_timestamp <= strtotime(currentDateTimeYmdHi()) && $course->discount_end_date_timestamp >= strtotime(currentDateTimeYmdHi()))
                {
                    self::$status = 'true';
                }
            }
        } elseif ($modelName = 'batch_exam')
        {
            $batchExam = Course::find($modelId);
            if ($batchExam)
            {
                if ($batchExam->discount_amount > 0 && $batchExam->discount_start_date_timestamp <= strtotime(currentDateTimeYmdHi()) && $batchExam->discount_end_date_timestamp >= strtotime(currentDateTimeYmdHi()))
                {
                    self::$status = 'true';
                }
            }
        }
        return self::$status;
    }

    public static function getModelPriceAfterDiscount ($modelName, $modelId)
    {
        if ($modelName == 'course')
        {
            $course = Course::find($modelId);
            $ifModelHasValidDiscount = self::checkIfCourseOrBatchExamHasValidDiscount($modelName, $modelId);
            if ($ifModelHasValidDiscount == 'true')
            {
                if ($course->discount_type == 1)
                {
                    return $course->price - $course->discount_amount;
                } elseif ($course->discount_type == 2)
                {
                    return $course->price - ($course->price * $course->discount_amount)/100;
                }
            } else{
                return $course->price;
            }
        } elseif ($modelName == 'batch_exam')
        {
            $batchExam = BatchExam::find($modelId);
            $ifModelHasValidDiscount = self::checkIfCourseOrBatchExamHasValidDiscount($modelName, $modelId);
            if ($ifModelHasValidDiscount == 'true')
            {
                if ($batchExam->discount_type == 1)
                {
                    return $batchExam->price - $batchExam->discount_amount;
                } elseif ($batchExam->discount_type == 2)
                {
                    return $batchExam->price - ($batchExam->price * $batchExam->discount_amount)/100;
                }
            } else{
                return $batchExam->price;
            }
        }
    }

    public static function reorderSerials($modelType, $modelParentId)
    {
        if ($modelType == 'course_section')
        {
            $course = Course::find($modelParentId);
            foreach ($course->courseSectionsByOrder as $key => $courseSection)
            {
                $courseSection->order   = ++$key;
                $courseSection->save();
            }
        } elseif ($modelType == 'course_section_content')
        {
            $courseSection = CourseSection::find($modelParentId);
            foreach ($courseSection->courseSectionContents as $index => $courseSectionContent)
            {
                $courseSectionContent->order    = ++$index;
                $courseSectionContent->save();
            }
        }elseif ($modelType == 'batch_exam_section')
        {
            $batchExam = BatchExam::find($modelParentId);
            foreach ($batchExam->batchExamSectionsByOrder as $k => $BatchExamSection) {
                $BatchExamSection->order = ++$k;
                $BatchExamSection->save();
            }
        } elseif ($modelType == 'batch_exam_section_content')
        {
            $BatchExamSection = BatchExamSection::find($modelParentId);
            foreach ($BatchExamSection->batchExamSectionContents as $i => $batchExamSectionContent)
            {
                $batchExamSectionContent->order    = ++$i;
                $batchExamSectionContent->save();
            }
        }
    }

    public static function paginateContentByArrayFormat($request, $collectObject, $perPage, $additionalParameter = null)
    {
        // Paginate the courses manually
        $page = $request->has('page') ? $request->page : 1;
        $totalItems = count($collectObject);
        $totalPages = ceil($totalItems / $perPage);
        // Slice the courses based on pagination parameters
        $currentPageCourses = array_slice($collectObject->toArray(), ($page - 1) * $perPage, $perPage);
        // Create a paginator instance manually
        $paginator = new LengthAwarePaginator(
            $currentPageCourses,
            $totalItems,
            $perPage,
            $page,
            ['path' => $request->url()]
        );

        return $paginator;
    }

    public static function paginateContentByCollectionFormat($request, $collectObject, $perPage, $additionalParameter = null)
    {
        // Paginate the courses manually
        $page = $request->has('page') ? $request->page : 1;
        // Get the current page's courses
        $currentPageCourses = $collectObject->forPage($page, $perPage);
        // Create a paginator instance manually
        $paginator = new LengthAwarePaginator(
            $currentPageCourses,
            $collectObject->count(), // Total items count
            $perPage,
            $page,
            ['path' => $request->url()]
        );

        $extra_parameter = $request->input($additionalParameter);
        if ($extra_parameter) {
            $paginator->appends('category_id' , $extra_parameter);
        }

        // Convert the paginator items to a Collection
        $paginator->setCollection(collect($currentPageCourses));
        return $paginator;
    }
}
