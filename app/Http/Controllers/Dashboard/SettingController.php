<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use Exception;

class SettingController extends DashboardController
{
    public function showSettings(Request $request)
    {
    	return view('dashboard.settings', ['info' => $request->input('info'), 'settings' => Setting::all()->first()]);
    }

    public function editSettings(Request $request)
    {
    	try
    	{
	    	$settings = Setting::all()->first();
	    	$form_errors = [];
	    	if($request->input('logo-url') != $settings->logo){ $settings->logo = $request->input('logo-url'); }
			if($request->input('contact-email-address') != $settings->email)
			{
				if(filter_var($request->input('contact-email_address'), FILTER_VALIDATE_EMAIL))
				{
					$settings->email = $request->input('contact-email-address');
				}
				else
				{
					array_push($form_errors, 'Please input a valid email address');
				}
			}
			if($request->input('fb-url') != $settings->facebook){ $settings->facebook = $request->input('fb-url');}
			if($request->input('disqus-url') != $settings->disqus){ $settings->disqus = $request->input('disqus-url');}
			if($request->input('twitter-url') != $settings->twitter){ $settings->twitter = $request->input('twitter-url');}
			if($request->input('analytics-id') != $settings->analytics_id){ $settings->analytics_id = $request->input('analytics-id');}
			if(count($form_errors) > 0)
			{
				$error_string = '';
				for($i=0;$i<count($form_errors);$i++) {$error_string = $error_string . $form_errors[$i] . '</br>'	;}
				throw new Exception($error_string);
			}
		}
		catch(Exception $e)
		{
			return redirect()->action('Dashboard\SettingController@showSettings', ['info' => $e->getMessage()]);
		}
		$settings->save();
		return redirect()->action('Dashboard\SettingController@showSettings');
	}
}