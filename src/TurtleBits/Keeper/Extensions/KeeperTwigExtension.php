<?php

/**
 * Keeper - Assets Manager Package - Twig Extension
 *
 * @author Catalin Dumitrescu <catalin@turtlebits.com>
 * @license MIT
 */

namespace TurtleBits\Keeper\Extensions;

use TwigBridge\Extension as BaseExtension;
use Illuminate\Foundation\Application;
use Twig_Environment;

class KeeperTwigExtension extends BaseExtension
{
	public function getName() {
		return 'KeeperExtension';
	}

	public function __construct(Application $app, Twig_Environment $twig) {
		parent::__construct($app, $twig);
		$this->registerTwigFunctions();
	}

	private function registerTwigFunctions() {
		$this->twig->addFunction('keeper_style', new \Twig_Function_Function('Keeper::style'));
		$this->twig->addFunction('keeper_script', new \Twig_Function_Function('Keeper::script'));
		$this->twig->addFunction('keeper_image', new \Twig_Function_Function('Keeper::image'));
	}
}