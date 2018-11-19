<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Setting;
use App\NewsCase;
use App\User;
use Auth;


class Company extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';


    /**
     * Get users of company.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }


     /**
    * return full name of user
    *
    * @return string
    */
    public function getCompanyAdminAttribute()
    {
        return $this->users->where('role', User::ROLE_COMPANY_ADMIN)->first();
    }

    /**
    * Get comapny cases by user
    *
    * @param User|int $user
    */
    public function getCompanyCasesOfUser($user)
    {
        if (is_int($user)) {
            $user = User::find($user);
        }

        $companyUsers = $user->company->users()->get()->pluck('id');
        return NewsCase::whereIn('user_id', $companyUsers);
    }

    /**
    * Get comapny cases
    *
    * @param Company $company
    */
    public function getCompanyCases($company)
    {
        $companyUsers = $company->users()->get()->pluck('id');
        return NewsCase::whereIn('user_id', $companyUsers);
    }


    /**
    * return company api details
    *
    * @return array
    */
    public function getCompanyTwitterDetails()
    {
        $currentUser = Auth::user();

        if($currentUser->isCompanyAdmin() || $currentUser->isUser()) {
            $company = $currentUser->company;

            $companyTwitterDetails = [];

            if($company->twitter_consumer_key == '' || $company->twitter_consumer_secret == ''  || $company->twitter_access_token == ''  || $company->twitter_access_token_secret == ''){
                $settings = new Setting;
                $companyTwitterDetails['consumer_key'] = $settings->getSettingValueByKey('twitter_consumer_key');
                $companyTwitterDetails['consumer_secret'] = $settings->getSettingValueByKey('twitter_consumer_secret');
                $companyTwitterDetails['token'] = $settings->getSettingValueByKey('twitter_access_token');
                $companyTwitterDetails['secret'] = $settings->getSettingValueByKey('twitter_access_token_secret');
            } else {
                $companyTwitterDetails['consumer_key'] = $company->twitter_consumer_key;
                $companyTwitterDetails['consumer_secret'] = $company->twitter_consumer_secret;
                $companyTwitterDetails['token'] = $company->twitter_access_token;
                $companyTwitterDetails['secret'] = $company->twitter_access_token_secret;
            }

            return $companyTwitterDetails;
        }

    }

}
