<?php

namespace app\components\fields;

use app\models\Component;
use app\models\ProductToOption;
use Yii;

/**
 * QuickClickFrameField
 */
class QuickClickFrameField extends ComponentField
{

    /**
     * @inheritdoc
     */
    public function attributeValueProduct($productToOption)
    {
        $component = $this->getComponent($productToOption);
        return $component ? $component->name : '';
    }

    /**
     * @inheritdoc
     */
    public function fieldProduct($productToOption, $form, $key)
    {
        $data = ['auto' => Yii::t('app', 'Auto Select')];
        return $form->field($productToOption, 'valueDecoded')->dropDownList($data, [
            'id' => "ProductToOptions_{$key}_valueDecoded",
            'name' => "ProductToOptions[$key][valueDecoded]",
            //'prompt' => '',
        ])->label($productToOption->option->name);
    }

    /**
     * @param ProductToOption $productToOption
     * @return Component
     */
    public function getComponent($productToOption)
    {
        if (!$this->_component) {
            $autoComponent = $this->autoFindComponent($productToOption);
            if ($autoComponent) {
                $this->_component = Component::findOne($autoComponent);
            }
        }
        return $this->_component;
    }

    /**
     * @param ProductToOption $productToOption
     * @return float
     */
    public function getQuantity($productToOption)
    {
        $autoComponent = $this->autoFindComponent($productToOption);
        return $autoComponent ? $productToOption->quantity : 0;
    }

    /**
     * @param ProductToOption $productToOption
     * @return float
     */
    private function autoFindComponent($productToOption)
    {
        $autoComponent = $productToOption->product->getCache('QuickClickFrameField.autoFindComponent.' . $productToOption->id);
        if ($autoComponent) {
            return $autoComponent;
        }

        // get available components
        $query = Component::find();
        $query->orderBy(['name' => SORT_ASC]);
        $fieldConfig = $productToOption->option->getFieldConfigDecoded();
        if (isset($fieldConfig['condition'])) {
            $query->andWhere($fieldConfig['condition']);
        }
        if ($productToOption->productTypeToOption) {
            $values = $productToOption->productTypeToOption->getValuesDecoded();
            if ($values) {
                $query->andWhere(['id' => $productToOption->productTypeToOption->getValuesDecoded()]);
            }
        }
        $frames = [];
        foreach ($query->all() as $_component) {
            $componentConfig = $_component->getConfigDecoded();
            if (isset($componentConfig['quickclick'])) {
                $frames[$_component->id] = $componentConfig['quickclick'];
            }
        }

        // get best matched component
        if ($productToOption->item_id) {
            $size = $productToOption->item->getSize(true);
            foreach (['FL', 'VC', 'HC'] as $_size) {
                if (strpos($size['name'], $_size) !== false) {
                    $autoComponent = array_search($_size, $frames);
                    $productToOption->product->setCache('QuickClickFrameField.autoFindComponent.' . $productToOption->id, $autoComponent);
                    break;
                }
            }
        }
        return $autoComponent;
    }

}