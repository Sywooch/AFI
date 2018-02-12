<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ButtonDropdown;
use yii\grid\GridView;
use app\components\ReturnUrl;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\UnitSearch $searchModel
 */

$this->title = Yii::t('app', 'Units');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="unit-index">

    <div class="clearfix">

        <p class="pull-left">
            <?= Html::a('<span class="fa fa-plus"></span> ' . Yii::t('app', 'Create') . ' ' . Yii::t('app', 'Unit'), ['create', 'ru' => ReturnUrl::getToken()], ['class' => 'btn btn-success']) ?>
            <?= Html::button('<span class="fa fa-search"></span> ' . Yii::t('app', 'Search') . ' ' . Yii::t('app', 'Units'), ['class' => 'btn btn-info', 'data-toggle' => 'modal', 'data-target' => '#unit-searchModal']) ?>
        </p>

        <div class="pull-right">

            <?php 
            /*
            echo ButtonDropdown::widget([
                'id' => 'giiant-relations',
                'encodeLabel' => false,
                'label' => '<span class="fa fa-paperclip"></span> ' . Yii::t('app', 'Relations'),
                'dropdown' => [
                    'options' => [
                        'class' => 'dropdown-menu-right'
                    ],
                    'encodeLabels' => false,
                    'items' => [
                        [
                            'label' => '<i class="fa fa-arrow-left"></i> Item',
                            'url' => [
                                '//item/index',
                            ],
                        ],
                        [
                            'label' => '<i class="fa fa-arrow-left"></i> Package',
                            'url' => [
                                '//package/index',
                            ],
                        ],
                    ],
                ],
            ]);
            */
            ?>

        </div>

    </div>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'layout' => '{summary}{pager}{items}{pager}',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'yii\grid\ActionColumn',
                    'urlCreator' => function ($action, $model, $key, $index) {
                        /** @var app\models\Unit $model */
                        // using the column name as key, not mapping to 'id' like the standard generator
                        $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string)$key];
                        $params[0] = Yii::$app->controller->id ? Yii::$app->controller->id . '/' . $action : $action;
                        $params['ru'] = ReturnUrl::getToken();
                        return Url::toRoute($params);
                    },
                    'contentOptions' => ['nowrap' => 'nowrap']
                ],
                'id',
                // generated by schmunk42\giiant\generators\crud\providers\RelationProvider::columnFormat
                [
                    'class' => yii\grid\DataColumn::className(),
                    'attribute' => 'item_id',
                    'value' => function ($model) {
                        if ($rel = $model->getItem()->one()) {
                            return Html::a($rel->label, ['//item/view', 'id' => $rel->id,], ['data-pjax' => 0]);
                        } else {
                            return '';
                        }
                    },
                    'format' => 'raw',
                ],
                // generated by schmunk42\giiant\generators\crud\providers\RelationProvider::columnFormat
                [
                    'class' => yii\grid\DataColumn::className(),
                    'attribute' => 'package_id',
                    'value' => function ($model) {
                        if ($rel = $model->getPackage()->one()) {
                            return Html::a($rel->id, ['//package/view', 'id' => $rel->id,], ['data-pjax' => 0]);
                        } else {
                            return '';
                        }
                    },
                    'format' => 'raw',
                ],
                'quantity',
                'status',
            ],
        ]); ?>
    </div>

</div>