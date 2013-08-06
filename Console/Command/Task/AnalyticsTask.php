<?php
//
//  AnalyticsTask.php
//  Google API Cake Plugin
//
//  Created by Reed Dadoune <Reed@Dadoune.com> on 8/1/13.
//  Copyright (c) 2013 Reed Dadoune. All rights reserved.
//

define('GOOGLE_KEY_FILE', APP . DS . 'Config' . DS . 'googlekey.p12');
App::import('Vendor', 'GoogleApi.Google_Client', array('file' => 'Google' . DS . 'Google_Client.php'));
App::import('Vendor', 'GoogleApi.Google_AnalyticsService', array('file' => 'Google' . DS . 'contrib' . DS . 'Google_AnalyticsService.php'));
App::uses('Component', 'Controller');

class AnalyticsTask extends Shell {

	public $service = null;
	public $client = null;
	public $id = null;

	function __construct () {
		$this->id = sprintf('ga:%d', GOOGLE_ANALYTICS_ACCOUNT_ID);
		$this->client = new Google_Client();
		$this->client->setApplicationName('Google API Cake Plugin');

		if (Cache::read('Google.token')) {
			$this->client->setAccessToken(Cache::read('Google.token'));
		}

		$this->client->setAssertionCredentials(new Google_AssertionCredentials(
			GOOGLE_SERVICE_ACCOUNT_NAME,
			array('https://www.googleapis.com/auth/analytics.readonly'),
			file_get_contents(GOOGLE_KEY_FILE))
		);
		$this->client->setClientId(GOOGLE_CLIENT_ID);

		if ($this->client->getAuth()->isAccessTokenExpired()) {
			$this->client->getAuth()->refreshTokenWithAssertion();
		}

		$this->service = new Google_AnalyticsService($this->client);
		$this->token = $this->client->getAccessToken();
		Cache::write('Google.token', $this->token);
	}

	/*
		Example usage:
	 	$results = $this->Analytics->query(array(
			'start-date' => '2013-01-01',
			'metrics' => 'ga:pageviews',
			'dimensions' => 'ga:pagePath'
		));
		Output:
		Array (
			[0] => Array (
				[ga:pagePath] => /
				[ga:pageviews] => 367
			)
			[1] => Array (
				[ga:pagePath] => /account
				[ga:pageviews] => 27
			)
		);

		For API info check here:
		https://developers.google.com/analytics/devguides/reporting/core/v3/reference

	 */

	public function query($opts = array()) {
		$params = array(
			'ids' => $this->id,
			'start-date' => date('Y-m-d', strtotime('-1 day')),
			'end-date' => date('Y-m-d'),
			'metrics' => null,
			'dimensions' => null,
			'filters' => null
		);
		$params = array_merge($params, $opts);
		$optional = array_filter(array(
			'filters' => $params['filters'],
			'dimensions' => $params['dimensions']
		));

		$result = $this->service->data_ga->get(
			$params['ids'],
			$params['start-date'],
			$params['end-date'],
			$params['metrics'],
			$optional
		);

		$formattedResult = array();
		if (isset($result['columnHeaders']) && isset($result['rows'])) {
			foreach ($result['rows'] as $i => $row) {
				$formattedRow = array();
				foreach ($result['columnHeaders'] as $j => $column) {
					$formattedRow[$column['name']] = $row[$j];
				}
				array_push($formattedResult, $formattedRow);
			}
		}
		return $formattedResult;
	}
}
