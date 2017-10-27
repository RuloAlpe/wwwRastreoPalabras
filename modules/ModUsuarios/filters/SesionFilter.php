<?php
namespace app\modules\ModUsuarios\filters;

use Yii;
use yii\base\ActionFilter;

class SesionFilter extends ActionFilter
{

	public function beforeAction($action)
	{
		$this->_startTime = microtime(true);
		return parent::beforeAction($action);
	}

	public function afterAction($action, $result)
	{
		$time = microtime(true) - $this->_startTime;
		Yii::trace("Action '{$action->uniqueId}' spent $time second.");
		return parent::afterAction($action, $result);
	}
}