<?php
namespace App\Library\Auth\Provider;

class User extends \Illuminate\Auth\EloquentUserProvider
{
	public function retrieveByCredentials(array $credentials)
	{
		if (empty($credentials)) {
			return;
		}

		// First we will add each credential element to the query as a where clause.
		// Then we can execute the query and, if we found a user, return it in a
		// Eloquent User "model" that will be utilized by the Guard instances.
		return $this
			->createModel()
			->newQuery()
			->where('email', $credentials['email'])
			//->orWhere('username', $credentials['email'])
			->first();
	}
}