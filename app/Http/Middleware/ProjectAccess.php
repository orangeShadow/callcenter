<?php namespace App\Http\Middleware;

use App\Http\Controllers\ProjectController;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class ProjectAccess {
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
     * @return void
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

        dd($request->segments());

        if($this->auth->guest()) return $next($request);

        if($this->auth->user()->checkAccess(['admin'])) return $next($request);

        if($request->segment(1)=="project" && !$this->auth->user()->checkAccess(['operator','manager']))
        {
            return redirect(url('/'));
        }

        if($request->segment(1)=="project" && (in_array('create',$request->segments()) ||  in_array('edit',$request->segments()))  &&  $this->auth->user()->checkAccess(['operator']))
        {
            return redirect(url('/project'));
        }

        return $next($request);
	}

}
