<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;
use app\models\PostCategory;
use yii\helpers\ArrayHelper;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
* @var app\models\PostSearch $searchModel
*/

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>

<? Pjax::begin() ?>
    <div class="col-md-12">

        <div class="clearfix">
            <p class="pull-left">
                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> New Post', ['create'], ['class' => 'btn btn-success', 'data-pjax' => 0]) ?>
            </p>
        </div>

    
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns' => [
    			'id',
    			'title',
    			[
                    'attribute' => 'content',
                    'value'     => function ($model, $key, $index, $column) {
                        return StringHelper::truncate($model->content, 100);
                    }
                ],
                'slug',
                [
                    'attribute' => 'category_id',
                    'value'     => function ($model, $key, $index, $column) {
                        return $model->category->name;
                    },
                    'filter' => Html::activeDropDownList($searchModel, 'category_id', ArrayHelper::map(PostCategory::find()->asArray()->all(), 'id', 'name'), ['prompt' => 'Caltegory'])
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'urlCreator' => function($action, $model, $key, $index) {
                        $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                        $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
                        return \yii\helpers\Url::toRoute($params);
                    },
                    'contentOptions' => ['nowrap'=>'nowrap']
                ],
            ],
        ]) ?>
    </div>
<? Pjax::end() ?>