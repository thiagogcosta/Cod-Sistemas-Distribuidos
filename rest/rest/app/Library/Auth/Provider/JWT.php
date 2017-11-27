<?php
namespace App\Library\Auth\Provider;

use App\MongoModels\User;
use Dingo\Api\Auth\Provider\Authorization;
use Dingo\Api\Routing\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWT as JWTAuth;
use Illuminate\Auth\AuthenticationException;

class JWT extends Authorization {

	/** @var JWTAuth */
	private $jwt;

	public function __construct (JWTAuth $jwt) {
		$this->jwt = $jwt;
	}

	public function getAuthorizationMethod()
	{
		return 'bearer';
	}

	public function authenticate(Request $request, Route $route)
	{
		$guard = $this->getGuard();

		try {
			return $guard->authenticate();

		} catch (AuthenticationException $e) {
			$this->refreshToken();
			return $guard->user();
		}
	}

	protected function refreshToken() {
		$token = $this->jwt->parseToken()->refresh();
		$this->jwt->setToken($token);
	}

	/**
	 * @return \Tymon\JWTAuth\JWTGuard
	 * @throws AuthenticationException
	 */
	protected function getGuard() {

		if( getenv('APP_ENV') == 'development' && !request()->header('verify', true)){
			$this->jwt->setToken(Auth::guard('api-user')->login(User::query()->where('email', 'user@ingles200h.dev')->first()));
			$token = $this->jwt->getToken();
		}else{
			$token = $this->jwt->parseToken()->getToken();
		}

		if ($token)
			$payloadArray = $this->jwt->manager()->getJWTProvider()->decode($token->get());

		if (empty($payloadArray['guard']))
			throw new AuthenticationException;

		return Auth::guard('api-'.$payloadArray['guard']);
	}

}