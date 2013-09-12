<?php
class DevelopermodeController extends BaseController
{
    public $defaultAction = 'index';
    
    public function actionIndex()
    {
        $this->render('index');
    }
}