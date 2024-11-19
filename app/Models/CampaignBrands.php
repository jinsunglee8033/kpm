<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//use App\Models\Concerns\UuidTrait;

class CampaignBrands extends Model
{
    use HasFactory;

    protected $table = 'campaign_brands';

    protected $fillable = [
        'id',
        'seq',
        'campaign_name',
        'field_name',
        'color',
        'logo_path',
    ];

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

//    public function campaigns(){
//        return $this->hasMany('App\Models\CampaignBrands');
//    }

}
