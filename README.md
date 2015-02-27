Dual list box Widget for Yii 2
==================================

`Dual list box Widget` is a wrapper for [Dual List Box plugin for jQuery and Bootstrap](https://github.com/Geodan/DualListBox),
Bootstrap Dual List Box is a dual list box implementation especially designed for Bootstrap and jQuery. This control is quite easy for users to understand and use. Also it is possible to work with very large multi-selects without confusing the user.

The MIT License (MIT)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist maksyutin/yii2-dual-list-box "dev-master"
```

or add

```
"maksyutin/yii2-dual-list-box": "dev-master"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code:

## EXAMPLE ##

### View ###
```php

echo maksyutin\duallistbox\Widget::widget([
    'model' => $model,
    'attribute' => 'list_regions',
    'title' => 'города',
    'data' => $region,
    'data_id'=> 'id',
    'data_value'=> 'name',
    'lngOptions' => [
        'warning_info' => 'Вы уверены, что хотите выбрать такое количество элементов?
                           Возможно Ваш браузер может перестанет отвечать на запросы..',
        'search_placeholder' => 'Фильтр',
        'showing' => ' - показано',
        'available' => 'Имеющиеся',
        'selected' => 'Выбранные'
    ]
  ]);
```
model - model for form
attribute - model attribute for form
title - view name for attribute

data - model (Region::find());
data_id - name attribute for id
data_value - name attribute for value

### Controller VIEW ###

```php
        $model = new ModelForm;
        
        $region = Region::find();
```

### Controller SAVE ###

```php
$model = new ModelForm;
$model->load(Yii::$app->request->post());
$region_model = Json::decode($model->list_regions);
```
