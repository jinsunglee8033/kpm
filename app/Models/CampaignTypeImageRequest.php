<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignTypeImageRequest extends Model
{
    use HasFactory;

    protected $table = 'campaign_type_image_request';

    protected $fillable = [
        'id',
        'author_id',
        'type',
        'launch_date',
        'client',
        'description',
        'image_dimensions',
        'image_ratio',
        'image_format',
        'max_filesize',
        'sku',
        'products_featured',
        'date_created',
        'asset_id'
    ];

    protected $primaryKey = 'asset_id';
    protected $keyType = 'int';

}
