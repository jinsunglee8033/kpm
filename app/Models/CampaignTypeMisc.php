<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignTypeMisc extends Model
{
    use HasFactory;

    protected $table = 'campaign_type_misc';

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
