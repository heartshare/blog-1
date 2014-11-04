<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-10',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>


    <?= $form->field($model, 'type')->radioList($model::types()) ?>

    <?= $form->field($model, 'status')->radioList($model::status()) ?>

    <?= $form->field($model, 'home_page_show')->radioList([
        '否','是'
    ]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6,'style'=>'resize:vertical']) ?>

    <?= $form->field($model, 'order')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'excerpt')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'allow_comment')->radioList([1=>'是',0=>'否']) ?>

    <?= $form->field($model, 'category_id')->dropDownList($categorys) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
