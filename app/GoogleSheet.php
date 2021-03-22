<?php

namespace App;

use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_ClearValuesRequest;

class GoogleSheet
{

	private $client 	= null;
	private $id 		= null;
	private $service 	= null;

	function __construct($id = null, $client = null) {

		$this->id = is_null($id) ? $this->id : $id;
		$this->client = is_null($client) ? $this->client : $client;

		if(!is_null($client)){

			$this->service =  new Google_Service_Sheets($this->client);

		}

	}

	public function setId ($id){

		$this->id = is_null($id) ? $this->id : $id;

	}

	public function Read($range){

		try{

			$result = $this->service->spreadsheets_values->get($this->id, $range);

			return $result->getValues() != null ? $result->getValues() : [];

		} catch (\Exception $e){

			return json_decode($e->getMessage(), true);

		}

	}

	public function Write($range,$rows){

		try{

			$body = new Google_Service_Sheets_ValueRange([
				'values' => $rows
			]);

			$params = [
				'valueInputOption' => "RAW",
			];

			return $this->service->spreadsheets_values->update($this->id, $range, $body, $params);

		} catch (\Exception $e){

			return json_decode($e->getMessage(),true);

		}

	}

	public function Append($range,$rows){

		try{

			$body = new Google_Service_Sheets_ValueRange([
				'values' => $rows
			]);

			$params = [
				'valueInputOption' => "RAW",
				'insertDataOption' => "INSERT_ROWS"
			];

			return $this->service->spreadsheets_values->append($this->id, $range, $body, $params);

		} catch (\Exception $e){

			return json_decode($e->getMessage(),true);

		}

	}

	public function Clear($range){

		try{

			$body = new Google_Service_Sheets_ClearValuesRequest();

			return $this->service->spreadsheets_values->clear($this->id, $range, $body);

		} catch (\Exception $e){

			return json_decode($e->getMessage(),true);

		}

	}

	public function Color($range)
	{
		$requests = [
			new Google_Service_Sheets_Request( [
				'repeatCell' => [
		 
					// Диапазон, который будет затронут
					"range" => [
						"sheetId"          => 50969847, // ID листа
						"startRowIndex"    => 10,
						"endRowIndex"      => 10,
						"startColumnIndex" => 1,
						"endColumnIndex"   => 1
					],
		 
					// Формат отображения данных
					// https://developers.google.com/sheets/api/reference/rest/v4/spreadsheets#CellFormat
					"cell"  => [
						"userEnteredFormat" => [
							// Фон (RGBA)
							// https://developers.google.com/sheets/api/reference/rest/v4/spreadsheets#Color
							"backgroundColor"     => [
								"green" => 1,
								"red"   => 1
							],
							// https://developers.google.com/sheets/api/reference/rest/v4/spreadsheets#HorizontalAlign
							"horizontalAlignment" => "CENTER",
							// https://developers.google.com/sheets/api/reference/rest/v4/spreadsheets#padding
							// "padding"             => [
							// 	"left"   => 10,
							// 	"bottom" => 50,
							// 	"right"  => 30,
							// 	"top"    => 11
							// ],
							// // https://developers.google.com/sheets/api/reference/rest/v4/spreadsheets#textformat
							// "textFormat"          => [
							// 	"bold"      => true,
							// 	"fontSize"  => 25,
							// 	"italic"    => true,
							// 	"underline" => true
							// ]
						]
					],
		 
					"fields" => "UserEnteredFormat(backgroundColor,horizontalAlignment)" //,padding,textFormat
				]
			] )
		];
		 
		$batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest( [
			'requests' => $requests
		] );
		 
		return $this->service->spreadsheets->batchUpdate( $this->id, $batchUpdateRequest );
	}


}
