<?php namespace Pingpong\Menus;

use Illuminate\Support\ServiceProvider;

class MenusServiceProvider extends ServiceProvider {

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
		$this->requireMenusFile();
	}

	/**
	 * Require the menus file if that file is exists.
	 *
	 * @return void
	 */
	public function requireMenusFile()
	{
		if(file_exists($file = app_path('menus.php')))
		{
			require $file;
		}
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerServices();
		$this->registerNamespaces();
	}

	/**
	 * Register package service.
	 * 
	 * @return void
	 */
	protected function registerServices()
	{
		$this->app['menus'] = $this->app->share(function($app)
        {
        	return new Menu($app['view'], $app['config']);
        });
	}
    
    /**
     * Register package's namespaces.
     * 
     * @return void
     */
    protected function registerNamespaces()
    {
    	// config
        $configPath = __DIR__.'/../../../src/config/config.php';
        $this->mergeConfigFrom($configPath, 'menus');
        $this->publishes([$configPath => config_path('menus.php')]);
        // views
	    $this->loadViewsFrom(__DIR__.'/../../../views', 'menus');
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('menus');
	}

}
