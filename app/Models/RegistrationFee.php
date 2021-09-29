<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Malico\MeSomb\Helper\HasPayments;

class RegistrationFee extends Model
{
    use HasFactory;
    use HasPayments;

    protected $guarded = [];
}