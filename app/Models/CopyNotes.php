<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CopyNotes extends Model
{
    use HasFactory;

    protected $table = 'copy_notes';

    protected $fillable = [
        'id',
        'user_id',
        'copy_id',
        'type',
        'note',
        'created_at',
        'updated_at'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

}
