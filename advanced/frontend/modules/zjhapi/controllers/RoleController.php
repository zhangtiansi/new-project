<?php

namespace app\modules\zjhapi\controllers;

use yii;
use yii\web\Controller;
class RoleController extends Controller
{
    
    public function actionDefault($id)
    {
        $this->layout="blank";
        return $this->render($id);
    }
}