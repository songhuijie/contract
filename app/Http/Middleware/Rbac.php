<?php

namespace App\Http\Middleware;

use App\Exceptions\RbacException;
use App\Models\Admin;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Rbac
{
    protected $prefix = 'App\\Http\\Controllers\\Admin\\';
    protected $rulesCacheKey = 'rules_cache_v1';

    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws RbacException
     */
    public function handle($request, Closure $next)
    {
        $currentRule = $this->getCurrentRule();
        $rules = $this->getRules();

//        dd($currentRule,$rules,in_array($currentRule, $rules));

        if (!in_array($currentRule, $rules))
            abort(403);
        return $next($request);
    }

    public function getCurrentRule()
    {
        $origRule = Route::current()->getActionName();
        $rule = substr($origRule, strlen($this->prefix));
        return strtolower($rule);
    }

    public function getRules()
    {
        $id = Auth::guard('admin')->id();
        if (!$id) return [];
        $admin = new Admin();
        return $admin->getAdminRules($id);
    }
}
