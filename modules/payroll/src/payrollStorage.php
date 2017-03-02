<?php
namespace Drupal\payroll;
class payrollStorage {
    static function getAll() {
        $result = db_query('SELECT * FROM {payroll}')->fetchAllAssoc('id');
        return $result;
    }
    static function exists($id) {
        return (bool) get($id);
    }
    static function get($id) {
        $result = db_query('SELECT * FROM {payroll} WHERE id = :id', array(':id' => $id))->fetchAllAssoc('id');
        if ($result) {
            return $result[$id];
        }
        else {
            return FALSE;
        }
    }
    static function add($name, $employee_id) {
        db_insert('payroll')->fields(array(
            'name' => $name,
            'employee_id' => $employee_id,
        ))->execute();
    }
    static function edit($id, $name, $employee_id) {
        db_update('payroll')->fields(array(
            'name' => $name,
            'employee_id' => $employee_id,
        ))
            ->condition('id', $id)
            ->execute();
    }

    static function delete($id) {
        db_delete('payroll')->condition('id', $id)->execute();
    }
}