<?php

namespace App\Models\Backend\QuestionManagement;

use App\Models\Scopes\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FavouriteQuestion extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['user_id', 'question_store_id'];

    protected $searchableFields = ['*'];

    protected $table = 'favourite_questions';

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function questionStore()
    {
        return $this->belongsTo(QuestionStore::class);
    }

    public function questionTopic()
    {
        return $this->belongsTo(QuestionTopic::class);
    }
}
