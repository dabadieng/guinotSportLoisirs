<?php

namespace Drupal\form_webmaster\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * {@inheritdoc}
 */
class Formwebmaster extends FormBase
{

  /**
   * @return string
   *   The unique ID of this form defined by this class
   */
  public function getFormId()
  {
    return 'form_webmaster';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormstateInterface $form_state)
  {

    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('Inscrivez-vous !!!'),
    ];

    $form['indentifiant'] = [
      '#type' => 'hidden',
      '#title' => $this->t('Identifiant'),
      '#description' => $this->t('Identifiant'),
      '#required' => FALSE,
    ];


    $form['firstname'] = [
      '#type' => 'textfield',
      '#maxlength' => 20,
      '#title' => $this->t('Prénom'),
      '#description' => $this->t('Votre prénom'),
      '#required' => TRUE,

    ];

    $form['lastname'] = [
      '#type' => 'textfield',
      '#maxlength' => 20,
      '#title' => $this->t('Nom'),
      '#description' => $this->t('Votre nom'),
      '#required' => TRUE,
    ];


    $form['phone'] = [
      '#type' => 'tel',
      '#title' => $this->t('Telephone mobile'),
      '#description' => $this->t('Votre numero de telephone'),
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'mail',
      '#title' => $this->t('E-mail adresse'),
      '#description' => $this->t('Votre adresse e-mail'),
      '#required' => TRUE,
    ];

    $form['objet'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Object'),
      '#description' => $this->t('Objet'),
      '#required' => TRUE,
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('message'),
      '#description' => $this->t('message'),
      '#required' => TRUE,
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {

    // Check if string input contains any invalid characters.
    $firstname = $form_state->getValue('firstname');
    $lastname = $form_state->getValue('lastname');
    $phone = $form_state->getValue('phone');
    $objet = $form_state->getValue('objet');
    $message = $form_state->getValue('message');

    if (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
      $form_state->setErrorByName('firstname', $this->t('Your firstname should contain only letters.'));
    }

    if (!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
      $form_state->setErrorByName('lastname', $this->t('Your lastname should contain only letters.'));
    }

    if (!preg_match("/^[a-zA-Z ]*$/", $city)) {
      $form_state->setErrorByName('city', $this->t('Your city should contain only letters.'));
    }

    if (!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $internet)) {
      $form_state->setErrorByName('internet', $this->t('Your internet adress is not valid.'));
    }

    if (!preg_match("/^[a-zA-Z ]*$/", $country)) {
      $form_state->setErrorByName('country', $this->t('Your country should contain only letters.'));
    }

    if (!preg_match("/^[0-9 ]*$/", $phone)) {
      $form_state->setErrorByName('phone', $this->t('Your phone number should contain only numbers.'));
    }

    // Validate numbers.
    $cp = $form_state->getValue('cp');
    if (strlen($cp) < 4 || strlen($cp) > 7) {
      $form_state->setErrorByName('cp', $this->t('You CP is invalid.'));
    }

    // Check if age and birth date correspond.
    $birth_year = ($form_state->getValue('birth_date'));
    $current_year = date("Y");
    if (($current_year - $birth_year) < 16) {
      $form_state->setErrorByName('birth_date', $this->t('Your are too young.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // Capitalise the first letter of the strings.
    $form_state->setValue('firstname', ucfirst($form_state->getValue('firstname')));
    $form_state->setValue('lastname', ucfirst($form_state->getValue('lastname')));
    $form_state->setValue('city', ucfirst($form_state->getValue('city')));
    $form_state->setValue('country', ucfirst($form_state->getValue('country')));

    // Output all the values entered by user.
    drupal_set_message($this->t('Your datas are: "@firstname", "@lastname", @birth_date, "@adress", "@city", "@cp","@country", "@phone", "@email"', [
      '@activity' => $form_state->getValue('activity'),
      '@firstname' => $form_state->getValue('firstname'),
      '@lastname' => $form_state->getValue('lastname'),
      '@birth_date' => $form_state->getValue('birth_date'),
      '@email' => $form_state->getValue('email'),
      '@phone' => $form_state->getValue('phone'),
      '@country' => $form_state->getValue('country'),
    ]));
  }
}
