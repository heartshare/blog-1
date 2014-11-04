<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property string $category_name
 * @property string $slug
 * @property string $order
 * @property integer $parent_id
 * @property string $description
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['sort', 'parent_id'],
                'integer',
                'on' => ['create'],
                'message'=>'{attribute}必须是一个数字'
            ],
            [
                ['category_name'],
                'string',
                'min' => 1,
                'max' => 45,
                'on'=>['create'],
                'message' => '{attribute}长度在1~45个字符之间'
            ],
            [
                ['slug', 'description'],
                'string', 'max' => 255,
                'on' => ['create'],
                'message'=>'{attribute}最多支持255个字符'
            ],
            [
                ['slug','category_name'],
                'unique',
                'on' => ['create'],
                'message'=>'{attribute}已经被使用了'
            ],
            [
                ['category_name','slug'],
                'required',
                'on'=>['create'],
                'message'=>'{attribute}不能为空'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '分类ID',
            'category_name' => '分类名称',
            'slug' => '分类路由',
            'sort' => '排序',
            'parent_id' => '父级分类',
            'description' => '分类介绍',
        ];
    }

    public function scenarios(){
        return [
            'create' => [
                'category_name',
                'parent_id',
                'slug',
                'sort',
                'description'
            ],
            'update' => [
                'category_name',
                'parent_id',
                'slug',
                'sort',
                'description'
            ]
        ];
    }

}
