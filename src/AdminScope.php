<?php

namespace Microservices;

use Closure;
use Illuminate\Auth\AuthenticationException;

class AdminScope
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;    
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->userService->isAdmin()){

            return $next($request);
        }

        throw new AuthenticationException;
    }
}
