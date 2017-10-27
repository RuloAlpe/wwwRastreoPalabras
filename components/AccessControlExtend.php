<?php
namespace app\components;

use Yii;
use yii\filters\AccessControl;

class AccessControlExtend extends AccessControl{
    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     * @param User|false $user the current user or boolean `false` in case of detached User component
     * @throws ForbiddenHttpException if the user is already logged in or in case of detached User component.
     */
     protected function denyAccess($user)
     {
         if ($user !== false && $user->getIsGuest()) {
             $user->loginRequired();
         } else {
            Yii::$app->response->redirect(\yii\helpers\Url::home());
         }
     }
}