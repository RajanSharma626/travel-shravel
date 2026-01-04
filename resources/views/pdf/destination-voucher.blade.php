<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destination Voucher - {{ $lead->tsq }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 11px;
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
            border-bottom: 3px solid #2c3e50;
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
            margin-bottom: 5px;
            color: #000;
        }
        .voucher-title {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 12px;
            margin-top: 8px;
        }
        .greeting {
            font-size: 12px;
            color: #000;
            margin-top: 5px;
            line-height: 1.8;
        }
        .logo {
            max-width: 100px;
            max-height: 100px;
            width: auto;
            height: auto;
        }
        
        /* Section Dividers */
        .section-divider {
            margin: 25px 0 15px 0;
            border-top: 2px solid #2c3e50;
            padding-top: 15px;
        }
        .section-header {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #ccc;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
            border: 2px solid #2c3e50;
        }
        table td, table th {
            padding: 6px 8px;
            border: 1px solid #333;
            text-align: left;
            vertical-align: middle;
        }
        table th {
            background-color: #2c3e50;
            color: #fff;
            font-weight: bold;
            text-align: center;
            font-size: 10px;
            padding: 8px 6px;
        }
        table td {
            background-color: #ffffff;
        }
        
        /* Accommodation Table */
        .accommodation-table {
            margin-bottom: 25px;
        }
        .accommodation-table td {
            padding: 6px 8px;
            font-size: 11px;
        }
        .accommodation-table td:first-child,
        .accommodation-table td:nth-child(3),
        .accommodation-table td:nth-child(5),
        .accommodation-table td:nth-child(7) {
            font-weight: bold;
            background-color: #e8ecef;
            width: 12%;
            color: #2c3e50;
            font-size: 10px;
        }
        .accommodation-table td:nth-child(2),
        .accommodation-table td:nth-child(4),
        .accommodation-table td:nth-child(6),
        .accommodation-table td:nth-child(8) {
            background-color: #ffffff;
            font-weight: 600;
            font-size: 11px;
        }
        
        /* Guest Details Tables */
        .guest-details-wrapper {
            margin-bottom: 25px;
        }
        .guest-details-table {
            margin-bottom: 20px;
            width: 100%;
        }
        .guest-details-table:last-of-type {
            margin-bottom: 0;
        }
        .guest-details-table th {
            background-color: #2c3e50;
            color: #fff;
            font-weight: bold;
            font-size: 10px;
            text-align: center;
            padding: 8px 6px;
        }
        .guest-details-table td {
            padding: 6px 8px;
            font-size: 11px;
            vertical-align: middle;
        }
        .guest-details-table .label-cell {
            font-weight: bold;
            background-color: #e8ecef;
            text-align: center;
            color: #2c3e50;
            font-size: 10px;
        }
        .guest-details-table .value-cell {
            text-align: center;
            background-color: #ffffff;
            font-weight: 600;
            font-size: 11px;
        }
        .guest-details-table .name-cell {
            font-weight: 600;
            font-size: 11px;
            background-color: #ffffff;
        }
        .guest-details-table .trpl-note {
            font-style: italic;
            font-size: 9px;
            color: #555;
            background-color: #ffffff;
            padding-top: 4px;
        }
        
        /* Transportation Table */
        .transportation-table {
            margin-bottom: 25px;
        }
        .transportation-table th {
            background-color: #2c3e50;
            color: #fff;
            font-weight: bold;
            font-size: 10px;
            text-align: center;
            padding: 8px 6px;
        }
        .transportation-table td {
            padding: 6px 8px;
            font-size: 11px;
            background-color: #ffffff;
            text-align: center;
        }
        
        /* Hotel Contact Table */
        .hotel-contact-table {
            margin-bottom: 25px;
        }
        .hotel-contact-table td:first-child,
        .hotel-contact-table td:nth-child(3) {
            font-weight: bold;
            background-color: #e8ecef;
            width: 15%;
            color: #2c3e50;
            font-size: 10px;
        }
        .hotel-contact-table td:nth-child(2),
        .hotel-contact-table td:nth-child(4) {
            background-color: #ffffff;
            font-weight: 600;
            font-size: 12px;
        }
        
        /* Services Section */
        .services-section {
            margin: 25px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 12px;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .services-list {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }
        .services-list li {
            padding: 8px 0;
            padding-left: 25px;
            position: relative;
            font-size: 11px;
            line-height: 1.6;
            border-bottom: 1px solid #e0e0e0;
        }
        .services-list li:last-child {
            border-bottom: none;
        }
        .services-list li:before {
            content: "•";
            position: absolute;
            left: 8px;
            font-weight: bold;
            color: #2c3e50;
            font-size: 14px;
        }
        
        /* Comments, Remarks, Caution Sections */
        .info-section {
            margin: 20px 0;
            padding: 15px;
            background-color: #ffffff;
            border-left: 4px solid #2c3e50;
            border-right: 1px solid #ddd;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }
        .info-section-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2c3e50;
            text-transform: uppercase;
        }
        .info-section-content {
            font-size: 11px;
            line-height: 1.7;
            color: #000;
        }
        
        /* Footer */
        .footer {
            margin-top: 35px;
            padding: 15px;
            border: 1px solid #000;
            font-size: 10px;
            color: #2c3e50;
        }
        .footer-header {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        .footer-title {
            display: table-cell;
            font-style: italic;
            font-size: 10px;
            color: #2c3e50;
            vertical-align: top;
            width: 65%;
        }
        .signature-box {
            display: table-cell;
            vertical-align: top;
            text-align: right;
            width: 35%;
            padding-left: 10px;
        }
        .signature-placeholder {
            width: 140px;
            height: 45px;
            border: 1px solid #2c3e50;
            margin-left: auto;
            margin-right: 0;
            margin-bottom: 5px;
            background-color: #ffffff;
        }
        .signature-label {
            font-size: 9px;
            color: #2c3e50;
            text-align: center;
            width: 140px;
            margin-left: auto;
            margin-right: 0;
        }
        .footer-company-name {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            color: #2c3e50;
            margin-bottom: 12px;
        }
        .footer-address-section {
            display: table;
            width: 100%;
            margin-bottom: 12px;
        }
        .address-left {
            display: table-cell;
            vertical-align: top;
            width: 22%;
            font-weight: bold;
            padding-right: 8px;
        }
        .address-right {
            display: table-cell;
            vertical-align: top;
            width: 78%;
        }
        .footer-contact-section {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        .contact-left {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }
        .contact-right {
            display: table-cell;
            vertical-align: top;
            width: 50%;
            text-align: right;
            padding-left: 10px;
        }
        .footer-website {
            text-align: center;
            text-decoration: underline;
            color: #0066cc;
            font-size: 10px;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-wrapper">
            <div class="header-left">
                <div class="company-name">TRAVEL SHRAVEL</div>
                <div class="voucher-title">Accommodation Voucher</div>
                <div class="greeting">
                    Dear Valued Partner,<br><br>
                    Kindly provide the mentioned services to our esteemed guests in the exchange of this voucher.
                </div>
            </div>
            @if($logoBase64)
            <div class="header-right">
                <img src="{{ $logoBase64 }}" alt="Logo" class="logo">
            </div>
            @endif
        </div>
    </div>

    @php
        // Get accommodation data from booking destinations
        $accommodation = null;
        $bookingDestination = $lead->bookingDestinations->first();
        
        if ($bookingDestination) {
            // Try to find matching accommodation
            $accommodation = $lead->bookingAccommodations->where('stay_at', $bookingDestination->destination)->first();
            if (!$accommodation) {
                $accommodation = $lead->bookingAccommodations->first();
            }
        }
        
        // Calculate dates and nights
        $checkinDate = $bookingDestination ? $bookingDestination->from_date : ($accommodation ? $accommodation->checkin_date : $lead->travel_date);
        $checkoutDate = $bookingDestination ? $bookingDestination->to_date : ($accommodation ? $accommodation->checkout_date : null);
        $nights = 0;
        if ($checkinDate && $checkoutDate) {
            $checkin = \Carbon\Carbon::parse($checkinDate);
            $checkout = \Carbon\Carbon::parse($checkoutDate);
            $nights = $checkin->diffInDays($checkout);
        } elseif ($bookingDestination && $bookingDestination->no_of_days) {
            $nights = $bookingDestination->no_of_days;
        }
        
        // Guest count calculations
        $adults = $lead->adults ?? 0;
        $children = $lead->children ?? 0;
        $children_2_5 = $lead->children_2_5 ?? 0;
        $children_6_11 = $lead->children_6_11 ?? 0;
        $infants = $lead->infants ?? 0;
        
        // CWB = Children With Bed (typically children 6-11)
        $cwb = $children_6_11 ?? 0;
        // CNB = Children No Bed (typically children 2-5)
        $cnb = $children_2_5 ?? 0;
        // TRPL = Triple rooms count
        $trpl = 0; // This would need to be calculated based on room allocation
        
        $totalGuests = $adults + $children + $infants;
        
        // Room types (this would typically come from accommodation data)
        $dbl = 0; // Double rooms - would need to be calculated
        $totalRooms = 1; // Default, should be calculated from actual data
    @endphp

    <!-- Accommodation Details Section -->
    <div class="section-divider">
        <div class="section-header">Accommodation Details</div>
        <table class="accommodation-table">
            <tr>
                <td><strong>Stay at</strong></td>
                <td><strong>{{ $accommodation ? ($accommodation->stay_at ?? $bookingDestination->destination ?? 'Hotel') : ($bookingDestination->destination ?? 'Hotel') }}</strong></td>
                <td><strong>Check-in</strong></td>
                <td><strong>{{ $checkinDate ? \Carbon\Carbon::parse($checkinDate)->format('d-M') : 'N/A' }}</strong></td>
                <td><strong>Check-out</strong></td>
                <td><strong>{{ $checkoutDate ? \Carbon\Carbon::parse($checkoutDate)->format('d-M') : 'N/A' }}</strong></td>
                <td><strong>Number of Nights</strong></td>
                <td><strong>{{ $nights }}</strong></td>
            </tr>
        </table>
    </div>

    <!-- Guest Details Section -->
    <div class="section-divider">
        <div class="section-header">Guest Details & Room Allocation</div>
        <div class="guest-details-wrapper">
            <!-- First Table: Name, TST No., Dated, TRPL -->
            <table class="guest-details-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>TST No.</th>
                        <th>Dated</th>
                        <th>TRPL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="name-cell"><strong>{{ $lead->salutation ?? '' }} {{ $lead->first_name }} {{ $lead->last_name ?? '' }} x {{ $totalGuests }}</strong></td>
                        <td class="value-cell"><strong>{{ $lead->tsq }}</strong></td>
                        <td class="value-cell"><strong>{{ $lead->travel_date ? \Carbon\Carbon::parse($lead->travel_date)->format('d-M-y') : 'N/A' }}</strong></td>
                        <td class="trpl-note">Double bedded room will be provided with a roll away bed.</td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Second Table: Guest Count -->
            <table class="guest-details-table">
                <thead>
                    <tr>
                        <th>Adults</th>
                        <th>CWB</th>
                        <th>CNB</th>
                        <th>INF</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="value-cell"><strong>{{ $adults }}</strong></td>
                        <td class="value-cell"><strong>{{ $cwb }}</strong></td>
                        <td class="value-cell"><strong>{{ $cnb }}</strong></td>
                        <td class="value-cell"><strong>{{ $infants }}</strong></td>
                        <td class="value-cell"><strong>{{ $totalGuests }}</strong></td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Third Table: Type of Room -->
            <table class="guest-details-table">
                <thead>
                    <tr>
                        <th>SGL</th>
                        <th>DBL</th>
                        <th>TWIN</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="value-cell"><strong>0</strong></td>
                        <td class="value-cell"><strong>{{ $dbl }}</strong></td>
                        <td class="value-cell"><strong>0</strong></td>
                        <td class="value-cell"><strong>{{ $totalRooms }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Transportation Details Section -->
    @if($lead->bookingArrivalDepartures && $lead->bookingArrivalDepartures->count() > 0)
    <div class="section-divider">
        <div class="section-header">Transportation Details</div>
        <table class="transportation-table">
            <thead>
                <tr>
                    <th>Mode</th>
                    <th>Vehicle</th>
                    <th>From City</th>
                    <th>To City</th>
                    <th>Dep. date & time</th>
                    <th>Arrival date & time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lead->bookingArrivalDepartures as $arrival)
                <tr>
                    <td><strong>{{ $arrival->mode ?? 'By Surface' }}</strong></td>
                    <td><strong>{{ $arrival->info ?? 'N/A' }}</strong></td>
                    <td><strong>{{ $arrival->from_city ?? 'N/A' }}</strong></td>
                    <td><strong>{{ $arrival->to_city ?? 'N/A' }}</strong></td>
                    <td><strong>{{ $arrival->departure_date ? \Carbon\Carbon::parse($arrival->departure_date)->format('d-M') : 'N/A' }}{{ $arrival->departure_time ? ' ' . (strpos($arrival->departure_time, ':') !== false ? str_replace(':', '', substr($arrival->departure_time, 0, 5)) : $arrival->departure_time) . ' Hrs' : '' }}</strong></td>
                    <td><strong>{{ $arrival->arrival_date ? \Carbon\Carbon::parse($arrival->arrival_date)->format('d-M') : 'N/A' }}{{ $arrival->arrival_time ? ' ' . (strpos($arrival->arrival_time, ':') !== false ? str_replace(':', '', substr($arrival->arrival_time, 0, 5)) : $arrival->arrival_time) . ' Hrs' : '' }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Hotel Contact Information Section -->
    @if($accommodation && $accommodation->stay_at)
    <div class="section-divider">
        <div class="section-header">Hotel Contact Information</div>
        <table class="hotel-contact-table">
            <tr>
                <td><strong>Name</strong></td>
                <td><strong>{{ $accommodation->stay_at }}</strong></td>
                <td><strong>Call</strong></td>
                <td><strong>{{ $accommodation->contact_number ?? 'N/A' }}</strong></td>
            </tr>
            <tr>
                <td><strong>Address</strong></td>
                <td colspan="3"><strong>{{ $accommodation->location ?? $bookingDestination->location ?? 'N/A' }}</strong></td>
            </tr>
        </table>
    </div>
    @endif

    <!-- Services Section -->
    <div class="services-section">
        <div class="section-title">Services to be provided as per the guest count:</div>
        <div style="font-size: 11px; line-height: 1.8;">
            @if($checkinDate && $checkoutDate)
                @php
                    $current = \Carbon\Carbon::parse($checkinDate);
                    $end = \Carbon\Carbon::parse($checkoutDate);
                    $services = [];
                    while ($current->lt($end)) {
                        $dayName = $current->format('l');
                        $date = $current->format('d M, Y');
                        $dayServices = [];
                        if ($current->eq(\Carbon\Carbon::parse($checkinDate))) {
                            $dayServices[] = 'Check-in';
                            $dayServices[] = ($accommodation ? ($accommodation->room_type ?? '01 Deluxe Room') : '01 Deluxe Room');
                            $dayServices[] = 'Dinner';
                        }
                        if ($current->gt(\Carbon\Carbon::parse($checkinDate))) {
                            $dayServices[] = 'Breakfast';
                        }
                        if ($current->eq($end->copy()->subDay())) {
                            $dayServices[] = 'Check-out';
                        }
                        if (!empty($dayServices)) {
                            $services[] = $dayName . ', ' . $date . ' ' . implode(' + ', $dayServices);
                        }
                        $current->addDay();
                    }
                @endphp
                @foreach($services as $service)
                    <div style="margin-bottom: 5px;">{{ $service }}</div>
                @endforeach
            @else
                <div>Services details to be confirmed</div>
            @endif
        </div>
    </div>

    <!-- Comments Section -->
    @if($accommodation && $accommodation->booking_status)
    <div class="info-section">
        <div class="info-section-title">Comments</div>
        <div class="info-section-content">
            Booking is confirmed under the name of Guest <strong>{{ $lead->salutation ?? '' }} {{ $lead->first_name }} {{ $lead->last_name ?? '' }}</strong><br>
            @if($accommodation->room_type)
                <br><strong>{{ $accommodation->room_type ?? 'Deluxe Room' }}</strong> in <strong>{{ $accommodation->stay_at ?? 'Hotel' }}</strong> is confirmed under confirmation number <strong>{{ $accommodation->booking_status }}</strong>.
            @endif
            <br><br>All above services are pre-paid. Extras to be collect directly, if any
        </div>
    </div>
    @endif

    <!-- Remarks Section -->
    <div class="info-section">
        <div class="info-section-title">Remarks</div>
        <div class="info-section-content">
            For hotel factsheet, exact location, facilities offered and star categorisation of the hotel, we request you to log on to the respective hotels website. Early check-in and late check-out is subject to availability. Standard check-in time observed by the hotels is 1400 - 1600 hrs and 0900 - 1100 hrs as the check-out time. Usually hotels have twin bedded rooms. Double bedded room is subject to availability. Triple room may provided with roll away bed / extra bed / sofa cum bed / depending upon the availability.
        </div>
    </div>

    <!-- Caution Section -->
    <div class="info-section">
        <div class="info-section-title">Caution:</div>
        <div class="info-section-content">
            Heart patients, pregnant women, person suffering from physical problems need to be cautious while visiting the following sightseeing: water sports activities, long tour or any stressful activity.
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-header">
            <div class="footer-title">For further details / queries, approach</div>
            <div class="signature-box">
                <div class="signature-placeholder"></div>
                <div class="signature-label">(Authorised Signatory)</div>
            </div>
        </div>
        <div class="footer-company-name">TRAVEL SHRAVEL TOUR & TRAVELS</div>
        <div class="footer-address-section">
            <div class="address-left">
                <div>Place of Business</div>
                <div>Liaison Support</div>
            </div>
            <div class="address-right">
                <div>Akalpur Sarora Road Near Tagore College, Jammu, Jammu & Kashmir, India - 180002</div>
                <div>Near Bhartiya Vidya Mandir, Main Bazar, Udhampur, Jammu & Kashmir, India - 182101</div>
            </div>
        </div>
        <div class="footer-contact-section">
            <div class="contact-left">Email: travel@travelshravel.com</div>
            <div class="contact-right">Mobile: +91 90 86 421601</div>
        </div>
        <div class="footer-website">www.travelshravel.com</div>
    </div>
</body>
</html>

