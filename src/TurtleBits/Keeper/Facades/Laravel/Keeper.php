<?php

/**
 * Keeper - Assets Manager Package
 *
 * @author Catalin Dumitrescu <catalin@turtlebits.com>
 * @license MIT
 */

namespace TurtleBits\Keeper\Facades\Laravel;

use Illuminate\Support\Facades\Facade;

class Keeper extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'keeper'; }

}