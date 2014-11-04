<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class'=>'table table-hover'],
        'options' => ['class' => 'grid-view table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
//            'content:ntext',
            [
                'class' => DataColumn::className(),
                'attribute' => 'create_time',
                'format' => ['date','php:Y-m-d H:i:s'],
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'modify_time',
                'format' => ['date','php:Y-m-d H:i:s'],
            ],
            // 'type',
             'status',
            // 'home_page_show',
             'view',
            // 'order',
            // 'slug',
            // 'excerpt:ntext',
            // 'password',
            // 'allow_comment',
             'comments_total',
            // 'user_id',
             'category_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
