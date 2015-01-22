<?php

namespace wcf\acp\form;
use wcf\data\style\Style;
use wcf\data\style\StyleList;
use wcf\form\AbstractForm;
use wcf\system\exception\UserInputException;
use wcf\system\language\I18nHandler;
use wcf\system\style\StyleHandler;
use wcf\system\WCF;
use wcf\util\ArrayUtil;
use wcf\util\FileUtil;
use wcf\util\StringUtil;

/**
 * Shows the field add form.
 *
 * @author	Florian Gail
 * @copyright	2014-2015 Florian Gail <http://www.mysterycode.de/>
 * @license	Kostenlose Plugins <http://downloads.mysterycode.de/index.php/License/6-Kostenlose-Plugins/>
 * @package	de.mysterycode.wcf.customLESS
 * @category	WCF
 */
class CustomLessForm extends AbstractForm {
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.style.customLess';
	
	/**
	 * @see	\wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.style.canManageStyle');
	
	/**
	 * custom less
	 * @var	string
	 */
	public $customLess = '';
	
	/**
	 * @see	\wcf\form\IForm::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['individualLess'])) $this->customLess = StringUtil::trim($_POST['individualLess']);
	}
	
	/**
	 * @see	\wcf\form\IForm::save()
	 */
	public function save() {
		parent::save();
		
		$file = FileUtil::getRealPath(WCF_DIR) . 'style/custom_mysterycode.less';
		
		$string = '';
		
		if(empty($this->customLess)) {
		$string = '// DO NOT EDIT!
';
		}
		
		$string .= $this->customLess;
		
		file_put_contents($file, $string);
		
		$styleList = new StyleList();
		$styleList->readObjects();
		
		foreach($styleList->getObjects() as $style) {
			StyleHandler::getInstance()->resetStylesheet($style);
		}
		
		$this->saved();
		
		// show success
		WCF::getTPL()->assign(array(
			'success' => true
		));
	}
	
	/**
	 * @see	\wcf\form\IForm::readData()
	 */
	public function readData() {
		parent::readData();
		
		$file = FileUtil::getRealPath(WCF_DIR) . 'style/custom_mysterycode.less';
		
		if(file_exists($file)) {
			$this->customLess = file_get_contents($file);
		}
	}
	
	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'individualLess' => $this->customLess
		));
	}
}