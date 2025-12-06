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
const MAIN_GRID = $("#main_grid");

MAIN_GRID.on('click', '.btn-fall', function (e) {
    e.preventDefault();
    let url = $(this).data('url')
    let reset = confirm("Сбросить яблоко?");
    if (reset) {
        
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
      });
    }

});

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

                [
                    'attribute' => 'created_at',
                    'headerOptions' => ['width' => '100'],
                    'format' => ['date', 'php:d-m-Y H:i:s'],
                ],
                [
                    'label' => 'Image',
                    'headerOptions' => ['width' => '150'],
                    'content' => function(Apple $apple)
                    {
                        return Html::img($apple->getImage(), ['class' => 'img-fluid']);
                    }
                ],
                [
                    'attribute' => 'color',
                    'headerOptions' => ['width' => '150'],
                    'content' => function(Apple $apple)
                    {
                        return Html::tag('div', $apple->color, ['style'=>"background:".$apple->color]);
                    }
                ],

                [
                    'attribute' => 'appearance_date',
                    'headerOptions' => ['width' => '100'],
                    'format' => ['date', 'php:d-m-Y H:i:s'],
                ],
                [
                    'attribute' => 'fall_date',
                    'headerOptions' => ['width' => '100'],
                    'format' => ['date', 'php:d-m-Y H:i:s'],
                ],

                [
                    'attribute' => 'status',

                    'content' => function(Apple $apple)
                    {
                        $content[] = Html::tag('strong', $apple->status);
                        $content[] = Html::tag('br');
                        $content[] = Html::button('Уронить', ['class' => 'btn btn-info btn-fall',
                            'data-url' => Url::to(['fall' , 'id' => $apple->id])]);

                        return implode("\n", $content);
                    }
                ],
                'size',

            ],
        ]); ?>
        <?php Pjax::end(); ?>

    </div>




</div>
