<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use app\components\ReturnUrl;

/**
 * @var yii\web\View $this
 * @var app\models\ProductToOption $model
 */

$this->title = Yii::t('app', 'Product To Option') . ' ' . $model->id;
$this->params['heading'] = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product To Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->params['heading'];
?>
<div class="product-to-option-view">

    <?php //echo $this->render('_menu', compact('model')); ?>
    <?php $this->beginBlock('app\models\ProductToOption'); ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            // generated by schmunk42\giiant\generators\crud\providers\RelationProvider::attributeFormat
            [
                'format' => 'html',
                'attribute' => 'product_id',
                'value' => ($model->getProduct()->one() ? Html::a($model->getProduct()->one()->label, ['//product/view', 'id' => $model->getProduct()->one()->id,]) : '<span class="label label-warning">?</span>'),
            ],
            // generated by schmunk42\giiant\generators\crud\providers\RelationProvider::attributeFormat
            [
                'format' => 'html',
                'attribute' => 'item_id',
                'value' => ($model->getItem()->one() ? Html::a($model->getItem()->one()->label, ['//item/view', 'id' => $model->getItem()->one()->id,]) : '<span class="label label-warning">?</span>'),
            ],
            // generated by schmunk42\giiant\generators\crud\providers\RelationProvider::attributeFormat
            [
                'format' => 'html',
                'attribute' => 'option_id',
                'value' => ($model->getOption()->one() ? Html::a($model->getOption()->one()->name, ['//option/view', 'id' => $model->getOption()->one()->id,]) : '<span class="label label-warning">?</span>'),
            ],
            // generated by schmunk42\giiant\generators\crud\providers\RelationProvider::attributeFormat
            [
                'format' => 'html',
                'attribute' => 'product_type_to_option_id',
                'value' => ($model->getProductTypeToOption()->one() ? Html::a($model->getProductTypeToOption()->one()->id, ['//product-type-to-option/view', 'id' => $model->getProductTypeToOption()->one()->id,]) : '<span class="label label-warning">?</span>'),
            ],
            'value:ntext',
            'sort_order',
            'quote_class',
            'quote_label',
            'quote_unit_cost',
            'quote_quantity',
            'quote_total_cost',
            'quote_make_ready_cost',
            'markup',
            'quote_total_price',
        ],
    ]); ?>

    <?php $this->endBlock(); ?>

    <?= Tabs::widget([
        'id' => 'relation-tabs',
        'encodeLabels' => false,
        'items' => [
            [
                'label' => '<span class="fa fa-asterisk"></span> ProductToOption',
                'content' => $this->blocks['app\models\ProductToOption'],
                'active' => true,
            ],
        ]
    ]);
    ?>

</div>
