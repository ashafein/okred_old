<?php
class Controller extends BaseController
{
    public function actionIndex()
    {
        
        //throw new CException('error!');
        $this->renderPartial('index');
    }
}