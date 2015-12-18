<?php

namespace App\Models\Communication;

use Illuminate\Database\Eloquent\Model;

class CommunicationRead extends Model
{
   protected $table = 'communications_read';
   protected $fillable = ['communication_id', 'store_id', 'is_read'];
}
