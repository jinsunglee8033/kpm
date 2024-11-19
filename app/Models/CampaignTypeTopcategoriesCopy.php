<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignTypeTopcategoriesCopy extends Model
{
    use HasFactory;

    protected $table = 'campaign_type_topcategories_copy';

    protected $fillable = [
        'id',
        'author_id',
        'type',
        'launch_date',
        'no_copy_necessary',
        'copy',
        'click_through_links',
        'date_created',
        'asset_id'
    ];

    protected $primaryKey = 'asset_id';
    protected $keyType = 'int';

}
