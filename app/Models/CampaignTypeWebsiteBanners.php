<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignTypeWebsiteBanners extends Model
{
    use HasFactory;

    protected $table = 'campaign_type_website_banners';

    protected $fillable = [
        'id',
        'author_id',
        'type',
        'launch_date',
        'banner',
        'banner_homepage',
        'banner_sidebar',
        'details',
        'no_copy_necessary',
        'copy',
        'products_featured',
        'click_through_links',
        'final_preview_link',
        'date_created',
        'asset_id'
    ];

    protected $primaryKey = 'asset_id';
    protected $keyType = 'int';

}
