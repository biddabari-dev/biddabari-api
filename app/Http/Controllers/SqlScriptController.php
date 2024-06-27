<?php

namespace App\Http\Controllers;

use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseSection;
use App\Models\Backend\Course\CourseSectionContent;
use App\Models\Backend\RoleManagement\Role;
use App\Models\Backend\UserManagement\Student;
use App\Models\Course_user;
use App\Models\CourseStudent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqlScriptController extends Controller
{
    public function script()
    {
//        return 'sarowar';


//        $users=User::select(['mobile'])->where('mobile','like','1%')->get();
//        $users=User::where('mobile','like','1%')->get();
        $users=Student::where('mobile','like','1%')->get();
//        return $users;
//        $alluser=User::all();
        foreach ($users as $user){
            $user->mobile  ='0'.$user->mobile;

            $user->save();
//            print $user->mobile;
//            print_r('\n');
////            User::updated('mobile',$user->mobile);
//            $user->update(['moble' => '0'.$user->mobile]);
//            $user->save();
        }

        return redirect('/')->with('success','user update successfully');
    }
    
      public function coursecreate()
    {
        $course=DB::table('courses_new_test_sar')->where('title','A-Z BCS Question Hacks (Live Batch)')->first();
        $newcourse=Course::where('title',$course->title)->first();
        if ($newcourse == null){
            $necourse=new Course();
            $necourse->title=$course->title;
            $necourse->sub_title=$course->subtitle;
            $necourse->banner=$course->photo;
            $necourse->description=$course->description;
            $necourse->price=$course->price;
            $necourse->duration_in_month=$course->duration;
            $necourse->starting_date_time=$course->created_at;
            $necourse->status=$course->active;
            $necourse->is_approved=$course->approved;
            $necourse->is_paid='1';
            $necourse->save();
        }else{
            return '0';
        }
        return redirect()->route('home')->with('course create successfully');
    }
    
    public function sqlcours_section()
    {
//        $users = DB::select('select * from courses_test_sarowar ');
        $course=Course::where('id','604')->first();
        $users = DB::table('courses_new_test_sar')->where('id','445')->first();
        $sections=DB::table('sections')->where('course_id',$users->id)->get();
        $order=0;
        foreach ($sections as $section){
            $order=$order+1;
            $co_section=new CourseSection();
            $co_section->title =$section->title;
            $co_section->course_id =$course->id;
             $co_section->available_at =strtotime($section->available_at);
            $co_section->status ='1';
            $co_section->order =$order;
            $co_section->save();
        }

        return 'section upload successfully';
    }
    
    public function course_content_delete(string $id=null)
    {
        $course_id= Course::find($id);
        $course_sections=CourseSection::where('course_id',$course_id->id)->get();

        foreach ($course_sections as $section){
//            dd($section);
            $count=0;
            foreach ($course_sections as $sec){
                if ($section->title == $sec->title){
                    if ($count > 0){
//                        $section_contents=CourseSectionContent::where('course_section_id',$section->id)->get();
//                        $deleted = DB::table('course_section_contents')->where('course_section_id', '=', $sec->id)->delete();
                        $sec->delete();
//                        return 'delete';
//                        CourseSectionContent::whereIn('id',$section_contents->id)->delete();
//                        DB::table('table_name')->whereIn('id', $ids)->delete();
//                        CourseSectionContent::distroy($section_contents->id);
//                        $section_contents->query()->delete();
                        print $sec->title;
                    }

                    $count=$count+1;
                }

            }
            $section_contents=CourseSectionContent::where('course_section_id',$section->id)->get();
            foreach ($section_contents as $cont){
                $num=0;
                foreach ($section_contents as $sec_con){
                    if ($cont->title == $sec_con->title){
                        if ($num > 0){
                            $sec_con->delete();
                        }
                        $num=$num+1;
                    }
                }
            }

//return 'done';
        }
        return 'no delete';
    }

    public function course_section_data()
    {
        $course=Course::where('id','604')->first();
        $sections=CourseSection::where('course_id',$course->id)->get();

        $users = DB::table('courses_new_test_sar')->where('id','445')->first();
        // return $users;
        $sections_old=DB::table('sections')->where('course_id',$users->id)->get();
        foreach ($sections_old as $oldsec){
//            return $oldsec;
            foreach ($sections as $section){
                if ($oldsec->title == $section->title){
                    $contents=DB::table('contents')->where('contentable_id',$oldsec->id)->get();
                    $order=0;
                    foreach ($contents as $content){
                        $order=$order+1;
                        $newcontent=new CourseSectionContent();
                        $newcontent->course_section_id=$section->id;
                        $newcontent->content_type=$content->type;
                        if ($content->type == 'video'){
                            $vid=DB::table('videos')->where('content_id',$content->id)->first();
                            $newcontent->video_link = $vid->link;
                            $newcontent->video_vendor= 'youtube';
                        }
                         if ($content->type == 'pdf'){
                            $pdf=DB::table('pdfs')->where('content_id',$content->id)->first();
                            if (isset($pdf)){
                                $newcontent->pdf_link  = $pdf->link;
                            }
//                            $newcontent->video_vendor= 'youtube';
                        }
                        if ($content->type == 'note'){
                            $note=DB::table('existing_notes')->where('content_id',$content->id)->first();
                            if (isset($note)){
                                $newcontent->note_content  = $note->body;
                            }
//                            $newcontent->video_vendor= 'youtube';
                        }
                        $newcontent->title=$content->title;
                        $newcontent->order=$order;
                        $newcontent->status='1';
                        $newcontent->save();
                    }
//                    return $contents;
                }
            }
        }
        return 'data update successfully';

    }
    public function getbatchstudent(string $id)
    {
//return $id;

        $student=[];
//        array_push($student,'sarowar');
//        return $student;
//        $users=User::all();
//        $co=Course::find($id);
        $courses= CourseStudent::where('course_id',$id)->get();
//        return $co;
//       foreach ($users as $user){
//           $user=User::where($course->user_id,'id')->first();
        foreach ($courses as $course){
            $data=User::where('id',$course->user_id)->first();
            if (isset($data->mobile)){
                array_push($student,$data->mobile);
            }

//               foreach ($users as $user){
//
//               }
//               if ($course->user_id ==$user->id){
//                   array_push($student,$user->mobile);
//               }
        }

//       }
//       $user=User::
//        $course=Course::all();
        return $student;


    }
}
