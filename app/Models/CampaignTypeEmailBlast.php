<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CampaignTypeEmailBlast extends Model
{
    use HasFactory;

    protected $table = 'campaign_type_email_blast';

    protected $fillable = [
        'id',
        'author_id',
        'type',
        'concept',
        'products_featured',
        'no_copy_necessary',
        'main_subject_line',
        'main_preheader_line',
        'alt_subject_line',
        'alt_preheader_line',
        'body_copy',
        'secondary_message',
        'click_through_links',
        'email_list',
        'email_blast_date',
        'video_link',
        'final_email_proof',
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
