<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//use App\Models\Concerns\UuidTrait;

class Copy extends Model
{
    use HasFactory;

    protected $table = 'copy';

    protected $fillable = [
        'id',
        'title',
        'type',
        'domain',
        'priority',
        'description',
        'request_by',
        'assign_to',
        'copy_submission',
        'status'
    ];

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

//    public function campaigns(){
//        return $this->hasMany('App\Models\CampaignBrands');
//    }

}
