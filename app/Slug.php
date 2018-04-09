<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Exception;

class Slug
{
	public function generateSlug($args)
	{
		if(!array_key_exists('title', $args)) throw new Exception('Needs a title in order to generate slug');

		$slug = str_slug($args['title']);

		if(!$this->slugExists($slug)) return $slug;
		$end = false;
		do
		{
			$i = rand(1, 999);
			$newSlug = $slug . '-' . $i;
			if(!$this->slugExists($newSlug))
			{
				return $newSlug;
				$end = true;
			}

		}
		while(!$end);

		throw new Exception('Couldn\'t create new slug');
	}

	private function slugExists($slug)
	{
		$allSlugs = DB::table('article')->select('slug')->get();
		return $allSlugs->contains('slug', $slug);
	}
}