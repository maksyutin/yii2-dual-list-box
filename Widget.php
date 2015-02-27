<?php

namespace maksyutin\duallistbox;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * This is just an example.
 */
class Widget extends InputWidget
{

    public $nametitle;
    public $title;
    public $lngOptions;
    public $attributes;
    public $data;
    public $data_id;
    public $data_value;

    public function init()
    {
        parent::init();

        $this->data_id = isset($this->data_id) ? $this->data_id : 'id';
        $this->data_value = isset($this->data_value) ? $this->data_value : 'name';

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

        $data = ($this->data) ? $this->data->asArray()->all() : [];

        echo '<div id="'.$inputId.'" >';

        $ret_sel = '';
        $ret = '<select style="display: none;" multiple = "multiple">';
        $cnt = 0;
        foreach ($data as $key => $value) {

            if (!in_array($value[$this->data_id], $selected)) {
                $ret .= '<option value="' . $value[$this->data_id] . '">' . $value[$this->data_value] . '</option>' . "\n";
        } else {
                $cnt++;
                $ret_sel .= '$("#dlb-'.$this->attribute.' .selected").
                append("<option value=' . $value[$this->data_id] . '>' . $value[$this->data_value] . '</option>");';
            }

        }
        $ret .= '</select>';

        $lng_opt = new Json();
        $lng_opt->warning_info = 'Are you sure you want to move this many items?
        Doing so can cause your browser to become unresponsive.';
        $lng_opt->search_placeholder = 'Filter';
        $lng_opt->showing = '- showing';
        $lng_opt->available = 'Available';
        $lng_opt->selected = 'Selected';

        foreach($lng_opt as $key=>$value) {
            $lng_opt->$key = isset($this->lngOptions[$key]) ? $this->lngOptions[$key] : $value;
        }

        $options = 'lngOptions: '. json_encode($lng_opt);

        $js = <<<SCRIPT

            $('#$inputId').DualListBox({
                json: false,
                name: '$idModel',
                id: $inputId,
                title: '$this->nametitle',
                $options
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
