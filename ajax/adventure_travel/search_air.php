<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
include "../../include/settings.php";
include "../../include/templates.php";
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$logged = $core->check_login();
if ($logged == "TRUE") {

	$origin = $_GET['origin'];
	$destination = $_GET['destination'];

	$date1 = $_GET['date1'];
	$date2 = $_GET['date2'];

	if ($_GET['includedcarriers'] != "") {
		$includedcarriers = "&includedcarriers=$_GET[includedcarriers]";
	}

	//$payload = "v1/shop/flights/fares?origin=".$origin."&destination=".$destination."&lengthofstay=4";
	$payload = "v1/shop/flights?origin=";
	$payload .= $origin;
	$payload .= "&destination=";
	$payload .= $destination;
	$payload .= "&departuredate=";
	$payload .= $date1;
	$payload .= "&returndate=";
	$payload .= $date2;
	$payload .= "&pointofsalecountry=US";
	$payload .= $includedcarriers;
	//$payload .= "&limit=2"; 
	$payload .= "&passengercount=" . $_GET['passengercount'];

	//print "$payload<br>";

	$response = $core->sabre_sendRequest($payload);
	$json = json_decode($response);


	$message = $json->message;
	if ($message != "") {
		print "<br><font color=red><b>$message</b></font><br>";
	}

	$PricedItineraries = $json->PricedItineraries;
	$i = count($PricedItineraries);
	
	// loop through $i
	for ($x=0; $x < $i; $x++) {
		//print "<h3>Itinerary $x:<h3>";
		$AirItinerary = $json->PricedItineraries[$x]->AirItinerary;
		$AirItineraryPricingInfo = $json->PricedItineraries[$x]->AirItineraryPricingInfo;
		// Total cost all pax (before AF fee)
		$total_cost[$x] = $json->PricedItineraries[$x]->AirItineraryPricingInfo->ItinTotalFare->TotalFare->Amount;

		// This is the round trip. first is arrival 2nd is return
		$i2 = count($AirItinerary->OriginDestinationOptions->OriginDestinationOption);
		// loop through $i2
		for ($x2=0; $x2 < $i2; $x2++) {
			if ($x2 == "0") {
				$status = "departure";
				//print "<h3>Departure:</h3>";
			}
			if ($x2 == "1") {
				$status = "return";
				//print "<h3>Return:</h3>";
			}

			// cabin class
			$cabin = $core->cabin_class(
				$AirItineraryPricingInfo->FareInfos->FareInfo[$x2]->TPA_Extensions->Cabin->Cabin
			);
			// remaining seats
			$remaining = $AirItineraryPricingInfo->FareInfos->FareInfo[$x2]->TPA_Extensions->SeatsRemaining->Number;

			$OriginDestinationOption = $AirItinerary
				->OriginDestinationOptions
				->OriginDestinationOption[$x2]
			;
			$FlightSegment = $OriginDestinationOption->FlightSegment;
			$leg = count($FlightSegment);
			if ($leg == "0") {
				$leg = "1";
			}
			for ($x3 = 0; $x3 < $leg; $x3++) {
				$DepartureAirport = $FlightSegment[$x3]->DepartureAirport->LocationCode;
				$ArrivalAirport = $FlightSegment[$x3]->ArrivalAirport->LocationCode;
				$MarketingAirline = $FlightSegment[$x3]->MarketingAirline->Code;
				$ArrivalTimeZone = $FlightSegment[$x3]->ArrivalTimeZone->GMTOffset;
				$ElapsedTime = $FlightSegment[$x3]->ElapsedTime;
				$Equipment = $FlightSegment[$x3]->Equipment->AirEquipType;
				$DepartureDateTime = $FlightSegment[$x3]->DepartureDateTime;
				$ArrivalDateTime = $FlightSegment[$x3]->ArrivalDateTime;
				$FlightNumber = $FlightSegment[$x3]->FlightNumber;

				$trip[$x][$status][$x3]['DepartureAirport'] = $DepartureAirport;
				$trip[$x][$status][$x3]['ArrivalAirport'] = $ArrivalAirport;
				$trip[$x][$status][$x3]['MarketingAirline'] = $MarketingAirline;
				$trip[$x][$status][$x3]['ArrivalTimeZone'] = $ArrivalTimeZone;
				$trip[$x][$status][$x3]['ElapsedTime'] = $ElapsedTime;
				$trip[$x][$status][$x3]['DepartureDateTime'] = $DepartureDateTime;
				$trip[$x][$status][$x3]['ArrivalDateTime'] = $ArrivalDateTime;
				$trip[$x][$status][$x3]['FlightNumber'] = $FlightNumber;
				$trip[$x][$status][$x3]['Cabin_Class'] = $cabin;
				$trip[$x][$status][$x3]['seats_remaining'] = $remaining;

				/*
				print "
				Leg $x3<br>
				DepartureAirport : $DepartureAirport<br>
				ArrivalAirport : $ArrivalAirport<br>
				MarketingAirline : $MarketingAirline<br>
				ArrivalTimeZone : $ArrivalTimeZone<br>
				ElapsedTime : $ElapsedTime<br>
				Equipment : $Equipment<br>
				DepartureDateTime : $DepartureDateTime<br>
				ArrivalDateTime : $ArrivalDateTime<br>
				FlightNumber : $FlightNumber<br><br><br>
				";
				*/					
			}
			//print "Test $test<br>";
			//print "<pre>";
			//print_r($FlightSegment);
			//print "</pre>";
		}
	}

	print "<br><br>";
	foreach ($trip as $itinerary=>$flights) {
		$itin = $itinerary +1;
		print "
		<div class=\"panel panel-info\">
			<div class=\"row pad-top\">
				<div class=\"col-sm-12\">
					<h3>
					&nbsp;&nbsp;Itinerary $itin : Total $_GET[passengercount] passengers $".
					number_format($total_cost[$itin],2,'.',','). "&nbsp;USD
					&nbsp;
					<div class=\"pull-right\">
						<input type=\"button\" value=\"Select Flight\" class=\"btn btn-success btn-lg\">
						&nbsp;&nbsp;
					</div>
					</h3>
				</div>
			</div>
			<div class=\"row pad-top\">
				<div class=\"col-sm-6\"><b>&nbsp;&nbsp;Departure</b></div>
				<div class=\"col-sm-6\"><b>&nbsp;&nbsp;Return</b></div>
			</div>
		";

		print "<div class=\"row pad-top\">";
		foreach ($flights as $key=>$value) {
			$badge = "0";
			print "<div class=\"col-sm-6\">";

			foreach ($value as $key2=>$value2) {
				foreach ($value2 as $key3=>$value3) {
					if ($key3 == "DepartureAirport") {
						$DepartureAirport = $value3;
					}
					if ($key3 == "ArrivalAirport") {
						$ArrivalAirport = $value3;
					}
					if ($key3 == "MarketingAirline") {
						$MarketingAirline = $value3;
					}
					if ($key3 == "ArrivalTimeZone") {
						$ArrivalTimeZone = $value3;
					}
					if ($key3 == "ElapsedTime") {
						$ElapsedTime = $value3;
					}
					if ($key3 == "DepartureDateTime") {
						$DepartureDateTime = $value3;
					}
					if ($key3 == "ArrivalDateTime") {
						$ArrivalDateTime = $value3;
					}
					if ($key3 == "FlightNumber") {
						$FlightNumber = $value3;
					}
					if ($key3 == "Cabin_Class") {
						$Cabin_Class = $value3;
					}
					if ($key3 == "seats_remaining") {
						$seats_remaining = $value3;
					}
				}
				$time = $core->convertToHoursMins($ElapsedTime, '%02d hours %02d minutes');
				$found_air = "0";
				$sql = "SELECT `name`,`logo` FROM `iata_airline_codes` 
				WHERE `code` = '$MarketingAirline' LIMIT 1";
				$result = $core->new_mysql($sql);
				while ($row = $result->fetch_assoc()) {
					$airline = $row['name'];
					$airlogo = $row['logo'];
					$found_air = "1";
				}
				if ($found_air == "0") {
					$airlogo = "";
					$airline = $MarketingAirline;
				}

				$date1 = date("m/d/Y", strtotime($DepartureDateTime));
				$time1 = date("h:i a", strtotime($DepartureDateTime));

				$date2 = date("m/d/Y", strtotime($ArrivalDateTime));
				$time2 = date("h:i a", strtotime($ArrivalDateTime));				

				$badge++;
				print "
				<div class=\"row top-buffer\">
					<div class=\"col-sm-12\">";
						if ($found_air != "0") {
							print "<img src=\"/airlogo/".$airlogo."\">";
						} else {
							print "<font color=red>Logo not found</font>";
						}
					print "
					</div>
				</div>
				<div class=\"row top-buffer\">
					<div class=\"col-sm-1\"><span class=\"badge\">$badge</span></div>
					<div class=\"col-sm-11\">
						<div class=\"pull-left\">$date1 ($time1) - $date2 ($time2)</div>
						<div class=\"pull-right alert alert-info\">$time</div>
					</div>
				</div>
				<div class=\"row top-buffer\">
					<div class=\"col-sm-6\">$DepartureAirport to $ArrivalAirport</div>
					<div class=\"col-sm-3\">$airline</div>
					<div class=\"col-sm-3\">Flight # $FlightNumber</div>
				</div>
				<div class=\"row top-buffer\">
					<div class=\"col-sm-3\">Class: $Cabin_Class</div>
					<div class=\"col-sm-3\">Seats Remaining: $seats_remaining</div>
				</div>
				";
			}
			print "</div>";
		}
		print "
				<div class=\"row pad-top\">
					<div class=\"col-sm-12\"><br></div>
				</div>
			</div>
		</div>
		";

	}

}
?>