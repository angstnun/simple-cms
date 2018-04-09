<?php

namespace App\Page;

use App\Setting;
use App\Page\SocialMedia;

class Footer
{
	protected $social_media;

	public function __construct(Setting $setting)
	{
		$this->social_media = SocialMedia::withSettings($setting);
	}

	public function getSocialMedia()
	{
		return $this->social_media;
	}
}