<?php
namespace App\Listeners;

class CategoryEventSubscriber extends MongodbEventSubscriber
{
	protected $namespace = 'categories';
}