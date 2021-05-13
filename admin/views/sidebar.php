<?php
// Yii Imports
use yii\helpers\Html;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

$core	= Yii::$app->core;
$user	= $core->getUser();

$siteRootUrl = Yii::$app->core->getSiteRootUrl();
?>
<?php if( $core->hasModule( 'core' ) && $user->isPermitted( CoreGlobal::PERM_CORE ) ) { ?>
	<div id="sidebar-sms" class="collapsible-tab has-children <?php if( strcmp( $parent, 'sidebar-sms' ) == 0 ) echo 'active';?>">
		<div class="row tab-header">
			<div class="tab-icon"><span class="cmti cmti-mobile"></span></div>
			<div class="tab-title">SMS</div>
		</div>
		<div class="tab-content clear <?php if( strcmp( $parent, 'sidebar-sms' ) == 0 ) echo 'expanded visible';?>">
			<ul>
				<li class='template <?php if( strcmp( $child, 'template' ) == 0 ) echo 'active';?>'><?= Html::a( "Templates", [ "$siteRootUrl/sms/template/all" ] ) ?></li>
			</ul>
		</div>
	</div>
<?php } ?>
