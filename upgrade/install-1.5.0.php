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

function upgrade_module_1_5_0($module)
{
	/* Get existing values as default */
	$default_width = (int)Configuration::get('HOMESLIDER_WIDTH');
	$default_speed = (int)Configuration::get('HOMESLIDER_SPEED');
	$default_pause = (int)Configuration::get('HOMESLIDER_PAUSE');
	$default_loop = (int)Configuration::get('HOMESLIDER_LOOP');
	$res = true;

	// Clean existing
	Configuration::deleteByName('HOMESLIDER_WIDTH');
	Configuration::deleteByName('HOMESLIDER_SPEED');
	Configuration::deleteByName('HOMESLIDER_PAUSE');
	Configuration::deleteByName('HOMESLIDER_LOOP');

	$shops = Shop::getContextListShopID();
	$shop_groups_list = array();

	/* Setup each shop */
	foreach ($shops as $shop_id)
	{
		$shop_group_id = (int)Shop::getGroupFromShop($shop_id, true);

		if (!in_array($shop_group_id, $shop_groups_list))
			$shop_groups_list[] = $shop_group_id;

		/* Sets up configuration */
		$res = Configuration::updateValue('HOMESLIDER_WIDTH', $default_width, false, $shop_group_id, $shop_id);
		$res &= Configuration::updateValue('HOMESLIDER_SPEED', $default_speed, false, $shop_group_id, $shop_id);
		$res &= Configuration::updateValue('HOMESLIDER_PAUSE', $default_pause, false, $shop_group_id, $shop_id);
		$res &= Configuration::updateValue('HOMESLIDER_LOOP', $default_loop, false, $shop_group_id, $shop_id);
	}

	/* Sets up Shop Group configuration */
	if (count($shop_groups_list))
	{
		foreach ($shop_groups_list as $shop_group_id)
		{
			$res = Configuration::updateValue('HOMESLIDER_WIDTH', $default_width, false, $shop_group_id);
			$res &= Configuration::updateValue('HOMESLIDER_SPEED', $default_speed, false, $shop_group_id);
			$res &= Configuration::updateValue('HOMESLIDER_PAUSE', $default_pause, false, $shop_group_id);
			$res &= Configuration::updateValue('HOMESLIDER_LOOP', $default_loop, false, $shop_group_id);
		}
	}

	/* Sets up Global configuration */
	$res = Configuration::updateValue('HOMESLIDER_WIDTH', $default_width);
	$res &= Configuration::updateValue('HOMESLIDER_SPEED', $default_speed);
	$res &= Configuration::updateValue('HOMESLIDER_PAUSE', $default_pause);
	$res &= Configuration::updateValue('HOMESLIDER_LOOP', $default_loop);


	return $res;
}

