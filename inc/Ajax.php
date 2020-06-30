<?php 

namespace App;
use App\Models\Setting;
use GuzzleHttp\Client;

class Ajax {
  public $setting;
  public $apiurl;

  public function __construct() {
    $this->setting = new Setting();
    $this->apiurl = WP_DEBUG ? 'https://staging.scrut.my' : 'https://scrut.my';
  }

  public function client() {
    return new Client(['base_uri' => $this->apiurl]);
  }

  public function get_report() {
    try {
      $response = $this->client()->get('/api/list', [
        'query' => [
          'email' => $this->setting->email,
          'key' => $this->setting->key,
        ]
      ]);
      if($response->getStatusCode() == 200) {
        echo wp_send_json(json_decode($response->getBody()), 200);
      }
    } catch (\Exception $e) {
      echo wp_send_json([
        'message' => $e->getMessage()
      ], 417);
    }
    exit;
  }

  public function get_balance() {
    try {
      $response = $this->client()->get('/api/balance', [
        'query' => [
          'email' => $this->setting->email,
          'key' => $this->setting->key,
        ]
      ]);
      if($response->getStatusCode() == 200) {
        $data = json_decode($response->getBody());
        if((INT) $data->status === 0) {
          throw new \Exception($data->message);
        }

          
        echo wp_send_json([
          'balance' => number_format($data->balance, 0)
        ], 200);
      }
    } catch (\Exception $e) {
      echo wp_send_json([
        'message' => $e->getMessage()
      ], 417);
    }
    exit;
  }

  public function get_check() {
    try {
      if(is_null($this->request('chassis_no'))) {
        throw new \Exception("chassis_no is required");
      }

      $response = $this->client()->get('/api/check', [
        'query' => [
          'email' => $this->setting->email,
          'key' => $this->setting->key,
          'chassis_no' => $this->request('chassis_no')
        ]
      ]);
      if($response->getStatusCode() == 200) {
        $data = json_decode($response->getBody(), true);
        if($data['status'] == 1) {
          $result = [];
          foreach($data['data']['keys'] as $no => $key) {
            $result[] = [
              'chassis_no' => $no,
              'buy_url' => "{$this->apiurl}/topup?chassis_no={$no}&key=",
              'found' => $key['found']
            ];
          }
          echo wp_send_json($result , 200);
        } else {
          echo wp_send_json([
            'message' => $data['message']
          ], 417);
        }
      }
    } catch (\Exception $e) {
      echo wp_send_json([
        'message' => $e->getMessage()
      ], 417);
    }
    exit;
  }

  public function post_buy() {
    try {
      if(is_null($this->request('chassis_no'))) {
        throw new \Exception("chassis_no is required");
      }
      if(is_null($this->request('from'))) {
        throw new \Exception("from is required");
      }
      if(is_null($this->request('chassis_key'))) {
        throw new \Exception("chassis_key is required");
      }

      $response = $this->client()->get('/api/buy', [
        'query' => [
          'email' => $this->setting->email,
          'key' => $this->setting->key,
          'chassis_no' => $this->request('chassis_no'),
          'from' => $this->request('from'),
          'chassis_key' => $this->request('chassis_key'),
        ]
      ]);
      if($response->getStatusCode() == 200) {
        echo wp_send_json(json_decode($response->getBody()), 200);
      }
    } catch (\Exception $e) {
      echo wp_send_json([
        'message' => $e->getMessage()
      ], 417);
    }
    exit;
  }

  public function get_view() {
    try {

      if(is_null($this->request('report_id'))) {
        throw new \Exception("reposrt_id is required");
      }

      $response = $this->client()->get('/api/view', [
        'query' => [
          'email' => $this->setting->email,
          'key' => $this->setting->key,
          'report_id' => $this->request('report_id')
        ]
      ]);
      if($response->getStatusCode() == 200) {
        echo wp_send_json(json_decode($response->getBody()), 200);
      }
    } catch (\Exception $e) {
      echo wp_send_json([
        'message' => $e->getMessage()
      ], 417);
    }
    exit;
  }

  private function request($param) {
    $data = json_decode(file_get_contents("php://input"), true);
    return isset($data[$param]) ? $data[$param] : null;
  }

}