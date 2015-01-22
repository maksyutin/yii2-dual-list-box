<?php

namespace maksyutin\widgets;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * This is just an example.
 */
class AutoloadExample extends InputWidget
{

    public $nametitle;
    public $title;
    public $attributes;
    public $data;

    public function init()
    {
        parent::init();

        $this->nametitle = isset($this->nametitle) ? $this->nametitle : '';
        $this->registerAssets();
        echo Html::activeTextInput($this->model, $this->attribute, ['class' => 'hidden', 'value' => $this->value]);
    }

    public function run()
    {
        $view = $this->getView();
        $model = $this->model;
        $inputId = $this->attribute;
        $selected = \yii\helpers\Json::decode($this->model->$inputId, JSON_UNESCAPED_UNICODE);
        $selected = ($selected == null) ? [] : $selected;
        $json_sel = Json::encode($selected);

        $idModel = strtolower($model->formName());

        $this->attributes = $this->model->attributes();

        $data = $this->data->asArray()->all();

        echo '<div id="'.$inputId.'" >';

        $ret_sel = '';
        $ret = '<select style="display: none;" multiple = "multiple">';
        $cnt = 0;
        foreach ($data as $key => $value) {

            if (!in_array($value[id], $selected)) {
                $ret .= '<option value="' . $value[id] . '">' . $value[name] . '</option>' . "\n";
        } else {
                $cnt++;
                $ret_sel .= '$("#dlb-'.$this->attribute.' .selected").
                append("<option value=' . $value[id] . '>' . $value[name] . '</option>");';
            }

        }
        $ret .= '</select>';

        $js = <<<SCRIPT

            $('#$inputId').DualListBox({
                json: false,
                name: '$idModel',
                id: $inputId,
                title: '$this->nametitle'
            });

            $ret_sel

            $("#$idModel-$inputId").val('$json_sel');

            $('#dlb-$inputId .selected-count').text('$cnt');

SCRIPT;

        $view->registerJs($js);

        return $ret.'</div>';
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        Asset::register($view);
//
//        $attr = $this->attribute;
//        $js = <<<SCRIPT
//
//SCRIPT;
//
//        $view->registerJs($js);
    }
}
