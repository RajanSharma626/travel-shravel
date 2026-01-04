<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Itinerary - {{ $lead->tsq }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #000;
            padding: 20px;
        }
        
        /* Header Styles */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }
        .header-wrapper {
            display: table-row;
        }
        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 70%;
        }
        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 30%;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 8px;
            color: #000;
        }
        .tagline {
            font-size: 14px;
            color: #555;
            font-style: italic;
            margin-bottom: 10px;
        }
        .logo {
            max-width: 100px;
            max-height: 100px;
            width: auto;
            height: auto;
        }
        
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }
        table td, table th {
            padding: 10px 12px;
            border: 1px solid #333;
            text-align: left;
            vertical-align: top;
        }
        table th {
            background-color: #2c3e50;
            color: #fff;
            font-weight: bold;
            font-size: 12px;
            text-align: center;
        }
        
        /* Customer Information Table */
        .info-table {
            margin-bottom: 25px;
            border: 2px solid #2c3e50;
            background-color: #ffffff;
        }
        .info-table td {
            border: 1px solid #333;
            padding: 8px 10px;
            vertical-align: middle;
        }
        .info-table tr {
            border-bottom: 1px solid #333;
        }
        .info-table tr:last-child {
            border-bottom: none;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 20%;
            background-color: #e8ecef;
            font-size: 11px;
            color: #2c3e50;
            border-right: 2px solid #2c3e50;
            text-align: left;
            padding: 8px 12px;
        }
        .info-table td:nth-child(2),
        .info-table td:nth-child(3) {
            background-color: #ffffff !important;
        }
        .info-table td:nth-child(4),
        .info-table td:nth-child(6) {
            font-weight: bold;
            text-align: center;
            background-color: #e8ecef !important;
            color: #2c3e50;
            font-size: 11px;
            width: 12%;
            border-left: 2px solid #2c3e50;
            letter-spacing: 0.3px;
            white-space: nowrap;
            padding: 8px 6px;
        }
        .info-table td:nth-child(4) strong,
        .info-table td:nth-child(6) strong {
            background-color: transparent;
        }
        .info-table td:nth-child(5),
        .info-table td:nth-child(7) {
            font-weight: bold;
            text-align: center;
            background-color: #ffffff !important;
            font-size: 16px;
            color: #2c3e50;
            width: 10%;
            padding: 8px 8px;
        }
        /* Ensure all value cells have white background */
        .info-table td:nth-child(5),
        .info-table td:nth-child(7),
        .info-table .data-cell,
        .info-table .room-types,
        .info-table .voucher-number {
            background-color: #ffffff !important;
        }
        .info-table .data-cell {
            font-weight: 600;
            font-size: 10px !important;
            color: #000;
            line-height: 1.4;
            background-color: #ffffff !important;
        }
        .room-types {
            text-align: center;
            font-weight: bold;
            font-size: 10px !important;
            color: #2c3e50;
            font-family: 'Arial Black', Arial, sans-serif;
            background-color: #ffffff !important;
        }
        .room-label {
            font-weight: bold;
            text-align: center;
            background-color: #e8ecef !important;
            color: #2c3e50;
            border-right: 1px solid #333;
            letter-spacing: 0.3px;
            white-space: nowrap;
            padding: 8px 6px;
            font-size: 9px !important;
        }
        .customer-name {
            font-weight: 600;
            font-size: 12px;
            color: #000;
            line-height: 1.4;
            background-color: #ffffff !important;
        }
        .customer-name .name-part {
            font-weight: 600;
            font-size: 12px;
            color: #000;
        }
        .customer-name .count-part {
            font-weight: 500;
            font-size: 11px;
            color: #555;
            margin-left: 5px;
        }
        .contact-info {
            font-weight: 600;
            font-size: 11px;
            color: #000;
            word-break: keep-all;
            white-space: normal;
            line-height: 1.5;
            background-color: #ffffff !important;
        }
        .voucher-label {
            font-weight: bold;
            font-size: 10px;
            white-space: nowrap;
        }
        .voucher-number {
            font-weight: 600;
            font-size: 11px;
            color: #000;
            font-family: 'Courier New', monospace;
            background-color: #ffffff !important;
        }
        .email-cell {
            font-weight: 600;
            font-size: 9px !important;
            color: #000;
            word-break: keep-all;
            white-space: nowrap;
            background-color: #ffffff !important;
        }
        
        /* Hotel Table Styles */
        .hotel-table {
            margin-bottom: 25px;
        }
        .hotel-table th {
            background-color: #2c3e50;
            color: #fff;
            font-weight: bold;
            font-size: 13px;
            text-align: center;
            padding: 12px;
        }
        .hotel-table td {
            padding: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .hotel-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        /* Itinerary Table Styles */
        .itinerary-table {
            margin-bottom: 25px;
        }
        .itinerary-table > thead > tr > th {
            background-color: #2c3e50;
            color: #fff;
            font-weight: bold;
            font-size: 14px;
            text-align: center;
            padding: 15px;
        }
        .itinerary-table td {
            padding: 12px 15px;
            border: 1px solid #333;
            vertical-align: top;
        }
        .day-cell {
            font-weight: bold;
            font-size: 14px;
            background-color: #e8ecef;
            text-align: center;
            vertical-align: middle;
            width: 15%;
            padding: 15px 10px;
        }
        .day-number {
            font-size: 16px;
            color: #2c3e50;
        }
        .day-date {
            font-size: 12px;
            color: #555;
            margin-top: 5px;
        }
        .schedule-cell {
            padding: 15px;
            font-size: 12px;
            line-height: 1.8;
        }
        .time-label {
            font-weight: bold;
            font-size: 13px;
            color: #2c3e50;
            margin-bottom: 8px;
            display: block;
        }
        .schedule-content {
            font-size: 12px;
            line-height: 1.7;
            margin-left: 0;
        }
        .schedule-content strong {
            font-weight: 600;
        }
        .stay-cell {
            padding: 12px 15px;
            font-style: italic;
            font-size: 12px;
            color: #555;
            background-color: #f8f9fa;
        }
        .stay-cell strong {
            font-weight: 600;
            font-style: normal;
        }
        
        /* Meeting Point Notice */
        .meeting-notice {
            background-color: #fff3cd;
            border: 2px solid #ffc107;
            padding: 12px 15px;
            font-size: 11px;
            font-weight: 600;
            color: #856404;
            font-style: italic;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            margin-top: 35px;
            padding-top: 20px;
            border-top: 2px solid #333;
            font-style: italic;
            font-size: 13px;
            color: #555;
            font-weight: 500;
        }
        
        /* Section Spacing */
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #2c3e50;
            padding-bottom: 8px;
            border-bottom: 2px solid #2c3e50;
        }
        
        /* Better spacing for activities */
        .activity-item {
            margin-bottom: 6px;
            padding-left: 0;
        }
        .activity-item:before {
            content: "• ";
            font-weight: bold;
            color: #2c3e50;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-wrapper">
            <div class="header-left">
                <div class="company-name">TRAVEL SHRAVEL</div>
                <div class="tagline">Nothing Unexplored</div>
            </div>
            @if(isset($logoBase64) && $logoBase64)
            <div class="header-right">
                <img src="{{ $logoBase64 }}" alt="Travel Shravel Logo" class="logo">
            </div>
            @endif
        </div>
    </div>

    <!-- Customer Information Table -->
    <table class="info-table">
        <tr>
            <td><strong>Travel Date</strong></td>
            <td class="data-cell" colspan="2">{{ $lead->travel_date ? \Carbon\Carbon::parse($lead->travel_date)->format('l, F d, Y') : 'N/A' }}</td>
            <td style="background-color: #e8ecef !important;"><strong>TST No.</strong></td>
            <td class="data-cell" style="background-color: #ffffff !important;">{{ $lead->tsq }}</td>
            <td style="background-color: #e8ecef !important;"><span class="voucher-label">Voucher Number</span></td>
            <td class="voucher-number" style="background-color: #ffffff !important;">{{ $lead->operation->voucher_number ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Name</strong></td>
            <td class="customer-name" colspan="2">
                <span class="name-part">{{ $lead->salutation ?? '' }} {{ $lead->first_name }} {{ $lead->last_name ?? '' }}</span>
                <span class="count-part">x {{ ($lead->adults ?? 1) + ($lead->children_2_5 ?? 0) + ($lead->children_6_11 ?? 0) + ($lead->infants ?? 0) }}</span>
            </td>
            <td class="room-label" style="background-color: #e8ecef !important;">DBL</td>
            <td class="room-types" style="background-color: #ffffff !important;">{{ $lead->adults ?? 0 }}</td>
            <td class="room-label" style="background-color: #e8ecef !important;">EBA</td>
            <td class="room-types" style="background-color: #ffffff !important;">{{ $lead->children_2_5 ?? 0 }}</td>
        </tr>
        <tr>
            <td><strong>Emergency Contact</strong></td>
            <td class="contact-info" colspan="2">
                @php
                    $phoneNumbers = [];
                    if ($lead->primary_phone) {
                        $phoneNumbers[] = $lead->primary_phone;
                    } elseif ($lead->phone) {
                        $phoneNumbers[] = $lead->phone;
                    }
                    if ($lead->secondary_phone) {
                        $phoneNumbers[] = $lead->secondary_phone;
                    }
                    if ($lead->other_phone) {
                        $phoneNumbers[] = $lead->other_phone;
                    }
                    echo implode(', ', $phoneNumbers);
                @endphp
            </td>
            <td class="room-label" style="background-color: #e8ecef !important;">CNB</td>
            <td class="room-types" style="background-color: #ffffff !important;">{{ $lead->children_6_11 ?? 0 }}</td>
            <td class="room-label" style="background-color: #e8ecef !important;">CWB</td>
            <td class="room-types" style="background-color: #ffffff !important;">{{ $lead->children_6_11 ?? 0 }}</td>
        </tr>
        <tr>
            <td colspan="3" class="meeting-notice">At meeting point, there would be a placard holder carrying a placard of your name or company's name.</td>
            <td class="room-label" style="background-color: #e8ecef !important;">INF</td>
            <td class="room-types" style="background-color: #ffffff !important;">{{ $lead->infants ?? 0 }}</td>
            <td style="background-color: #e8ecef !important;"><strong>E-mail</strong></td>
            <td class="email-cell" style="background-color: #ffffff !important;">{{ $lead->email ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- Hotel Information Table -->
    @if($lead->bookingAccommodations && $lead->bookingAccommodations->count() > 0)
    <div class="section-title">Accommodation Details</div>
    <table class="hotel-table">
        <thead>
            <tr>
                <th>Stay at</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Room type</th>
                <th>No. of rooms</th>
                <th>Confirmation No.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lead->bookingAccommodations as $accommodation)
            <tr>
                <td><strong>{{ $accommodation->stay_at ?? 'N/A' }}</strong></td>
                <td><strong>{{ $accommodation->checkin_date ? \Carbon\Carbon::parse($accommodation->checkin_date)->format('d-M') : 'N/A' }}</strong></td>
                <td><strong>{{ $accommodation->checkout_date ? \Carbon\Carbon::parse($accommodation->checkout_date)->format('d-M') : 'N/A' }}</strong></td>
                <td><strong>{{ $accommodation->room_type ?? 'N/A' }}</strong></td>
                <td style="text-align: center;"><strong>1</strong></td>
                <td><strong>{{ $accommodation->booking_status ?? 'N/A' }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Itinerary Section -->
    <div class="section-title">Itinerary</div>
    <table class="itinerary-table">
        <thead>
            <tr>
                <th style="width: 15%;">Day & Date</th>
                <th style="width: 85%;">Schedule & Activities</th>
            </tr>
        </thead>
        <tbody>
            @if($lead->bookingItineraries && $lead->bookingItineraries->count() > 0)
                @php
                    $groupedItineraries = [];
                    $dayCounter = 1;
                    
                    // Group itineraries by day
                    foreach($lead->bookingItineraries as $itinerary) {
                        // Extract day number from day_and_date
                        $dayMatch = preg_match('/Day\s*(\d+)/i', $itinerary->day_and_date ?? '', $matches);
                        $dayNumber = $dayMatch ? (int)$matches[1] : $dayCounter;
                        
                        if (!isset($groupedItineraries[$dayNumber])) {
                            $groupedItineraries[$dayNumber] = [];
                        }
                        $groupedItineraries[$dayNumber][] = $itinerary;
                        
                        if (!$dayMatch) {
                            $dayCounter++;
                        }
                    }
                    
                    // Sort by day number
                    ksort($groupedItineraries);
                @endphp
                
                @foreach($groupedItineraries as $dayNumber => $dayItineraries)
                    @php
                        $firstItinerary = $dayItineraries[0];
                        
                        // Extract date from day_and_date
                        $dateMatch = preg_match('/(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})/', $firstItinerary->day_and_date ?? '', $dateMatches);
                        $dateStr = $dateMatch ? $dateMatches[1] : '';
                        $formattedDate = '';
                        if ($dateStr) {
                            try {
                                $dateObj = \Carbon\Carbon::createFromFormat('d/m/Y', str_replace('-', '/', $dateStr));
                                $formattedDate = $dateObj->format('d-M');
                            } catch (\Exception $e) {
                                try {
                                    $dateObj = \Carbon\Carbon::parse($dateStr);
                                    $formattedDate = $dateObj->format('d-M');
                                } catch (\Exception $e2) {
                                    $formattedDate = $dateStr;
                                }
                            }
                        }
                        
                        // Determine time label
                        $timeStr = $firstItinerary->time ? \Carbon\Carbon::parse($firstItinerary->time)->format('H:i') : '';
                        $timeLabel = 'Schedule';
                        if (stripos($firstItinerary->day_and_date ?? '', 'depart') !== false || stripos($firstItinerary->day_and_date ?? '', 'departure') !== false) {
                            $timeLabel = 'Depart';
                        } elseif (stripos($firstItinerary->day_and_date ?? '', 'pick-up') !== false || stripos($firstItinerary->day_and_date ?? '', 'pickup') !== false) {
                            $timeLabel = 'Pick-up';
                        } elseif ($timeStr) {
                            $timeLabel = $timeStr . ' Hours';
                        }
                    @endphp
                    
                    <tr>
                        <td class="day-cell" rowspan="2">
                            <div class="day-number">Day {{ $dayNumber }}</div>
                            @if($formattedDate)
                                <div class="day-date">{{ $formattedDate }}</div>
                            @endif
                        </td>
                        <td class="schedule-cell">
                            <span class="time-label">{{ $timeLabel }}</span>
                            <div class="schedule-content">
                                @foreach($dayItineraries as $itinerary)
                                    @if($itinerary->location)
                                        <strong>{{ $itinerary->location }}</strong><br>
                                    @endif
                                    @if($itinerary->activity_tour_description)
                                        @php
                                            $activities = array_filter(array_map('trim', explode("\n", str_replace(["\r\n", "\r"], "\n", $itinerary->activity_tour_description))));
                                        @endphp
                                        @foreach($activities as $activity)
                                            @if(!empty($activity))
                                                <div class="activity-item">{{ $activity }}</div>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="stay-cell">
                            @php
                                $stayAt = $firstItinerary->stay_at ?? null;
                            @endphp
                            <strong>Stay:</strong> 
                            @if($stayAt)
                                Stay overnight at <strong>{{ $stayAt }}</strong>.
                            @else
                                Stay overnight at <strong>pre-booked accommodation</strong>.
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" style="text-align: center; padding: 30px; font-size: 13px; color: #999;">
                        <strong>No itinerary data available</strong>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <strong>"Travel Shravel wishes you a very happy, comfortable and safe journey"</strong>
    </div>
</body>
</html>
