<?php

namespace Drupal\unt_staff\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\unt_staff\UntStaffClient;
use Drupal\user\Plugin\views\filter\Name;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CampusStaffController.
 */
class CampusStaffController extends ControllerBase {

  private $untStaffClient;

  public function __construct(UntStaffClient $untStaffClient){

    $this->untStaffClient = $untStaffClient;
  }

  public static function create(ContainerInterface $container) {
    $untStaffClient = $container->get('unt_staff_client');

    return new static($untStaffClient);
  }

  /**
   * Show the profile of a single staff member.
   *
   * @return Response
   *
   */
  public function showProfile($staffId) {
    $api_response = $this->untStaffClient->getProfile($staffId);
    //var_dump($api_response[0]);
    $image = $api_response[0]['staffPortrait'] != '' ? $api_response[0]['staffPortrait'] : NULL;
    return [
      '#theme' => 'unt_staff_profile',
      '#name' => 'Staff Profile',
      '#type' => 'markup',
      '#title' => $api_response[0]['staffDept'] . ' Staff',
      '#first_name' =>  ['#markup' => $api_response[0]['staffFirst']],
      '#last_name' =>  ['#markup' => $api_response[0]['staffLast']],
      '#job_title' => ['#markup' => $api_response[0]['staffTitle']],
      '#department' => ['#markup' => $api_response[0]['staffDept']],
      '#phone' => ['#markup' => $api_response[0]['staffPhone']],
      '#email' => ['#markup' => $api_response[0]['staffEmail']],
      '#building' => ['#markup' => $api_response[0]['staffBuilding']],
      '#office' => ['#markup' => $api_response[0]['staffOffice']],
      '#image' => $image,
    ];

  }

}
