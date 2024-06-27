@extends('frontend.master')

@section('body')
    {{\Illuminate\Support\Facades\Session::put('course_redirect_url',\Illuminate\Support\Facades\Request::url())}}


    <div class="privacy-policy-area py-5">
        <div class="container">
            <div class="section-title text-center">
                <h2 class="f-s-40"> গাইড লাইন </h2>
                <hr class="w-25 mx-auto bg-danger"/>
            </div>
            <div class="row p-t-20">
                <div class="col-lg-12">

                  <div class="card ab-shadow">
                      <div class="single-content py-3 pb-5 px-3 ">
                          <h2 class="f-s-37 mb-0">আপনার সফলতার গল্প শুরু হোক এখানেই</h2>
                          <p class="f-s-18"><a href="https://www.youtube.com/watch?v=NjqjVdVJX1g">যেভাবে ভর্তি হবেন</a></p>
                          <p class="f-s-17">আপনি যে কোর্সে ভর্তি হতে চাচ্ছেন সেই কোর্সে ক্লিক করুন। ভর্তি হতে <strong>এখানে ক্লিক করুন</strong> বাটনে ক্লিক করে টাকা পেমেন্ট করে রিকুয়েস্ট পাঠান । বিদ্যাবাড়ি টীম থেকে আপনাকে কনফার্ম করে আপনার মোবাইলে ম্যাসেজ দেবে। এর পরে আপনার নির্ধারিত ব্যাচে প্রবেশ করে সকল সার্ভিস গ্রহণ করুন। ধন্যবাদ ......</p>
                          <p class="f-s-17">আপনাকে সফল করতে বিদ্যাবাড়ি আছে আপনার পাশে।</p>
                      </div>
                  </div>

                </div>
            </div>
        </div>
    </div>

@endsection
