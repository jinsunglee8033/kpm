<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignTypeWebsiteChanges extends Model
{
    use HasFactory;

    protected $table = 'campaign_type_website_changes';

    protected $fillable = [
        'id',
        'author_id',
        'type',
        'launch_date',
        'details',
        'products_featured',
        'copy',
        'developer_url',
        'date_created',
        'asset_id'
    ];

    protected $primaryKey = 'asset_id';
    protected $keyType = 'int';

}
