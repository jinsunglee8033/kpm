<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignTypeYoutubeCopy extends Model
{
    use HasFactory;

    protected $table = 'campaign_type_youtube_copy';

    protected $fillable = [
        'id',
        'author_id',
        'type',
        'launch_date',
        'information',
        'url_preview',
        'products_featured',
        'no_copy_necessary',
        'title',
        'description',
        'tags',
        'date_created',
        'asset_id'
    ];

    protected $primaryKey = 'asset_id';
    protected $keyType = 'int';

}
