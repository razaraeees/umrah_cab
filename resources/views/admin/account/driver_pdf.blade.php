<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Driver Details - {{ $driver->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .driver-info {
            margin-bottom: 20px;
        }
        .stats {
            margin-bottom: 20px;
        }
        .stats-table {
            width: 100%;
            border-collapse: collapse;
        }
        .stats-table td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            vertical-align: top;
            width: 33.33%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Driver Details Report</h2>
        <p>Generated on: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <div class="driver-info">
        <h3>Driver Information</h3>
        <p><strong>Name:</strong> {{ $driver->name ?? 'N/A' }}</p>
        <p><strong>Contact:</strong> {{ $driver->phone ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $driver->email ?? 'N/A' }}</p>
        <p><strong>Car:</strong> {{ $driver->carDetails->name ?? 'N/A' }}</p>
        <p><strong>Registration:</strong> {{ $driver->carDetails->registration_number ?? 'N/A' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($driver->status ?? 'inactive') }}</p>
    </div>

    <div class="stats">
        <table class="stats-table">
            <tr>
                <td>
                    <h4>Total Rides</h4>
                    <h3>{{ $totalRides }}</h3>
                </td>
                <td>
                    <h4>Driver Earnings</h4>
                    <h3>{{ number_format($totalDriverEarnings, 2) }} SAR</h3>
                    <p>(80% of total)</p>
                </td>
                <td>
                    <h4>Admin Earnings</h4>
                    <h3>{{ number_format($totalAdminEarnings, 2) }} SAR</h3>
                    <p>(20% of total)</p>
                </td>
            </tr>
        </table>
    </div>

    <h3>Ride History</h3>
    <table>
        <thead>
            <tr>
                <th>Guest Name</th>
                <th>Contact</th>
                <th>Date</th>
                <th>Time</th>
                <th>Route</th>
                <th class="text-right">Route Fare</th>
                <th class="text-right">Discount</th>
                <th class="text-right">Additional Services</th>
                <th class="text-right">Total Amount</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($allBookings as $booking)
            <tr>
                    <td>{{ $booking->guest_name ?? 'N/A' }}</td>
                    <td>{{ $booking->guest_phone ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->pickup_date)->format('d M Y') }}</td>
                    <td>{{ $booking->pickup_time ?? 'N/A' }}</td>
                    <td>
                        {{ $booking->pickup_location_name }} → {{ $booking->dropoff_location_name }}
                    </td>
                    <td class="text-right">{{ number_format($booking->price ?? 0, 2) }} SAR</td>
                    <td class="text-right">{{ number_format($booking->discount_amount ?? 0, 2) }} SAR</td>
                    <td class="text-right">
                        @if ($booking->additionalServices->count() > 0)
                            @foreach ($booking->additionalServices as $service)
                                <div>{{ $service->name }} ({{ number_format($service->pivot->amount ?? 0, 2) }} SAR)</div>
                            @endforeach
                        @else
                            <span style="color: #666;">No services</span>
                        @endif
                    </td>
                    <td class="text-right">{{ number_format($booking->total_amount ?? 0, 2) }} SAR</td>
                    <td class="text-center">{{ ucfirst($booking->booking_status ?? 'N/A') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">No rides found</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Totals:</th>
                <th class="text-right">{{ number_format($allBookings->sum('price'), 2) }} SAR</th>
                <th class="text-right">{{ number_format($allBookings->sum('discount_amount'), 2) }} SAR</th>
                <th class="text-right">
                    @php
                        $totalServices = 0;
                        foreach($allBookings as $booking) {
                            $totalServices += $booking->additionalServices->sum('pivot.amount');
                        }
                    @endphp
                    {{ number_format($totalServices, 2) }} SAR
                </th>
                <th class="text-right">{{ number_format($allBookings->sum('total_amount'), 2) }} SAR</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>This is a computer-generated report. No signature required.</p>
        <p>Total Records: {{ $allBookings->count() }} | Total Amount: {{ number_format($allBookings->sum('total_amount'), 2) }} SAR</p>
    </div>
</body>
</html>
