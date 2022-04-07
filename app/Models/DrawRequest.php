<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DrawRequest extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['number', 'object_name', 'ship_type', 'company_id'];

    protected $searchableFields = ['*'];

    protected $table = 'draw_requests';

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function drawings()
    {
        return $this->hasMany(Drawing::class, 'request_id');
    }
}
