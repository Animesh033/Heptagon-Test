<?php

namespace App\Models\Heptagon;

use Hashids\Hashids;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
        'status',
    ];

    protected $uploads = '/storage/images/';

    public function employees(){
        return $this->hasMany(Employee::class);
    }

    public function getLogoAttribute($logo)
    {
        $url = 'https://picsum.photos/200';
        if($logo)
            $url = $this->uploads.$logo;
        return $url;
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

    public function logoUrl($logo){
        return Storage::url($logo);
    }
}
