<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Db_distro extends Model
{
    use SoftDeletes;
	
	protected $table = 'db_distros';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];
}
