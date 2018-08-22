<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\sms\common\config;

// CMG Imports
use cmsgears\core\common\config\Properties;

/**
 * SmsProperties provide methods to access the properties specific to SMS.
 *
 * @since 1.0.0
 */
class SmsProperties extends Properties {

	// Variables ---------------------------------------------------

	// Global -----------------

	const PROP_ACTIVE = 'active';

	const PROP_MSG91_AUTH = 'msg91_auth';

	// Public -----------------

	// Protected --------------

	// Private ----------------

	private static $instance;

	// Constructor and Initialisation ------------------------------

	/**
	 * Return Singleton instance.
	 */
	public static function getInstance() {

		if( !isset( self::$instance ) ) {

			self::$instance	= new SmsProperties();

			self::$instance->init( SmsGlobal::CONFIG_SMS );
		}

		return self::$instance;
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SmsProperties -------------------------

	public function isActive() {

		return $this->properties[ self::PROP_ACTIVE ];
	}

	public function getMsg91Auth() {

		return $this->properties[ self::PROP_MSG91_AUTH ];
	}

}
