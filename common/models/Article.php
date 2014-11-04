<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id 文章ID
 * @property string $title 文章标题
 * @property string $content 文章内容
 * @property integer $create_time 发表时间
 * @property integer $modify_time 修改时间
 * @property string $type 文章类型
 * @property string $status 文章状态
 * @property string $excerpt 文章摘要
 * @property integer $home_page_show 是否在首页展示
 * @property integer $view 查看次数
 * @property integer $order 排序
 * @property string $slug 路由名
 * @property string $password 查看密码
 * @property integer $allow_comment 是否允许评论
 * @property integer $comments_total 评论数量
 * @property integer $user_id 作者ID
 * @property integer $category_id 分类ID
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    const STATUS_PUBLISH = 'publish';//正常
    const STATUS_DRAFT = 'draft';//草稿
    const STATUS_DELETE = 'delete';//删除

    /**
     * @return array 文章类型数组，键名为存入数据库的值，可用于表单值；键值为代表的中文名
     */
    public static function types()
    {
        return [
            'post' => '文章'
        ];
    }

    public static function status(){
        return [
            self::STATUS_PUBLISH => '发布',
            self::STATUS_DELETE => '删除',
            self::STATUS_DRAFT => '草稿'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['content', 'title', 'create_time', 'modify_time', 'type', 'status','user_id','category_id'],
                'required',
                'message' => '{attribute}不能为空',
                'on' => ['create']
            ],
            [
                ['content', 'title', 'slug', 'excerpt', 'password'],
                'string'
            ],
            [
                ['create_time', 'modify_time', 'home_page_show', 'view', 'order', 'allow_comment', 'comments_total', 'user_id', 'category_id'],
                'integer',
                'message' => '{attribute}只能为数字',
                'on' => ['create','modify','view','comment']
            ],
            [
                ['title'],
                'string',
                'min' => 1,
                'max' => 100,
                'message' => '{attribute}长度不符合要求'
            ],
            [
                ['slug', 'password'],
                'string',
                'max' => 255
            ],
            [
                ['title', 'slug'],
                'unique',
                'message' => '这个{attribute}已经被使用了'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '文章ID',
            'title' => '标题',
            'content' => '正文',
            'create_time' => '发布时间',
            'modify_time' => '更新时间',
            'type' => '类型',
            'status' => '状态',
            'excerpt' => '文章摘要',
            'home_page_show' => '是否推荐到首页',
            'view' => '浏览量',
            'order' => '排序',
            'slug' => '路由',
            'password' => '查看密码',
            'allow_comment' => '是否允许评论',
            'comments_total' => '评论统计',
            'user_id' => '作者ID',
            'category_id' => '文章分类',
        ];
    }

    public function scenarios()
    {
        return [
            'create' => [
                'title',
                'content',
                'create_time',
                'modify_time',
                'type',
                'status',
                'excerpt',
                'home_page_show',
                'view',
                'order',
                'slug',
                'allow_comment',
                'comments_total',
                'user_id',
                'category_id'
            ],
            'modify' => [
                'modify_time',
                'title',
                'content',
                'status',
                'type',
                'order',
                'slug'
            ],
            'find' => [],
            'view' => [
                'view',
            ],
            'comment' => [
                'comments_total'
            ]
        ];
    }

    public function beforeValidate(){
        $this->modify_time = time();
        if ($this->getScenario() == 'create'){
            $this->create_time = time();
            $this->view = 0;
            $this->user_id = Yii::$app->user->id;
            $this->comments_total = 0;
        }
        return true;
    }

    public function beforeSave(){
        return true;
    }

    public function afterFind(){
        return true;
    }
}
