<?php namespace App\Http\Middleware;

use App\Http\Controllers\ProjectController;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class PropertyAccess {
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
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


        if($this->auth->guest()) return $next($request);

        if($this->auth->user()->checkRole(['admin'])) return $next($request);

        if($request->segment(1)=="property" && !$this->auth->user()->checkRole(['manager']))
        {
            return redirect(url('/'));
        }

        if($request->segment(1)=="property" && (in_array('create',$request->segments()) ||  in_array('edit',$request->segments()))  &&  !$this->auth->user()->checkRole(['manager']))
        {
            return redirect(url('/project'));
        }

        if($request->method()=='DELETE' &&  !$this->auth->user()->checkRole(['manager']))
        {
            return redirect(url('/project'));
        }

        return $next($request);
    }

}
