<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\sms\common\config;

/**
 * SmsProperties provide methods to access the properties specific to SMS.
 *
 * @since 1.0.0
 */
class SmsProperties extends \cmsgears\core\common\config\Properties {

	// Variables ---------------------------------------------------

	// Global -----------------

	const PROP_ACTIVE = 'active';

	const PROP_AUTH_KEY = 'auth_key';

	const PROP_SENDER = 'sender';

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

	public function getAuthKey() {

		return $this->properties[ self::PROP_AUTH_KEY ];
	}

	public function getSender() {

		return $this->properties[ self::PROP_SENDER ];
	}

}
