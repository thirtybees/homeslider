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

function upgrade_module_1_2_1($object)
{
	return Db::getInstance()->execute('
	UPDATE '._DB_PREFIX_.'homeslider_slides_lang SET
		'.homeslider_stripslashes_field('title').',
		'.homeslider_stripslashes_field('description').',
		'.homeslider_stripslashes_field('legend').',
		'.homeslider_stripslashes_field('url')
	);
}

function homeslider_stripslashes_field($field)
{
	$quotes = array('"\\\'"', '"\'"');
	$dquotes = array('\'\\\\"\'', '\'"\'');
	$backslashes = array('"\\\\\\\\"', '"\\\\"');

	return '`'.bqSQL($field).'` = replace(replace(replace(`'.bqSQL($field).'`, '.$quotes[0].', '.$quotes[1].'), '.$dquotes[0].', '.$dquotes[1].'), '.$backslashes[0].', '.$backslashes[1].')';
}
