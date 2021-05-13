<?php namespace Outdare\Auth;

use Illuminate\Support\ServiceProvider;
use Log;
class AuthServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		include __DIR__.'/../../routes.php';
		$this->publishes([__DIR__.'/../../config/' => app()->configPath().'/auth/'], 'auth');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerConfig();
		$this->loadResources();
	}

	protected function registerConfig()
	{
	    $userConfigFile    = app()->configPath().'/auth/auth.php';
	    $packageConfigFile = __DIR__.'/../../config/auth.php';
	    $config = $this->app['files']->getRequire($packageConfigFile);

	    if (file_exists($userConfigFile)) {
	        $userConfig = $this->app['files']->getRequire($userConfigFile);
	        $config     = array_replace_recursive($config, $userConfig);
	    }

	    $this->app['config']->set('auth::auth', $config);
	}

	protected function loadResources(){

		$laravel = app();
		$version = $laravel::VERSION;
		if (strpos('5.1', $version) !== false) {
			$this->loadViewsFrom(__DIR__.'/../../views', 'auth');
			$this->loadMigrationsFrom(__DIR__.'/../../migrations');
			$this->publishes([__DIR__.'/../../views' => resource_path().'/views/auth/']);
			$this->app['router']->middleware('guest', 'Outdare\Auth\Middleware\RedirectIfAuthenticated');
			$this->app['router']->middleware('outdareauth', 'Outdare\Auth\Middleware\Authenticate');
			if(config()->get('auth::auth.enable_roles')){
				$this->app['router']->middleware('isAdmin', 'Outdare\Auth\Middleware\IsAdmin');
			}
		}else{
			$this->loadViewsFrom(__DIR__.'/../../views', 'auth');
			// $this->loadMigrationsFrom(__DIR__.'/../../migrations');
			$this->publishes([__DIR__.'/../../views' => resource_path().'/views/auth/']);
			$this->app['router']->middleware('guest', 'Outdare\Auth\Middleware\RedirectIfAuthenticated');
			$this->app['router']->middleware('outdareauth', 'Outdare\Auth\Middleware\Authenticate');
			if(config()->get('auth::auth.enable_roles')){
				$this->app['router']->middleware('isAdmin', 'Outdare\Auth\Middleware\IsAdmin');
			}
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [
		  "auth"
	    ];
	}

}
