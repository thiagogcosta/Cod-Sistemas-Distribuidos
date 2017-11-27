<?php
namespace App\Listeners;

class UserEventSubscriber extends MongodbEventSubscriber
{
	protected $namespace = 'users';
}