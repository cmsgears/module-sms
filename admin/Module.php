<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\sms\admin;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\sms\common\config\SmsGlobal;

use cmsgears\core\common\base\Module as BaseModule;

/**
 * The Admin Module of SMS Module.
 *
 * @since 1.0.0
 */
class Module extends BaseModule {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $controllerNamespace = 'cmsgears\sms\admin\controllers';

	public $config = [ SmsGlobal::CONFIG_SMS ];

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		$this->setViewPath( '@cmsgears/module-sms/admin/views' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Module --------------------------------

	public function getSidebarHtml() {

		$path	= Yii::getAlias( '@cmsgears' ) . '/module-sms/admin/views/sidebar.php';

		return $path;
	}

}
