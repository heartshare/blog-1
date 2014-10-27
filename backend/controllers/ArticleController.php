<?php
namespace backend\controllers;

use common\models\Article;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class ArticleController extends CommonController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'actions' => ['login', 'error'],
//                        'allow' => true,
//                    ],
//                    [
//                        'actions' => ['logout', 'index'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * 文章列表
     * @return string
     */
    public function actionList()
    {
        $list = Article::getArticleList(
            Yii::$app->request->get('page',1),
            Yii::$app->request->get('pageSize',20)
        );
        return $this->render('list',['list'=>$list]);
    }

    public function actionAdd(){
        $model = new Article();
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post()) && $model->addArticle()){

        }
        return $this->render('add',['model'=>$model]);
    }
}
