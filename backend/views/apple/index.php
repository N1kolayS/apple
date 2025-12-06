<?php

use common\models\Apple;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
$js = <<<JS


$("#grown_apple").click(function(e) {
  let url = $(this).data('url')

  $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                cache: false,
                success: function (json) {
          
                    $.pjax.reload({container: '#main_grid', async: false});
                    
                },
                error: function(json) {
                    alert(json.responseText);
                }
        })
})


JS;

$this->registerJs($js);
?>
<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <button class="btn btn-success" id="grown_apple" data-url="<?=Url::to(['apple/generate'])?>">Вырастить яблоки</button>

    </p>

    <div class="box">
        <?php Pjax::begin(['id' => 'main_grid',  'timeout' => 60*60*1000]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [


                'id',
                'color',
                'appearance_date',
                'fall_date',
                'status',
                //'size',

            ],
        ]); ?>
        <?php Pjax::end(); ?>

    </div>




</div>
