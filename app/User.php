<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password','role_id','phone','role_id','send_email','apikey'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];


	public function manageProject()
	{
		return $this->hasMany('App\Project','manager_id','id');
	}

	public function createProject()
	{
		return $this->hasMany('App\Project','client_id','id');
	}

    public function role()
    {
        return $this->belongsTo('App\Role','role_id','id');
    }

    public function checkRole($codeRoleArray)
    {

        if(is_array($codeRoleArray) && in_array($this->role->code,$codeRoleArray)){
            return true;
        }elseif($this->role->code==$codeRoleArray){
            return true;
        }
        return false;
    }

    public function setPasswordAttribute($password){
        $this->attributes["password"] = bcrypt($password);
    }
}
