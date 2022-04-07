<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['name', 'location', 'email', 'telephone'];

    protected $searchableFields = ['*'];

    public function requests()
    {
        return $this->hasMany(DrawRequest::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
