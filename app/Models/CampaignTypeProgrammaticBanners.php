<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignTypeProgrammaticBanners extends Model
{
    use HasFactory;

    protected $table = 'campaign_type_programmatic_banners';

    protected $fillable = [
        'id',
        'author_id',
        'type',
        'date_from',
        'date_to',
        'include_formats',
        'display_dimension',
        'no_copy_necessary',
        'copy',
        'products_featured',
        'click_through_links',
        'promo_code',
        'date_created',
        'asset_id'
    ];

    protected $primaryKey = 'asset_id';
    protected $keyType = 'int';

}
