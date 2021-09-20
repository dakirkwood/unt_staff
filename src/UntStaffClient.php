<?php

namespace Drupal\unt_staff;

use Drupal\Component\Serialization\Json;

class UntStaffClient {
  /**
   * @var \GuzzleHttp\Client
   */

  protected $client;

  /**
   * UntStaffClient constructor
   * @param $http_client_factory \Drupal\Core\Http\ClientFactory
   */

  public function __construct(\Drupal\Core\Http\ClientFactory $http_client_factory){
    $this->client = $http_client_factory->fromOptions([
      'base_uri' => 'http://staff.d9.loc'
    ]);
  }

  /**
   * Get the list of staff for this department
   *
   * @param int $deptId
   *
   * @return array
   */
  public function getList($deptId = 1){
    $response = $this->client->get('api/people', [
      'query' => [
        'department' => $deptId,
        '_format' => 'json',
      ],
    ]);
    return Json::decode($response->getBody());
  }

  /**
   * Show details of a single event
   *
   * @param int $staffId
   *
   * @return array
   */
  public function getProfile($staffId){
    $response = $this->client->get('api/person', [
      'query' => [
        'uid' => $staffId,
        '_format' => 'json',
      ],
    ]);

    return Json::decode($response->getBody());

  }
}

