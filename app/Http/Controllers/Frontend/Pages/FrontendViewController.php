<?php

namespace App\Http\Controllers\Frontend\Pages;

use App\helper\ViewHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Checkout\CheckoutController;
use App\Http\Requests\Frontend\Order\ProductOrderRequest;
use App\Models\Backend\BatchExamManagement\BatchExam;
use App\Models\Backend\BlogManagement\Blog;
use App\Models\Backend\BlogManagement\BlogCategory;
use App\Models\Backend\CircularManagement\Circular;
use App\Models\Backend\CircularManagement\CircularCategory;
use App\Models\Backend\Course\Course;
use App\Models\Backend\OrderManagement\ParentOrder;
use App\Models\Backend\ProductManagement\Product;
use App\Models\Backend\ProductManagement\ProductDeliveryOption;
use App\Models\Backend\UserManagement\Teacher;
use App\Models\Frontend\AdditionalFeature\ContactMessage;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FrontendViewController extends Controller
{
    protected $courseCategories, $courseCategory, $courses, $course, $courseCoupon, $courseCoupons = [], $teachers = [], $blogs = [], $blogCategories = [], $blog, $blogCategory;
    protected $message, $status, $notices = [], $notice, $products = [], $product, $data, $exams = [], $examCategories = [], $homeSliderCourses = [];
    protected $comments = [], $jobCirculars = [], $jobCircular;
    public function allProducts ()
    {
        if (str()->contains(url()->current(), '/api/'))
        {
            $this->products = Product::whereStatus(1)->select('id','product_author_id', 'stock_amount','title','image','price', 'discount_amount', 'discount_start_date', 'discount_end_date', 'slug')->get();
        } else {
            $this->products = Product::whereStatus(1)->select('id','product_author_id', 'stock_amount','title','image','price', 'discount_amount', 'discount_start_date', 'discount_end_date', 'slug')->paginate(9);
        }
        foreach ($this->products as $product)
        {
            if (!empty($product->discount_start_date) && !empty($product->discount_end_date))
            {
                if (Carbon::now()->between(dateTimeFormatYmdHi($product->discount_start_date), dateTimeFormatYmdHi($product->discount_end_date)))
                {
                    $product->has_discount_validity = 'true';
                }
            } else {
                $product->has_discount_validity = 'false';
            }
            $product->image = asset($product->image);
//            $product->pdf = asset($product->pdf);
//            $product->featured_image = asset($product->featured_image);
            $product->order_status = ViewHelper::checkIfProductIsPurchased($product);
        }
        $this->data = [
            'products'  => $this->products
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.product.all-products');
    }

    public function productDetails($id, $slug = null)
    {
        $this->product = Product::where('id',$id)->select('id', 'product_author_id', 'title', 'image', 'featured_pdf', 'pdf', 'slug', 'description','price','discount_amount','discount_start_date','discount_end_date','about','specification','other_details' , 'stock_amount', 'is_featured', 'status')->first();
        if (!empty($this->product->discount_start_date) && !empty($this->product->discount_end_date))
        {
            if (Carbon::now()->between(dateTimeFormatYmdHi($this->product->discount_start_date), dateTimeFormatYmdHi($this->product->discount_end_date)))
            {
                $this->product->has_discount_validity = 'true';
            } else {
                $this->product->has_discount_validity = 'false';
            }
        } else {

            $this->product->has_discount_validity = 'false';
        }
        $this->product->order_status = ViewHelper::checkIfProductIsPurchased($this->product);
        if (isset($this->product))
        {
            $this->comments = ContactMessage::where(['status' => 1, 'type' => 'product', 'parent_model_id' => $this->product->id, 'is_seen' => 1])->get();
        }

        $latestProducts = Product::where(['status' => 1])->select('id', 'title', 'image', 'status', 'slug', 'price')->latest()->take(4)->get();
        if (str()->contains(url()->current(), '/api/'))
        {
            $this->product->image = asset($this->product->image);
            foreach ($latestProducts as $latestProduct)
            {
                $latestProduct->image = asset($latestProduct->image);
            }
        }
        $this->data = [
            'product'   => $this->product,
            'comments'  => $this->comments,
            'latestProducts' => $latestProducts
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.product.product-details');
    }

    public function placeProductOrder (Request $request)
    {

        if (auth()->check())
        {
            try {
                $emptyStatus = false;
                foreach (Cart::getContent() as $itemx)
                {
                    $product = Product::find($itemx->id);
                    if ($product->stock_amount > 0)
                    {
                        $emptyStatus = false;
                    } else {
                        $emptyStatus = true;
                    }
                }
                if ($emptyStatus == true)
                {
                    return redirect()->back()->with('error', 'Product Out of Stock.');
                }
                if ($request->payment_method == 'ssl')
                {
                    if (str()->contains(url()->current(), '/api/'))
                    {
                        ParentOrder::createOrderAfterSsl($request);
                        return response()->json(['success' => 'Payment completed successfully.']);
                    }
                    $request['details_url'] = url()->previous();
                    $request['model_name'] = 'product';
                    $request['ordered_for'] = 'product';
                    \session()->put('requestData', $request->all());
                    $getTotal = Cart::getTotal() +($request->ordered_for == 'product' && isset($request->delivery_charge) ? $request->delivery_charge : 0);
                    return CheckoutController::sendOrderRequestToSSLZ($getTotal, 'books');
                } elseif ($request->payment_method == 'cod')
                {
                    $this->validate($request, [
                        'vendor'    => 'required',
                        'paid_to'   => ['required', 'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'],
                        'paid_from' => ['required', 'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'],
                        'txt_id'    => 'required',
                    ]);
                    foreach (Cart::getContent() as $key => $item)
                    {
                        $product = Product::find($item->id);
//                        if ($product->stock_amount > 0)
//                        {
                            $request['total_amount']  = $item->price + ($request->ordered_for == 'product' && $key == 0 ? $request->delivery_charge : 0);
                            $request['parent_model_id']  = $item->id;
                            ParentOrder::orderProduct($request);
                            $product->stock_amount = $product->stock_amount -1;
                            if ($product->stock_amount == 0)
                            {
                                $product->is_stock = 0;
                            }
                            $product->save();
//                        } else {
//                            $emptyStatus = true;
//                        }
                    }
//                    if ($emptyStatus == true)
//                    {
//                        return redirect()->back()->with('error', 'Product Out of Stock.');
//                    }
                    Cart::clear();
                    return redirect()->route('front.home')->with('success', 'Products ordered submitted successfully.');
                }

            } catch (\Exception $exception)
            {
                return back()->with('error',$exception->getMessage());
//            return response()->json($exception->getMessage());
            }
        } else {
            return redirect()->route('login', ['rt' => base64_encode(url()->previous())])->with('error', 'Please Login First.');
        }
    }

    public function placeProductOrderFromApp(Request $request)
    {

    }

    public function viewCart ()
    {
        $this->data = [
            'cartContents'  => Cart::getContent(),
            'subTotal'      => Cart::getSubTotal(),
            'total'         => Cart::getTotal(),
            'deliveryCharge'=> ProductDeliveryOption::where('status', 1)->first()
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.product.view-cart');
    }

    public function addToCart (Request $request)
    {
//        return $request;
        try {
            $this->product = Product::find($request->product_id, ['id','title', 'price', 'image' ]);
            Cart::add([
                'id' => $this->product->id,
                'name' => $this->product->title,
                'price' => $request->price,
                'quantity' => 1,
                'attributes' => [
                    'image' => $this->product->image,
                ]
            ]);
            $data['msg'] = 'Product added in cart';
            $data['status'] = 'success';
//            $data['cart_count'] = Cart::where('user_id',auth()->id())->count();
//            return $data;
            return ViewHelper::returnSuccessMessage('Product added to cart successfully.');
//            return back()->with('success', 'Product added to cart successfully.');
        } catch (\Exception $exception)
        {
//            return back()->with('error',$exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }
    public function addToCarthome (Request $request)
    {
//        return $request;
        try {
            $this->product = Product::find($request->product_id, ['id','title', 'price', 'image' ]);
            Cart::add([
                'id' => $this->product->id,
                'name' => $this->product->title,
                'price' => $request->price,
                'quantity' => 1,
                'attributes' => [
                    'image' => $this->product->image,
                ]
            ]);
            $data['msg'] = 'Product added in cart';
            $data['status'] = 'success';
//            $data['cart_count'] = Cart::where('user_id',auth()->id())->count();
            return $data;
            return ViewHelper::returnSuccessMessage('Product added to cart successfully.');
//            return back()->with('success', 'Product added to cart successfully.');
        } catch (\Exception $exception)
        {
//            return back()->with('error',$exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }

    public function removeFromCart ($id)
    {
        Cart::remove($id);
        return ViewHelper::returnSuccessMessage('Item removed from cart successfully.');
//        return back()->with('success', 'Item removed from cart successfully.');
    }

    public function allBLogs ()
    {
        $this->blogCategories = BlogCategory::whereStatus(1)->orderBy('order', 'ASC')->select('id', 'name', 'parent_id', 'image', 'slug')->get();
        $this->blogs = Blog::whereStatus(1)->with(['blogCategory' => function($blogCategory){
            $blogCategory->select('id', 'name', 'slug')->get();
        }])->paginate(9);
        if (str()->contains(url()->current(), '/api/'))
        {
            foreach ($this->blogCategories as $blogCategory)
            {
                $blogCategory->image = asset($blogCategory->image);
            }
            foreach ($this->blogs as $blog)
            {
                $blog->image = asset($blog->image);
            }
        }
        $this->data = [
            'blogCategories'    => $this->blogCategories,
            'blogs'             => $this->blogs,
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.blogs.blog');
    }

    public function categoryBlogs ($id, $slug = null)
    {
        $this->blogs = BlogCategory::whereSlug($slug)->first()->blogs()->paginate(9);
        $this->blogCategory = BlogCategory::whereSlug($slug)->select('id', 'parent_id', 'name', 'slug')->first();
        $this->data = [
            'blogs'    => $this->blogs,
            'blogCategory'  => $this->blogCategory
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.blogs.category-blogs');
    }

    public function blogDetails ($id, $slug = null)
    {
        $this->blog = Blog::find($id);
        if (isset($this->blog))
        {
            $this->comments = ContactMessage::where(['status' => 1, 'type' => 'blog', 'parent_model_id' => $this->blog->id, 'is_seen' => 1])->get();
        }
        $this->blog->image = asset($this->blog->image);
        $this->data = [
            'blog'    => $this->blog,
            'recentBlogs'   => Blog::whereStatus(1)->latest()->select('id', 'title', 'image', 'slug', 'created_at')->take(6)->get(),
            'comments'      => $this->comments
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.blogs.blog-details');
    }

    public function allJobCirculars()
    {
//        $this->jobCirculars = Circular::whereStatus(1)->latest()->select('id', 'slug', 'image', 'circular_category_id', 'user_id', 'job_title', 'created_at')->paginate(12);
        $this->jobCirculars = CircularCategory::whereStatus(1)->select('id', 'title', 'image')->whereHas('circulars')->with(['circulars' => function($circulars){
            $circulars->whereStatus(1)->latest()->select('id', 'slug', 'image', 'circular_category_id', 'user_id', 'job_title', 'created_at')->get();
        }])->get();
        if (str()->contains(url()->current(), '/api/'))
        {
            $jobCircularCategories = CircularCategory::where(['status' => 1])->select('id', 'title', 'image')->get();
            foreach ($this->jobCirculars as $jobCircular)
            {
                $jobCircular->image = asset($jobCircular->image);
                foreach ($jobCircular->circulars as $circular)
                {
                    $circular->image = asset($circular->image);
                }
            }
            return response()->json([
                'circularCategories'    => $jobCircularCategories,
                'circulars'     => $this->jobCirculars
            ]);
        }
        $this->data = [
            'circularCategories' => $this->jobCirculars,
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.job-circulars.circular');
    }

    public function jobCircularDetail($id, $slug = null)
    {
        $this->jobCircular  = Circular::find($id);
        $this->jobCirculars = Circular::whereStatus(1)->where('id', '!=', $id)->latest()->take(6)->select('id', 'post_title', 'image', 'slug', 'created_at')->get();
        if (str()->contains(url()->current(), '/api/'))
        {
            $this->jobCircular->image = asset($this->jobCircular->image);
            foreach ($this->jobCirculars as $jobCircular)
            {
                $jobCircular->image = asset($jobCircular->image);
            }
        }
        $this->data = [
            'circular' => $this->jobCircular,
            'recentPosts' => $this->jobCirculars,
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.job-circulars.circular-detail');
    }

    public function newContact (Request $request)
    {

        if (auth()->check())
        {
            $request->validate([
                'name'  => 'required',
                'email'  => 'required',
                'mobile'  => ['required', 'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'],
                'message'  => 'required',
            ]);
            try {
                ContactMessage::createOrUpdateContactMessage($request);
                return back()->with('success', 'Thanks for your message.');
            } catch (\Exception $exception)
            {
                return back()->with('error', $exception->getMessage());
            }
        }
        return back()->with('error', 'Please Login First.');
    }

    public function instructors ()
    {
        $this->teachers = Teacher::whereStatus(1)->select('id','user_id', 'first_name', 'last_name', 'image', 'subject', 'status', 'github', 'twitter', 'linkedin', 'whatsapp', 'facebook', 'website')->paginate(12);
        $this->data = [
            'teachers'  => $this->teachers
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.instructors.instructors');
    }

    public function newComment (Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);
        ContactMessage::createOrUpdateContactMessage($request);
        return ViewHelper::returnSuccessMessage('Comment submitted successfully.');
//        return back()->with('success', 'Comment submitted successfully.');
    }

    public function instructorDetails ($id, $slug = null)
    {
        $teacher = Teacher::find($id);
        $this->data = [
            'teacher'   => $teacher,
            'latestCourses' => Course::whereStatus(1)->latest()->take(6)->get(),
        ];
        return ViewHelper::checkViewForApi($this->data, 'frontend.instructors.instructors-details');
    }
}
