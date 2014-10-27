<?php
/**
 * Created by PhpStorm.
 * Date: 14-10-26
 * Time: 下午5:27
 * @var $this yii\web\View
 */
use yii\bootstrap\Tabs;
$this->title = '文章列表';
?>
<table class="table table-hover table-striped">
    <tr>
        <th>文章标题</th>
        <th>作者</th>
        <th>发布时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($list as $key => $article): ?>
        <tr>
            <td><?= $article['title'] ?></td>
            <td><?= $article['user_id'] ?></td>
            <td>?</td>
            <td>?</td>
        </tr>
    <?php endforeach ?>
</table>