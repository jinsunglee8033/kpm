<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignTypeSocialAd extends Model
{
    use HasFactory;

    protected $table = 'campaign_type_social_ad';

    protected $fillable = [
        'id',
        'author_id',
        'type',
        'date_from',
        'date_to',
        'include_formats',
        'dark_post',
        'pinterest_post',
        'pinterest_carousel',
        'igfb_stories',
        'igfb_post',
        'collection',
        'carousel',
        'ecommerce_post',
        'note',
        'text',
        'text_2',
        'text_3',
        'headline',
        'headline_2',
        'headline_3',
        'newsfeed',
        'newsfeed_2',
        'newsfeed_3',
        'terms_and_conditions',
        'products_featured',
        'no_copy_necessary',
        'copy_inside_graphic',
        'click_through_links',
        'google_drive_link',
        'utm_code',
        'promo_code',
        'budget_code',
        'final_preview_link',
        'date_created',
        'asset_id'
    ];

//    public function users()
//    {
//        return $this->belongsTo(User::class, 'user_id', 'id');
//    }

    protected $primaryKey = 'asset_id';
    protected $keyType = 'int';
//    public $incrementing = true;

}
