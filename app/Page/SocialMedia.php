<?php

namespace App\Page;

use App\Setting;

class SocialMedia
{
	public $facebook;
	public $twitter;
	public $email;

	public function __construct()
	{
		$facebook = $google = $twitter = null;
	}

	public static function withSettings(Setting $setting)
	{
		$instance = new self();
		$instance->facebook = 'http://facebook.com/' . $setting->facebook;
		$instance->twitter = 'http://twitter.com/'. $setting->twitter;
		$instance->email = $setting->email;
		return $instance;
	}
}