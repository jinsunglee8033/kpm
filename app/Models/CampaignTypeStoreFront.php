<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignTypeStoreFront extends Model
{
    use HasFactory;

    protected $table = 'campaign_type_store_front';

    protected $fillable = [
        'id',
        'author_id',
        'type',
        'launch_date',
        'client',
        'products_featured',
        'notes',
        'invision_link',
        'date_created',
        'asset_id'
    ];

    protected $primaryKey = 'asset_id';
    protected $keyType = 'int';

}
