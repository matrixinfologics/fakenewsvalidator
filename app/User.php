<?php

namespace App;

use App\Company;
use App\Notifications\MailResetPasswordToken;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Aginev\SearchFilters\Filterable;
use Illuminate\Http\Request;
use ReflectionClass;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_COMPANY_ADMIN = 'company_admin';
    const ROLE_USER = 'user';
    const DEFAULT_ROLE = 'user';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }

    /**
     * Get the company that owns the user.
     */
    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    /**
    * Get cases of user.
    */
    public function cases()
    {
        return $this->hasMany('App\NewsCase');
    }

    /**
     * To check role of Admin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        if ($this->role == self::ROLE_ADMIN) {
            return true;
        }

        return false;
    }

    /**
     * To check role of Admin
     *
     * @return boolean
     */
    public function isCompanyAdmin()
    {
        if ($this->role == self::ROLE_COMPANY_ADMIN) {
            return true;
        }

        return false;
    }

    /**
     * To check role of Admin
     *
     * @return boolean
     */
    public function isUser()
    {
        if ($this->role == self::ROLE_USER) {
            return true;
        }

        return false;
    }

    /**
     * To check permission
     *
     * @param Request $request
     * @return boolean
     */
    public function hasPermissionToAction($request)
    {
        if($request->route('user')) {
            $user = User::find($this->id);
            $userCount = $user->company->users()->where('id', $request->route('user'))->count();

            if ($userCount > 0){
                return true;
            }

            return false;
        }

        if($request->route('company')) {
            $user = User::find($this->id);
            if($user->company->id == $request->route('company')){
                return true;
            }

            return false;
        }

        if($request->route('case')) {
            $user = User::find($this->id);
            $companyCases = $user->company->getCompanyCases($user->company)->get()->pluck('id')->toArray();

            if (in_array($request->route('case'), $companyCases)){
                return true;
            }

            return false;
        }


        return true;

    }

    /**
    * return full name of user
    *
    * @return string
    */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

     /**
    * return role of user
    *
    * @return string
    */
    public function getRoleNameAttribute()
    {
        return ucwords(strtolower(str_replace('_', ' ', $this->role)));
    }

    /**
     * Get Roles types as array
     *
     * @return array
     */
    public function getRolesAsArray()
    {
        $prefix = 'ROLE_';
        $reflection = new ReflectionClass(self::class);
        $constants  = $reflection->getConstants();

        $prefixLength = strlen($prefix);
        $options      = [];
        foreach ($constants as $name => $value) {
            if (substr($name, 0, $prefixLength) === $prefix) {
                $enumOptionName = ucwords(strtolower(str_replace('_', ' ', substr($name, $prefixLength))));
                $options[$value] = $enumOptionName;
            }
        }

        return $options;
    }

    /**
     * Get Users as array
     *
     * @param string $role
     * @return array
     */
    public function userListByRole($role){
        return User::where('role', $role)->get()->pluck('name', 'id');
    }

}
