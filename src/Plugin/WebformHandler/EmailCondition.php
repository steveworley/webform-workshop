<?php

namespace Drupal\custom_form\Plugin\WebformHandler;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\webform\Plugin\WebformElementManagerInterface;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\Plugin\WebformHandlerMessageInterface;
use Drupal\webform\WebformSubmissionInterface;
use Drupal\webform\WebformTokenManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Trigger emails to configured URLs based on form values.
 *
 * @WebformHandler(
 *   id = "custom_email",
 *   label = @Translation("Custom Email"),
 *   category = @Translation("Notification"),
 *   description = @Translation("Sends a webform submission based on conditions"),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_OPTIONAL,
 * )
 */
class EmailCondition extends WebformHandlerBase implements WebformHandlerMessageInterface {

  protected $currentUser;

  protected $mailManager;

  protected $tokenManager;

  protected $elementManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, LoggerInterface $logger, ConfigFactoryInterface $config_factory, EntityTypeManagerInterface $entity_type_manager, AccountInterface $current_user, MailManagerInterface $mail_manager, WebformTokenManagerInterface $token_manager, WebformElementManagerInterface $element_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $logger, $config_factory, $entity_type_manager);
    $this->currentUser = $current_user;
    $this->mailManager = $mail_manager;
    $this->tokenManager = $token_manager;
    $this->elementManager = $element_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('logger.factory')->get('webform.email'),
      $container->get('config.factory'),
      $container->get('entity_type.manager'),
      $container->get('current_user'),
      $container->get('plugin.manager.mail'),
      $container->get('webform.token_manager'),
      $container->get('plugin.manager.webform.element')
    );
  }

  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $this->applyFormStateSettingsToConfiguration($form_state);

    $form['to'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Send to'),
      '#description' => $this->t('Enter a list of emails separated by a new line'),
    ];

    return parent::buildConfigurationForm($form, $form_state); // TODO: Change the autogenerated stub
  }

  public function sendMessage(WebformSubmissionInterface $webform_submission, array $message) {
    // TODO: Implement sendMessage() method.
  }

  public function hasRecipient(WebformSubmissionInterface $webform_submission, array $message) {
    // TODO: Implement hasRecipient() method.
  }

  public function getMessage(WebformSubmissionInterface $webform_submission) {
    // TODO: Implement getMessage() method.
  }

  public function resendMessageForm(array $message) {
    // TODO: Implement resendMessageForm() method.
  }

  public function getMessageSummary(array $message) {
    // TODO: Implement getMessageSummary() method.
  }
}
