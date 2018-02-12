<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var dmstr\modules\prototype\models\search\Less $searchModel
 */

$this->title = Yii::t('prototype', 'Lesses');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="giiant-crud less-index">

    <?php //             echo $this->render('_search', ['model' =>$searchModel]);
    ?>


    <?php \yii\widgets\Pjax::begin(
        [
            'id' => 'pjax-main',
            'enableReplaceState' => false,
            'linkSelector' => '#pjax-main ul.pagination a, th a',
            'clientOptions' => ['pjax:success' => 'function(){alert("yo")}']
        ]
    ) ?>

    <h1>
        <?= Yii::t('prototype', 'Lesses') ?>
        <small>
            List
        </small>
    </h1>
    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?= Html::a(
                '<span class="glyphicon glyphicon-plus"></span> '.Yii::t('prototype', 'New'),
                ['create'],
                ['class' => 'btn btn-success']
            ) ?>
        </div>

        <div class="pull-right">


            <?=
            \yii\bootstrap\ButtonDropdown::widget(
                [
                    'id' => 'giiant-relations',
                    'encodeLabel' => false,
                    'label' => '<span class="glyphicon glyphicon-paperclip"></span> '.Yii::t('prototype', 'Relations'),
                    'dropdown' => [
                        'options' => [
                            'class' => 'dropdown-menu-right'
                        ],
                        'encodeLabels' => false,
                        'items' => []
                    ],
                    'options' => [
                        'class' => 'btn-default'
                    ]
                ]
            );
            ?>        </div>
    </div>


    <div class="table-responsive">
        <?= GridView::widget(
            [
                'layout' => '{summary}{pager}{items}{pager}',
                'dataProvider' => $dataProvider,
                'pager' => [
                    'class' => yii\widgets\LinkPager::className(),
                    'firstPageLabel' => Yii::t('prototype', 'First'),
                    'lastPageLabel' => Yii::t('prototype', 'Last')
                ],
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
                'headerRowOptions' => ['class' => 'x'],
                'columns' => [

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'urlCreator' => function ($action, $model, $key, $index) {
                            // using the column name as key, not mapping to 'id' like the standard generator
                            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string)$key];
                            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id.'/'.$action : $action;
                            return Url::toRoute($params);
                        },
                        'contentOptions' => ['nowrap' => 'nowrap']
                    ],
                    'key',
                ],
            ]
        ); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


