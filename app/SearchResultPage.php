<?php

namespace App;

use App\Page;

class SearchResultPage extends Page
{
    public function __construct()
    {
    	parent::__construct();
    	$this->body->setContent('no results');
    	$this->title = 'No results found';
    }
}
