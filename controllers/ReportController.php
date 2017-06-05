<?php

namespace app\controllers;

use yii;

class ReportController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }
/*
  public function actionReport1() {
        
        $sql = "SELECT 
            h.hoscode,h.hosname
            ,(select COUNT(DISTINCT p.HOSPCODE,p.PID) from person p where p.HOSPCODE = h.hoscode
                     AND p.typearea in (1,3)
             ) as 'total'
            ,(select COUNT(DISTINCT p.HOSPCODE,p.PID) from person p where p.HOSPCODE = h.hoscode
               AND p.typearea in (1,3) AND p.RELIGION = 1
              ) as 'buddha'
            ,(select COUNT(DISTINCT p.HOSPCODE,p.PID) from person p where p.HOSPCODE = h.hoscode
               AND p.typearea in (1,3) AND p.RELIGION != 1
              ) as 'other'
             from chospital_amp h
WHERE h.hoscode in ('08010','08011','08012','08013')             
";
        //$rawData = \yii::$app->db->createCommand($sql)->queryAll();
        //print_r($rawData);
        
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);
        return $this->render('report1', [
                    'dataProvider' => $dataProvider,
                    'rawData'=>$rawData
        ]);
    }
    
*/    
    
    public function actionReport1() {
        $sql = "SELECT 
h.hoscode,h.hosname
,(select COUNT(DISTINCT p.HOSPCODE,p.PID) from person p where p.HOSPCODE = h.hoscode
	 AND p.typearea in (1,3)
 ) as 'total'
,(select COUNT(DISTINCT p.HOSPCODE,p.PID) from person p where p.HOSPCODE = h.hoscode
   AND p.typearea in (1,3) AND p.RELIGION = 1
  ) as 'buddha'
,(select COUNT(DISTINCT p.HOSPCODE,p.PID) from person p where p.HOSPCODE = h.hoscode
   AND p.typearea in (1,3) AND p.RELIGION != 1
  ) as 'other'
 from chospital_amp h
WHERE h.hoscode in ('08010','08011','08012','08013')";
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);
        return $this->render('report1', [
                    'dataProvider' => $dataProvider,
                    'rawData'=>$rawData
        ]);
    }
    public function actionReport3($hoscode) {
        $sql = "select hospcode,name,lname,RELIGION from person where hospcode=$hoscode";
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);
        return $this->render('report3', [
                    'dataProvider' => $dataProvider,
                    'sql' => $sql
        ]);
    }

    public function actionReport4($hoscode) {
        $sql = "select hospcode,name,lname,RELIGION from person where  RELIGION != 1 and typearea in (1,3) and hospcode=$hoscode";
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);
        return $this->render('report4', [
                    'dataProvider' => $dataProvider,
                    'sql' => $sql
        ]);
    }

}
