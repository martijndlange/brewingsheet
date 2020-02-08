<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Exception;
use Google_Client;
use Google_Exception;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;

class Controller extends BaseController
{

  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  protected $service;

  protected $sheet_id;

  protected $developer_key;

  const RANGE_NAMES = 'Kasboek!I7:M7';

  const RANGE_MONTH = 'Kasboek!H8:H20';

  const RANGE_DATA = 'Kasboek!H7:M20';

  const RANGE_SALDO = 'Kasboek!B5';

  public function __construct()
  {
    $client = $this->getClient();
    $this->service = new Google_Service_Sheets($client);
    $this->sheet_id = env('SHEET_ID');
    $this->developer_key = env('DEVELOPER_KEY');
  }

  /**
   * Serve page
   *
   * @throws Exception
   */
  public function serve()
  {
    $saldo = $this->readData(self::RANGE_SALDO)[0][0];
    $data = json_encode($this->readData(self::RANGE_DATA));

    return view('welcome')->with(compact(
      'saldo',
      'data'
    ));
  }

  public function handleForm(Request $request)
  {
    $n = $request->get('name');
    $m = $request->get('month');
    $a = $request->get('amount');

    $cellCol = null;
    $cellRow = null;

    $names = current($this->readData(self::RANGE_NAMES));
    $months = $this->readData(self::RANGE_MONTH);

    foreach ($names as $index => $name) {
      if ($name === $n) {
        $strcol = 'IJKLM';
        $cellCol = substr($strcol, $index, 1);
        break;
      }
    }

    foreach ($months as $index => $month) {
      if (current($month) === $m) {
        $cellRow = ($index + 8);  // months start at row 9
        break;
      }
    }

    if (!empty($cellCol) && !empty($cellRow)) {
      $cell = $cellCol . $cellRow;
      $value = $a > 0 ? '€' . $a . ',00' : '';
      $this->writeData($cell, $value);
    }

    $saldo = $this->readData(self::RANGE_SALDO)[0][0];
    $data = json_encode($this->readData(self::RANGE_DATA));

    return view('welcome')->with(compact(
      'saldo',
      'data'
    ));
  }

  private function readData($range)
  {
    $response = $this->service->spreadsheets_values->get($this->sheet_id, $range);
    $values = $response->getValues();
    return $values ?? [];
  }

  private function writeData($cell, $value)
  {
    $valueInputOption = 'USER_ENTERED';
    $values = [[$value],];
    $body = new Google_Service_Sheets_ValueRange(
      [
        'values' => $values,
      ]
    );
    $params = [
      'valueInputOption' => $valueInputOption,
    ];
    $range = 'Kasboek!' . $cell;
    $result = $this->service->spreadsheets_values->update($this->sheet_id, $range, $body, $params);
    return $result->getUpdatedCells();
  }

  /**
   * Returns an authorized API client.
   *
   * @return Google_Client the authorized client object
   * @throws Google_Exception
   * @throws Exception
   */
  private function getClient()
  {
    $client = new Google_Client();
    $client->setApplicationName('BUK Brewing');
    $client->setScopes(Google_Service_Sheets::SPREADSHEETS);
    $client->setDeveloperKey($this->developer_key);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
      $accessToken = json_decode(file_get_contents($tokenPath), true);
      $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
      // Refresh the token if possible, else fetch a new one.
      if ($client->getRefreshToken()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
      } else {
        // Request authorization from the user.
        $authUrl = $client->createAuthUrl();
        printf("Open the following link in your browser:\n%s\n", $authUrl);
        print 'Enter verification code: ';
        $authCode = trim(fgets(STDIN));

        // Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
        $client->setAccessToken($accessToken);

        // Check to see if there was an error.
        if (array_key_exists('error', $accessToken)) {
          throw new Exception(join(', ', $accessToken));
        }
      }
      // Save the token to a file.
      if (!file_exists(dirname($tokenPath))) {
        mkdir(dirname($tokenPath), 0700, true);
      }
      file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
  }

}
