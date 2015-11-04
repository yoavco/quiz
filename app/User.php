<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

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
    protected $fillable = ['name', 'username', 'password', 'type'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quizzes()
    {
        return $this->hasMany('App\Quiz');
    }

    public function tests()
    {
        return $this->hasMany('App\Test');
    }

    public function isAdmin()
    {
        return $this->type == 'admin';
    }

    public function isExaminer()
    {
        return $this->type == 'examiner';
    }

    public function getTranslatedTypeAttribute()
    {
        if ($this->type == 'examiner')
            return 'mugallym';
        else if ($this->type == 'examinee')
            return 'okuwçy';
        return 'admin';
    }

    public function allowedQuizzes()
    {
        return $this->belongsToMany('App\Quiz');
    }
}
