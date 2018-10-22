<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Setting;
use Cache;

class SettingController extends Controller
{
    /** @var Setting */
    private $setting;

    /**
     * UserController Consturctor
     *
     * @param Setting $setting
     */
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

   /**
    * Settings
    *
    * @return Response
    */
    public function index()
    {
        $settingFields = $this->setting->getSettingTypes();
        return view('Admin.settings', ['settingFields' => $settingFields, 'settings' => $this->setting]);
    }

    /**
    * Store settings in database
    *
    * @param Request $request
    * @return Response
    */
    public function store(Request $request)
    {
        $settingData = $request->except('_token');

        foreach ($settingData as $key => $value) {
            $settting = $this->setting->findByKey($key);
            $settting->value = $value;
            $settting->save();
        }

        return redirect()->back()
            ->with('success','Settings saved successfully!');
    }

    /**
    * Clear Cache
    *
    * @return Response
    */
    public function clearCache()
    {
        Cache::flush();

        return redirect()->back()
            ->with('success','Cache has been Cleared!');
    }

}
