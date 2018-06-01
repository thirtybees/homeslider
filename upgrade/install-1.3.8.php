<?php
/**
 * Copyright (C) 2017-2018 thirty bees
 * Copyright (C) 2007-2016 PrestaShop SA
 *
 * thirty bees is an extension to the PrestaShop software by PrestaShop SA.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@thirtybees.com so we can send you a copy immediately.
 *
 * @author    thirty bees <modules@thirtybees.com>
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2017-2018 thirty bees
 * @copyright 2007-2016 PrestaShop SA
 * @license   Academic Free License (AFL 3.0)
 * PrestaShop is an internationally registered trademark of PrestaShop SA.
 */

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_3_8($module)
{
	// Only img present, just need to rename folder
	if (file_exists($module->getLocalPath() . 'img') && !file_exists($module->getLocalPath() . 'images'))
		rename($module->getLocalPath() . 'img', $module->getLocalPath() . 'images');
	else if (file_exists($module->getLocalPath() . 'img') && file_exists($module->getLocalPath() . 'images'))
		recurseCopy($module->getLocalPath() . 'img', $module->getLocalPath() . 'images', true);

	Tools::clearCache(Context::getContext()->smarty, $module->getTemplatePath('homeslider.tpl'));

	return true;
}

if (!function_exists('recurseCopy'))
{
	function recurseCopy($src, $dst, $del = false)
	{
		$dir = opendir($src);

		if (!file_exists($dst))
			mkdir($dst);
		while (false !== ($file = readdir($dir))) {
			if (($file != '.') && ($file != '..')) {
				if (is_dir($src . DIRECTORY_SEPARATOR . $file))
					recurseCopy($src . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $file, $del);
				else {
					copy($src . DIRECTORY_SEPARATOR . $file, $dst . DIRECTORY_SEPARATOR . $file);
					if ($del && is_writable($src . DIRECTORY_SEPARATOR . $file))
						unlink($src . DIRECTORY_SEPARATOR . $file);
				}
			}
		}
		closedir($dir);
		if ($del && is_writable($src))
			rmdir($src);
	}
}
