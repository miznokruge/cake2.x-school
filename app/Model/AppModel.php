<?php

//App::uses('Model', 'Model');

/**
 * Description
 *
 * @author Mizno Kruge
 * @since Feb 25, 2012
 */
class AppModel extends Model {
    #public $actsAs = array('AuditLog.Auditable', 'Utils.SoftDelete');

    public $actsAs = array('Utils.SoftDelete');

    public function exists($id = null) {
        if ($this->Behaviors->attached('SoftDelete')) {
            return $this->existsAndNotDeleted($id);
        } else {
            return parent::exists($id);
        }
    }

    public function delete($id = null, $cascade = true) {
        $result = parent::delete($id, $cascade);
        if ($result === false && $this->Behaviors->enabled('SoftDelete')) {
            return (bool) $this->field('deleted', array('deleted' => 1));
        }
        return $result;
    }

    function getLastQuery() {
        $dbo = $this->getDatasource()->getLog();

        return $dbo;
    }

    function lastQuery() {
        $src = $this->getLastQuery();
        return $src['log'][count($src['log']) - 1];
    }

    //utility for quick unbindAllModel
    //ref : http://bakery.cakephp.org/articles/cornernote/2006/12/10/unbindall
    function unbindAll() {
        foreach (array(
    'hasOne' => array_keys($this->hasOne),
    'hasMany' => array_keys($this->hasMany),
    'belongsTo' => array_keys($this->belongsTo),
    'hasAndBelongsToMany' => array_keys($this->hasAndBelongsToMany)
        ) as $relation => $model) {
            $this->unbindModel(array($relation => $model));
        }
    }

    //get all fields of this model
    public function getFields() {
        $columns = $this->schema();
        if (empty($columns)) {
            trigger_error(__d('cake_dev', '(Model::getColumnTypes) Unable to build model field data. If you are using a model without a database table, try implementing schema()'), E_USER_WARNING);
        }

        $results = array();
        foreach ($columns as $key => $col) {
            $results[] = $key;
        }
        unset($columns);
        return $results;
    }

    public function beforeSave($options = array()) {
        parent::beforeSave($options);
//        $payments = $this->OrderTrack->find('all', array(
//            'conditions' => array('PaymentOrder.order_id' => $this->data['PaymentOrder']['order_id'])
//        ));
        $data['date'] = date("Y-m-d H:i:s");
        $data['controller'] = 'pertamax';
        $data['action'] = 'premium';
        $data['user_id'] = 12;
        $data['result'] = '';
        $data['description'] = '';
        #$this->OrderTrack->save($data);
        $this->data['Payment']['slug'] = Inflector::slug($data['controller']);
        return true;
    }

}
