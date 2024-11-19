<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignTypeInfoGraphic extends Model
{
    use HasFactory;

    protected $table = 'campaign_type_info_graphic';

    protected $fillable = [
        'id',
        'author_id',
        'type',
        'launch_date',
        'product_line',
        'invision_link',
        'products_featured',
        'no_copy_necessary',
        'note',
        'date_created',
        'asset_id'
    ];

    protected $primaryKey = 'asset_id';
    protected $keyType = 'int';

}
