<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'university_id',
        'country_id',
        'city_id',
        'year',
        'result_id',
        'graduation_id',
        'remark_id',
        'image',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'year' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function graduation()
    {
        return $this->belongsTo(Graduation::class);
    }

    public function result()
    {
        return $this->belongsTo(Result::class);
    }

    public function remark()
    {
        return $this->belongsTo(Remark::class);
    }
}
