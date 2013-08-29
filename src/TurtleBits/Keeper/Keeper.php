<?php

/**
 * Keeper - Assets Manager Package
 *
 * @author Catalin Dumitrescu <catalin@turtlebits.com>
 * @license MIT
 */

namespace TurtleBits\Keeper;

use Illuminate\Config\Repository as Config;
use Illuminate\Html\HtmlBuilder as Html;
use lessc;

class Keeper {
	var $config;
	var $builder;

	public function __construct(Config $config, Html $builder) {
		$this->config = $config;
		$this->builder = $builder;
	}

	public function style($files = NULL, $attributes=array())
	{
		if (is_null($files))
		{
			return FALSE;
		}

		if (!is_array($files))
		{
			$filename = preg_replace("/\\.[^.\\s]{3,4}$/", "", $files);
			$cssFolder = $this->config->get('keeper::stylesheets_css_folder');

			if (file_exists(public_path().'/'.$this->config->get('keeper::stylesheets_less_folder').'/'.$filename.".less"))
			{
				$this->lessit($filename);
				return $this->builder->style("$cssFolder/$filename.css", $attributes);
			}
			else
			{
				if (!file_exists(public_path().'/'.$this->config->get('keeper::stylesheets_css_folder').'/'.$filename.".css"))
					return $this->builder->style("$cssFolder/$filename.css", $attributes);
				else
					return FALSE;
			}
		}
		else
		{
			$items = array();
			foreach($files as $file)
			{
				$filename = preg_replace("/\\.[^.\\s]{3,4}$/", "", $file);
				$cssFolder = $this->config->get('keeper::stylesheets_css_folder');

				if (file_exists(public_path().'/'.$this->config->get('keeper::stylesheets_less_folder').'/'.$filename.".less"))
				{
					$this->lessit($filename);
					$items[] = $this->builder->style("$cssFolder/$filename.css", $attributes);
				}
				else
				{
					if (file_exists(public_path().'/'.$this->config->get('keeper::stylesheets_css_folder').'/'.$filename.".css"))
						$items[] = $this->builder->style("$cssFolder/$filename.css", $attributes);
				}
			}
			return implode('', $items);
		}
	}

	public function script($files = NULL)
	{
		if (is_null($files))
		{
			return FALSE;
		}

		$jsFolder = $this->config->get('keeper::javascript_folder');

		if (!is_array($files))
		{
			$filename = preg_replace("/\\.[^.\\s]{3,4}$/", "", $files);
			return $this->builder->script("$jsFolder/$filename.js");
		}
		else
		{
			$items = array();
			foreach($files as $file)
			{
				$filename = preg_replace("/\\.[^.\\s]{3,4}$/", "", $file);
				$items[] = $this->builder->script("$jsFolder/$filename.js");
			}

			return implode('', $items);
		}
	}

	public function image($filename)
	{
		return public_path().'/'.$this->config->get('keeper::images_folder').'/'.$filename;
	}

	private function lessit($filename)
	{
		$compiler = new lessc;
		$publicPath = public_path();

		$sourceFolder = $this->config->get('keeper::stylesheets_less_folder');
		$targetFolder = $this->config->get('keeper::stylesheets_css_folder');

		$in = "$publicPath/$sourceFolder/$filename.less";
		$out = "$publicPath/$targetFolder/$filename.css";

		switch($this->config->get('keeper::less_compile_frequency')) {
			case "all":
				$compiler->compileFile($in, $out);
				break;
			case "changed":
                $compiler->checkedCompile($in, $out);
				break;
			case "none":
			default:
				// do nothing
		}
	}
}