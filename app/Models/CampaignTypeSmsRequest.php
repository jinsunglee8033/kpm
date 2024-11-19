<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignTypeSmsRequest extends Model
{
    use HasFactory;

    protected $table = 'campaign_type_sms_request';

    protected $fillable = [
        'title',
        'id',
        'author_id',
        'type',
        'launch_date',
        'details',
        'products_featured',
        'no_copy_necessary',
        'copy',
        'developer_url',
        'date_created',
        'asset_id'
    ];

    protected $primaryKey = 'asset_id';
    protected $keyType = 'int';

}
