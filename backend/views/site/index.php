<?php

/** @var yii\web\View $this */

$this->title = 'Фруктовый сад';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Фруктовый сад!</h1>

        <p class="lead">В нашем саду выращиваю только яблоки</p>

        <p><?=\yii\helpers\Html::a('Работать с яблоками', ['apple/index'], ['class' => 'btn btn-lg btn-success'])?> </p>


    </div>


</div>
