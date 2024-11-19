<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignNotes extends Model
{
    use HasFactory;

    protected $table = 'campaign_notes';

    protected $fillable = [
        'id',
        'user_id',
        'asset_id',
        'type',
        'note',
        'date_created'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

//    protected $primaryKey = 'id';
//    protected $keyType = 'int';
//    public $incrementing = true;

}
