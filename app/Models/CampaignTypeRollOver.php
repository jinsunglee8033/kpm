<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignTypeRollOver extends Model
{
    use HasFactory;

    protected $table = 'campaign_type_roll_over';

    protected $fillable = [
        'id',
        'author_id',
        'type',
        'launch_date',
        'sku',
        'products_featured',
        'notes',
        'date_created',
        'asset_id'
    ];

    protected $primaryKey = 'asset_id';
    protected $keyType = 'int';

}
