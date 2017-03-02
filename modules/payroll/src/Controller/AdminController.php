<?php
/**
 */
namespace Drupal\payroll\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\payroll\payrollStorage;
class AdminController extends ControllerBase {
    function contentOriginal() {
        $url = Url::fromRoute('payroll_add');
        //$add_link = ;
        $add_link = '<p>' . \Drupal::l(t('New Payroll Request'), $url) . '</p>';
        // Table header
        $header = array( 'id' => t('Id'), 'name' => t('Submitter name'), 'employee_id' => t('Employee ID'), 'operations' => t('Delete'), );
        $rows = array();
        foreach(payrollStorage::getAll() as $id=>$content) {
            // get rows
            $rows[] = array( 'data' => array($id, $content->name, $content->employee_id, l('Delete', "admin/content/payroll/delete/$id")) );
        }
        $table = array( '#type' => 'table', '#header' => $header, '#rows' => $rows, '#attributes' => array( 'id' => 'payroll-table', ), );
        return $add_link . drupal_render($table);
    }
    function content() {
        $url = Url::fromRoute('payroll_add');
        //$add_link = ;
        $add_link = '<p>' . \Drupal::l(t('New payroll'), $url) . '</p>';
        $text = array(
            '#type' => 'markup',
            '#markup' => $add_link,
        );
        // Table header.
        $header = array(
            'id' => t('Id'),
            'name' => t('Submitter name'),
            'employee_id' => t('Employee ID'),
            'operations' => t('Delete'),
        );
        $rows = array();
        foreach (payrollStorage::getAll() as $id => $content) {
            // Row with attributes on the row and some of its cells.
            $editUrl = Url::fromRoute('payroll_edit', array('id' => $id));
            $deleteUrl = Url::fromRoute('payroll_delete', array('id' => $id));
            $rows[] = array(
                'data' => array(
                    \Drupal::l($id, $editUrl),
                    $content->name, $content->employee_id,
                    \Drupal::l('Delete', $deleteUrl)
                ),
            );
        }
        $table = array(
            '#type' => 'table',
            '#header' => $header,
            '#rows' => $rows,
            '#attributes' => array(
                'id' => 'payroll-table',
            ),
        );
        //return $add_link . ($table);
        return array(
            $text,
            $table,
        );
    }
}