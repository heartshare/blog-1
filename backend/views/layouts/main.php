<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => '后台主页',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top'
                ],
            ]);
            $menuItems = [
                ['label' => '博客首页', 'url' => ['/site/index']]
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => '分类管理',
                    'url' => ['/'],
                    'items' => [
                        ['label' => '分类列表', 'url' => \yii\helpers\Url::toRoute('category/')],
                        ['label' => '添加分类', 'url' => \yii\helpers\Url::toRoute('category/create')]
                    ]
                ];
                $menuItems[] = [
                    'label' => '文章管理',
                    'url' => ['/'],
                    'items' => [
                        ['label' => '文章列表', 'url' => \yii\helpers\Url::toRoute('article/')],
                        ['label' => '添加文章', 'url' => \yii\helpers\Url::toRoute('article/create')]
                    ]
                ];
                $menuItems[] = [
                    'label' => '退出 ( ' . Yii::$app->user->identity->username . ' )',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
