<?php

namespace App\Models;

use App\Models\Backend\AdditionalFeatureManagement\Affiliation\AffiliationHistory;
use App\Models\Backend\AdditionalFeatureManagement\Affiliation\AffiliationRegistration;
use App\Models\Backend\BatchExamManagement\BatchExamResult;
use App\Models\Backend\BlogManagement\Blog;
use App\Models\Backend\CircularManagement\Circular;
use App\Models\Backend\Course\CourseClassExamResult;
use App\Models\Backend\Course\CourseExamResult;
use App\Models\Backend\ExamManagement\Exam;
use App\Models\Backend\ExamManagement\ExamOrder;
use App\Models\Backend\ExamManagement\ExamResult;
use App\Models\Backend\ExamManagement\ExamSubscriptionPackage;
use App\Models\Backend\ExamManagement\SubscriptionOrder;
use App\Models\Backend\OrderManagement\ParentOrder;
use App\Models\Backend\QuestionManagement\FavouriteQuestion;
use App\Models\Backend\QuestionManagement\QuestionOption;
use App\Models\Backend\QuestionManagement\QuestionStore;
use App\Models\Backend\QuestionManagement\QuestionTopic;
use App\Models\Backend\RoleManagement\Role;
use App\Models\Backend\UserManagement\Student;
use App\Models\Backend\UserManagement\Teacher;
use App\Models\Frontend\AdditionalFeature\ContactMessage;
use App\Models\Frontend\CourseOrder\CourseOrder;
use App\Models\Scopes\Searchable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    use Searchable;
    use TwoFactorAuthenticatable;
    use HasProfilePhoto;
    use HasApiTokens;

    protected $fillable = ['name', 'email', 'password', 'status', 'mobile', 'device_token', 'profile_photo_path'];

    protected $searchableFields = ['*'];

    protected $hidden = ['password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected static $user, $users;

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($user){
            if (!empty($user->roles))
            {
                $user->roles()->detach();
            }
            if (!empty($user->teachers))
            {
                $user->teachers->each->delete();
            }
            if (!empty($user->students))
            {
                $user->students->each->delete();
            }
            if (!empty($user->blogs))
            {
                $user->blogs->each->delete();
            }
            if (!empty($user->questionTopics))
            {
                $user->questionTopics->each->delete();
            }
            if (!empty($user->questionStores))
            {
                $user->questionStores->each->delete();
            }
            if (!empty($user->questionOptions))
            {
                $user->questionOptions->each->delete();
            }
            if (!empty($user->examResults))
            {
                $user->examResults->each->delete();
            }
            if (!empty($user->courseOrders))
            {
                $user->courseOrders->each->delete();
            }
            if (!empty($user->subscriptionOrders))
            {
                $user->subscriptionOrders->each->delete();
            }
            if (!empty($user->batchExamResults))
            {
                $user->batchExamResults->each->delete();
            }
            if (!empty($user->parentOrders))
            {
                $user->parentOrders->each->delete();
            }
//            if (!empty($user->examResults))
//            {
//                $user->examResults->each->delete();
//            }
            if (!empty($user->exams))
            {
                $user->exams()->detach();
            }
            if (!empty($user->examSubscriptionPackages))
            {
                $user->examSubscriptionPackages()->detach();
            }
            if (!empty($user->courseExamResults))
            {
                $user->courseExamResults->each->delete();
            }
            if (!empty($user->batchExamOrderChecker))
            {
                $user->batchExamOrderChecker->each->delete();
            }
            if (!empty($user->circulars))
            {
                $user->circulars->each->delete();
            }
            if (!empty($user->contactMessages))
            {
                $user->contactMessages->each->delete();
            }
            if (!empty($user->courseClassExamResults))
            {
                $user->courseClassExamResults->each->delete();
            }
            if (!empty($user->parentOrders2))
            {
                $user->parentOrders2->each->delete();
            }
            if (!empty($user->affiliationRegistrations))
            {
                $user->affiliationRegistrations->each->delete();
            }
            if (!empty($user->affiliationHistories))
            {
                $user->affiliationHistories->each->delete();
            }
            if (!empty($user->favouriteQuestions))
            {
                //print_r($user->favouriteQuestions); die();
                //$user->favouriteQuestions()->detach();
                $user->favouriteQuestions->each->delete();
            }
        });
    }

    public static function createOrUpdateUser ($request, $id = null)
    {
        if (isset($id))
        {
            self::$user = User::find($id);
        } else {
            self::$user = new User();
        }
        self::$user->name       = $request->name;
        self::$user->email       = $request->email;
        self::$user->mobile       = $request->mobile;
        if ($request->hasFile('image'))
        {
            self::$user->profile_photo_path       = imageUpload($request->file('image'), 'user-images/', 'user', '280', '350', (isset($id) ? static::find($id)->image : null));
        }
        if (isset($request->password))
        {
            self::$user->password   = Hash::make($request->password);
        } else {
            if (isset($id))
            {
                self::$user->password   = User::find($id)->password;
            }
        }
        self::$user->status     = $request->status == 'on' ? 1 : ($request->request_form == 'student' ? 1 : 0);
        self::$user->save();
        if (empty($request->user_try_update) && $request->user_try_update != 1)
        {
            self::$user->roles()->sync($request->roles);
        }
        return self::$user;
    }

    public static function createOrUpdateUserAfterPayment($request, $password = null, $id = null)
    {
        if (isset($id))
        {
            self::$user = User::find($id);
        } else {
            if (!empty($existUser = User::where('mobile', $request->mobile)->first()))
            {
                self::$user = $existUser;
            } else {
                self::$user = new User();
            }
        }
        self::$user->name       = $request->name;
        self::$user->mobile       = $request->mobile;
//        if ($request->hasFile('image'))
//        {
//            self::$user->profile_photo_path       = imageUpload($request->file('image'), 'user-images/', 'user', '280', '350', (isset($id) ? static::find($id)->image : null));
//        }
        if (isset($password))
        {
            self::$user->password   = Hash::make($password);
            self::$user->p_code     = $password;
        } else {
            if (isset($id))
            {
                self::$user->password   = User::find($id)->password;
            }
        }
        self::$user->status     = 1;
        self::$user->save();
        if (empty($existUser))
        {
            self::$user->roles()->sync(['4']);
        }
        return self::$user;
    }
    public static function updateStudent($request, $id)
    {
        self::$user = User::find($id);
        self::$user->name       = $request->name;
        self::$user->email       = $request->email;
        self::$user->mobile       = $request->mobile;
        if ($request->hasFile('image'))
        {
            self::$user->profile_photo_path       = imageUpload($request->file('image'), 'user-images/', 'user', '280', '350', (isset($id) ? static::find($id)->image : null));
        }
        self::$user->save();
    }
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function admissionComissions()
    {
        return $this->hasMany(AdmissionComission::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }

    public function questionTopics()
    {
        return $this->hasMany(QuestionTopic::class, 'created_by');
    }

    public function questionStores()
    {
        return $this->hasMany(QuestionStore::class, 'created_by');
    }

    public function questionOptions()
    {
        return $this->hasMany(QuestionOption::class, 'created_by');
    }

    public function courseOrders()
    {
        return $this->hasMany(CourseOrder::class);
    }

    public function checkedBy()
    {
        return $this->hasMany(CourseOrder::class, 'checked_by');
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }

    public function examOrders()
    {
        return $this->hasMany(ExamOrder::class);
    }

    public function examOrdersChecker()
    {
        return $this->hasMany(ExamOrder::class, 'xm_order_checked_by');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class);
    }

    public function examSubscriptionPackages()
    {
        return $this->belongsToMany(ExamSubscriptionPackage::class);
    }

    public function subscriptionOrders()
    {
        return $this->hasMany(SubscriptionOrder::class);
    }

    public function isSuperAdmin()
    {
        return in_array($this->email, config('auth.super_admins'));
    }

    public function courseExamResults()
    {
        return $this->hasMany(CourseExamResult::class);
    }

    public function batchExamResults()
    {
        return $this->hasMany(BatchExamResult::class);
    }

    public function parentOrders()
    {
        return $this->hasMany(ParentOrder::class);
    }

    public function batchExamOrderChecker()
    {
        return $this->hasMany(ParentOrder::class, 'checked_by');
    }

    public function circulars()
    {
        return $this->hasMany(Circular::class);
    }

    public function contactMessages()
    {
        return $this->hasMany(ContactMessage::class);
    }

    public function parentComments()
    {
        return $this->hasMany(ParentComment::class);
    }

    public function parentComments2()
    {
        return $this->hasMany(ParentComment::class, 'checked_by');
    }

    public function courseClassExamResults()
    {
        return $this->hasMany(CourseClassExamResult::class);
    }

    public function parentOrders2()
    {
        return $this->hasMany(ParentOrder::class, 'referrer_id');
    }

    public function affiliationRegistrations()
    {
        return $this->hasMany(AffiliationRegistration::class);
    }

    public function affiliationHistories()
    {
        return $this->hasMany(AffiliationHistory::class);
    }

    public function favouriteQuestions()
    {
        return $this->hasMany(FavouriteQuestion::class);
    }
}
