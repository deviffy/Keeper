<?php

/**
 * Keeper - Assets Manager Package
 *
 * @author Catalin Dumitrescu <catalin@turtlebits.com>
 * @license MIT
 */

namespace TurtleBits\Keeper;

use Illuminate\Support\ServiceProvider;

class KeeperServiceProvider extends ServiceProvider {

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
		$this->package('turtlebits/keeper');
		$this->app['keeper'] = $this->app->share(function($app)
		{
			$config = $app['config'];
			$builder = $app['html'];
			return new Keeper($config,$builder);
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['keeper'] = $this->app->share(function($app)
		{
			return new Keeper;
		});

		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Keeper', 'TurtleBits\Keeper\Facades\Laravel\Keeper');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('keeper');
	}
}