<?php

class msOptionUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'msOption';
    public $objectType = 'ms2_option';
    public $languageTopics = array('minishop2:default');

    public function beforeSet() {
        $key = $this->getProperty('key');
        if (empty($key)) {
            $this->addFieldError('key',$this->modx->lexicon($this->objectType.'_err_name_ns'));
        }

        if (($this->object->get('key') != $key) && $this->doesAlreadyExist(array('key' => $key))) {
            $this->addFieldError('key',$this->modx->lexicon($this->objectType.'_err_ae',array('key' => $key)));
        }

        return parent::beforeSet();
    }

    public function getCategories() {
        $categories = $this->getProperty('categories', false);
        if ($categories) {
            $categories = $this->modx->fromJSON($categories);
        } else {
            $categories = array();
        }
        return $categories;
    }

    public function afterSave() {
        $categories = $this->getCategories();

        if (!empty($categories)) {
            $this->modx->exec("DELETE FROM {$this->modx->getTableName('msCategoryOption')} WHERE `option_id` = {$this->object->get('id')};");
            $categories = $this->object->setCategories($categories);
            $this->object->set('categories', $categories);
        }

        $categoryId = $this->getProperty('category_id');
        if ($categoryId) {
            /** @var msCategoryOption $ftCat */
            $ftCat = $this->modx->getObject('msCategoryOption', array(
                'option_id' => $this->object->get('id'),
                'category_id' => $categoryId
            ));

            if ($ftCat) {
                $ftCat->fromArray($this->getProperties());
                $ftCat->save();
            }
        }

        return parent::afterSave();
    }
}

return 'msOptionUpdateProcessor';
