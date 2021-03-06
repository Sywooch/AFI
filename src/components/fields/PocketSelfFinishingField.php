<?php

namespace app\components\fields;

use app\components\fields\validators\FinishingFieldValidator;
use app\components\quotes\components\BaseComponentQuote;
use app\models\Component;
use kartik\select2\Select2;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * PocketSelfFinishingField
 */
class PocketSelfFinishingField extends FinishingField
{
    /**
     *
     */
    const COMPONENT_POCKET_SELF = 11809;
    const COMPONENT_SEWING = 11838;

    /**
     * @inheritdoc
     */
    public function getComponent($productToOption)
    {
        if (!$this->_component) {
            $pocketSelf = Component::findOne(static::COMPONENT_POCKET_SELF);
            $sewing = Component::findOne(static::COMPONENT_SEWING);
            //$pocketSelf->name .= ' + ' . $sewing->name;
            $pocketSelf->make_ready_cost += $sewing->make_ready_cost;
            $pocketSelf->unit_cost += $sewing->unit_cost;
            $pocketSelf->minimum_cost += $sewing->minimum_cost;
            $this->_component = $pocketSelf;
        }
        return $this->_component;
    }

    /**
     * @inheritdoc
     */
    public function fieldProductType($productTypeToOption, $form)
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function fieldProduct($productToOption, $form, $key)
    {
        $positions = $this->optsPosition();
        $fields = [];

        $fields[] = $form->field($productToOption, 'valueDecoded')->checkboxList($positions, [
            'id' => "ProductToOptions_{$key}_valueDecoded_position",
            'name' => "ProductToOptions[$key][valueDecoded][position]",
            'value' => isset($productToOption->valueDecoded['position']) ? $productToOption->valueDecoded['position'] : '',
        ])->label($productToOption->option->name);

        $fields[] = $form->field($productToOption, 'valueDecoded', [
            'addon' => [
                'append' => ['content' => 'mm'],
            ]
        ])->textInput([
            'id' => "ProductToOptions_{$key}_valueDecoded_size",
            'name' => "ProductToOptions[$key][valueDecoded][size]",
            'value' => isset($productToOption->valueDecoded['size']) ? $productToOption->valueDecoded['size'] : '',
            'prompt' => '',
        ])->label(Yii::t('app', 'Size'));

        return implode("\n", $fields);
    }

    /**
     * @inheritdoc
     */
    public function attributeValueProduct($productToOption)
    {
        $component = $this->getComponent($productToOption);
        if (!$component) {
            return '';
        }
        $positions = [];
        if (!empty($productToOption->valueDecoded['position'])) {
            if (count($productToOption->valueDecoded['position']) == 4) {
                $positions[] = Yii::t('app', 'All Sides');
            } else {
                foreach ($productToOption->valueDecoded['position'] as $position) {
                    $positions[] = $this->optsPosition()[$position];
                }
            }
            $size = $productToOption->valueDecoded['size'];
            return $component->name . ' (' . implode(', ', $positions) . ' - ' . $size . 'mm)';
        }
        return '';
    }
}