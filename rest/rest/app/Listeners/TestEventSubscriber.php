<?php
namespace App\Listeners;

class TestEventSubscriber extends MongodbEventSubscriber
{
	protected $namespace = 'tests';
}