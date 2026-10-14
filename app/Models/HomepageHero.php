<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageHero extends Model
{
    protected $fillable = ['headline', 'subheadline', 'cta_text', 'cta_link'];
}
