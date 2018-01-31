<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 30.01.18
 * Time: 12:49
 */

namespace app\modules\tag\widgets;


use app\modules\tag\assets\TagsInputAsset;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Class TagWidget
 * @package app\modules\tag\widgets
 */
class TagWidget extends InputWidget
{
    /**
     * @var array
     */
    public $clientOptions = [];


    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (is_null($this->options['id'])) {
            $this->options['id'] = Html::getInputId($this->model, $this->attribute);
        }

        if (is_null($this->clientOptions['url'])) {
            throw new InvalidConfigException('clientOptions::url must be set');
        }
    }


    /**
     * @return string
     */
    public function run()
    {
        $this->registerAssets();
        $this->registerEvent();
        return Html::activeTextInput(
            $this->model,
            $this->attribute,
            [
                'id' => $this->options['id'],
                'class' => 'form-control',
                'data-role' => 'tagsinput',
            ]
        );
    }

    /**
     *
     */
    public function registerAssets()
    {
        TagsInputAsset::register($this->view);
    }

    /**
     *
     */
    public function registerEvent()
    {
        $js = <<<JS
    $('#{$this->options['id']}').on('beforeItemAdd', function(event) {
        var item = event.item;
        $.ajax({
            'url': '{$this->clientOptions['url']}',
            'data': {'tag': item},
            'method': 'POST'
        }).done(function(response) {
          if (response.status.toLowerCase() != 'ok') {
              event.cancel = true;
              console.log(response.message);
          }
        })
    });
JS;
        $this->view->registerJs($js);
    }
}