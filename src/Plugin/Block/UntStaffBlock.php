<?php

namespace Drupal\unt_staff\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'UntStaffBlock' block.
 *
 * @Block(
 *  id = "unt_staff_block",
 *  admin_label = @Translation("UNT Staff block"),
 *  context_definitions = {
 *    "node" = @ContextDefinition ("entity:node", label = @Translation ("Node"), required = FALSE,)
 *   }
 * )
 */
class UntStaffBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\unt_staff\UntStaffClient
   */
  protected $untStaffClient;

  /**
   * UntEvents constructor
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param $unt_staff_client \Drupal\unt_staff\UntStaffClient
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, \Drupal\unt_staff\UntStaffClient $unt_staff_client) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->untStaffClient = $unt_staff_client;
  }

  /**
   * {@inheritdoc }
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('unt_staff_client')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $node = $this->getContextValue('node');
    if($node){
      $dept = $node->get('field_department')->getValue();
      $deptId = $dept[0]['target_id'];
      $dept_staff = $this->untStaffClient->getList($deptId);

      $build = [
        '#theme' => 'unt_staff_block',
        '#first_name' => ['#markup' => $dept_staff[0]['staffFirst']],
        '#last_name' => ['#markup' => $dept_staff[0]['staffLast']],
        '#job_title' => ['#markup' => $dept_staff[0]['staffTitle']],
        '#department' => ['#markup' => $dept_staff[0]['staffDept']],
        '#email' => ['#markup' => $dept_staff[0]['staffEmail']],
        '#phone' => ['#markup' => $dept_staff[0]['staffPhone']],
        '#building' => ['#markup' => $dept_staff[0]['staffBuilding']],
        '#office' => ['#markup' => $dept_staff[0]['staffOffice']],
        '#image' => ['#markup' => $dept_staff[0]['staffPortrait']],
        '#content' => $dept_staff,
      ];

      return $build;
    }

  }
}
