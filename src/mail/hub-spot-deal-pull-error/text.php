<?php
/**
 * @var \yii\web\View $this
 * @var int $hub_spot_id
 * @var \app\models\Job $job
 * @var array $data
 */
use Html2Text\Html2Text;

$internalErrors = libxml_use_internal_errors(true);
echo Html2Text::convert($this->render('html', [
    'hub_spot_id' => $hub_spot_id,
    'job' => $job,
    'data' => $data,
]));
libxml_use_internal_errors($internalErrors);
