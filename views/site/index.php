<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */

$this->title = 'DashBoard KPI ';
?>


<div id="chart" style="display: none;">

    <?php
    echo Highcharts::widget([
        'scripts' => [
            'highcharts-more',
            'themas/grit'
        ]
    ]);
    $this->registerJsFile('./js/chart_dial.js');
    ?>

</div>


    <div class="row">
        <div class="col-sm-4" style="text-align: center;">
            <?php
            $command = Yii::$app->db->createCommand("SELECT count(*) from anc where DATE_SERV BETWEEN '2015-01-01' and '2015-12-31' ");
            $target = $command->queryScalar();

           // $command = Yii::$app->db->createCommand("select sum(chronic) from ");
            //$chronic = $command->queryScalar();

            $command = Yii::$app->db->createCommand("SELECT count(*)
 from anc where DATE_SERV BETWEEN '2015-01-01' and '2015-12-31' AND GA=1  ");
            $result = $command->queryScalar();

            $target = $target;
            $result = $result;
            $persent = 0.00;
            if ($target > 0) {
                $persent = $result / $target * 100;
                $persent = number_format($persent, 2);
            }
            $base = 90;
            $this->registerJs("
                        var obj_div=$('#ch1');
                        gen_dial(obj_div,$base,$persent);
                    ");
            ?>
            <h4>หญิงมีครรภ์ได้รับการฝากครรภ์ครั้งแรก<br>ร้อยละ</h4>
            <div id="ch1"></div>
        </div>

        <div class="col-sm-4" style="text-align: center;">
            <?php
            $command = Yii::$app->db->createCommand("SELECT count(*) 
                    from anc where DATE_SERV BETWEEN '2015-12-10' and '2015-12-31' ");
            $target = $command->queryScalar();

           // $command = Yii::$app->db->createCommand("select sum(chronic) from ");
            //$chronic = $command->queryScalar();

            $command = Yii::$app->db->createCommand("SELECT count(*)
 from anc where DATE_SERV BETWEEN '2015-01-01' and '2015-12-31' AND GA=1  ");
            $result = $command->queryScalar();
            $target = $target;
            $result = $result;
            $persent = 0.00;
            if ($target > 0) {
                $persent = $result / $target * 100;
                $persent = number_format($persent, 2);
            }
            $base = 90;
            $this->registerJs("
                        var obj_div=$('#ch2');
                        gen_dial(obj_div,$base,$persent);
                    ");
            ?>
            <h4>การคัดกรองโรคเบาหวาน<br>ร้อยละ</h4>
            <div id="ch2"></div>
        </div>

        <div class="col-sm-4" style="text-align: center;">
            <?php
            $target = 503;
            $result = 502;
            $persent = 0.00;
            if ($target > 0) {
                $persent = $result / $target * 100;
                $persent = number_format($persent, 2);
            }
            $base = 90;
            $this->registerJs("
                        var obj_div=$('#ch3');
                        gen_dial(obj_div,$base,$persent);
                    ");
            ?>
            <h4>การคัดกรองโรคความดันโลหิตสูง<br>ร้อยละ</h4>
            <div id="ch3"></div>
        </div>

        
    </div>
    