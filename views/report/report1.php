<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;

$this->params['breadcrumbs'][] = ['label' => 'รายงาน', 'url' => ['report/report1']];
$this->params['breadcrumbs'][] = 'รายบุคคล';
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'panel' => [
        'before' => 'รายชื่อผู้ถูกวินิจฉัยป่วยด้วยโรคเบาหวานและความดันโลหิตสูง',
        'after' => 'ประมวลผล ณ ' . date('Y-m-d H:i:s')
    ],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'hoscode',
            'header' => 'รหัสสถานบริการ',
        ],
        [
            'attribute' => 'hosname',
            'format' => 'raw',
            'value' => function($model) {
                $hoscode = $model['hoscode'];
                $hosname = $model['hosname'];
                return Html::a(Html::encode($hosname), ['report/report4', 'hoscode' => $hoscode]);
            }
        ],
        [
            'attribute' => 'total',
            'header' => 'ประชากรทั้งหมด(คน)'
        ],
        [
            'attribute' => 'buddha',
            'header' => 'ศาสนาพุทธ (คน)'
        ],
        [
            'attribute' => 'other',
            'header' => 'อื่นๆ (คน)'
        ],
    ]
]);
?>
<div class="alert alert-danger">
    <?= $sql ?>

</div>
<div id="chart">

    <?php
    echo Highcharts::widget([
        'scripts' => [
            'highcharts-more',
            'themas/grit'
        ]
    ]);
    ?>
</div>

<?php
$categ = [];
for ($i = 0; $i < count($rawData); $i++) {
    $categ[] = $rawData[$i]['hosname'];
}
$js_categories = implode("','", $categ);
$data = [];
for ($i = 0; $i < count($rawData); $i++) {
    $data [] = $rawData[$i]['buddha'];
}
$js_data = implode(",", $data);


//เริ่ม สร้าง กราฟ
$this->registerJs("
        
Highcharts.chart('chart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Monthly Average Rainfall'
    },
    subtitle: {
        text: 'Source: WorldClimate.com'
    },
    xAxis: {
        categories: [
            '$js_categories'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'นับถือศาสนาพุทธ(คน)'
        }
    },
    tooltip: {
        headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
        pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
            '<td style=\"padding:0\"><b>{point.y:.1f} คน</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'ศาสนาพุทธ จำนวน : ',
        data: [$js_data]

    }, ]
});



")
    
// จบกราฟ
?>