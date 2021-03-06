<?php

namespace App\Models\Heptagon;

use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'first_name',
        'last_name',
        'company_id',
        'email',
        'phone',
        'designation',
        'status',
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function getIdAttribute($id)
    {
        $hashids = new Hashids('', 10);
        return $hashids->encodeHex($id);
    }

    public function getStatusAttribute($status)
    {
        return ucwords($status);
    }

    public function setIdAttribute($id)
    {
        $hashids = new Hashids('', 10);
        $this->attributes['id'] = $hashids->decodeHex($id);
    }
}
