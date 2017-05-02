<?php
/**
 * Created by PhpStorm.
 * User: murder
 * Date: 12/24/14
 * Time: 11:18 PM
 */

namespace api\controllers;

use yii\rest\Controller;

class UserController extends Controller {

    public $modelClass = 'common\models\User';

    public function actionView($id)
    {
        return User::findOne($id);
    }
} 