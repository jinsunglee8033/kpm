<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignTypeLandingPage extends Model
{
    use HasFactory;

    protected $table = 'campaign_type_landing_page';

    protected $fillable = [
        'id',
        'author_id',
        'type',
        'launch_date',
        'details',
        'no_copy_necessary',
        'copy',
        'products_featured',
        'landing_url',
        'developer_url',
        'final_preview_link',
        'date_created',
        'asset_id'
    ];

    protected $primaryKey = 'asset_id';
    protected $keyType = 'int';

}
