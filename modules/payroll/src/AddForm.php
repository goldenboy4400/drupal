<?php
/**
 * @file

 */
namespace Drupal\payroll;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\SafeMarkup;

class AddForm extends FormBase {
    protected $id;
    function getFormId() {
        return 'payroll_add';
    }
    function buildForm(array $form, FormStateInterface $form_state) {
        $this->id = \Drupal::request()->get('id');
        $payroll = payrollStorage::get($this->id);
        $form['name'] = array(
            '#type' => 'textfield',
            '#title' => t('Name'),
            '#default_value' => ($payroll) ? $payroll->name : '',
        );
        $form['employee_id'] = array(
            '#type' => 'textfield',
            '#title' => t('Employee Id'),
            '#default_value' => ($payroll) ? $payroll->employee_id: '',
        );
        $form['actions'] = array('#type' => 'actions');
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => ($payroll) ? t('Edit') : t('Add'),
        );
        return $form;
    }
    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
    }
    function submitForm(array &$form, FormStateInterface $form_state) {
        $name = $form_state->getValue('name');
        $employee_id= $form_state->getValue('employee_id');
        if (!empty($this->id)) {
            payrollStorage::edit($this->id, SafeMarkup::checkPlain($name), SafeMarkup::checkPlain($employee_id));
            \Drupal::logger('payroll')->notice('@type: deleted %title.',
                array(
                    '@type' => $this->id,
                    '%title' => $this->id,
                ));
            drupal_set_message(t('Your message has been edited'));
        }
        else {
            payrollStorage::add(SafeMarkup::checkPlain($name), SafeMarkup::checkPlain($employee_id));
            \Drupal::logger('payroll')->notice('@type: deleted %title.',
                array(
                    '@type' => $this->id,
                    '%title' => $this->id,
                ));
            drupal_set_message(t('Your message has been submitted'));
        }
        $form_state->setRedirect('payroll_list');
        return;
    }
}