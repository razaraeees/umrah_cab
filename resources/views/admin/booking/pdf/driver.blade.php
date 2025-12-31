<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Driver Invoice</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            line-height: 1.4;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
            border-bottom: 2px solid #f39c12;
            padding-bottom: 20px;
        }
        .header h1 { 
            color: #2c3e50; 
            margin-bottom: 5px; 
            font-size: 24px;
        }
        .header p { 
            color: #7f8c8d; 
            margin: 5px 0;
        }
        .section { 
            margin-bottom: 25px; 
        }
        .section h3 { 
            color: #34495e; 
            border-bottom: 2px solid #f39c12; 
            padding-bottom: 5px;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .info-row { 
            margin-bottom: 8px; 
            display: flex;
        }
        .info-label { 
            font-weight: bold; 
            color: #2c3e50; 
            width: 150px; 
            flex-shrink: 0;
        }
        .info-value {
            color: #555;
        }
        .table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 15px 0; 
        }
        .table th, .table td { 
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: left; 
        }
        .table th { 
            background-color: #f8f9fa; 
            font-weight: bold; 
        }
        .total-row { 
            font-weight: bold; 
            background-color: #f8f9fa; 
        }
        .footer { 
            margin-top: 30px; 
            text-align: center; 
            color: #7f8c8d; 
            font-size: 12px; 
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .invoice-number {
            background: #f39c12;
            color: white;
            padding: 5px 15px;
            border-radius: 4px;
            display: inline-block;
            margin: 10px 0;
        }
        .earnings {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }
        .earnings strong {
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DRIVER INVOICE</h1>
        <p><strong>Umrah Cab System</strong></p>
        <div class="invoice-number">Invoice #: UC-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</div>
        <p>Date: {{ now()->format('d M Y') }}</p>
    </div>

    <div class="section">
        <h3>Driver Information</h3>
        @if($booking->vehicle && $booking->vehicle->assignedDriver)
        <div class="info-row">
            <span class="info-label">Driver Name:</span>
            <span class="info-value">{{ $booking->vehicle->assignedDriver->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Driver Phone:</span>
            <span class="info-value">{{ $booking->vehicle->assignedDriver->phone }}</span>
        </div>
        @else
        <div class="info-row">
            <span class="info-label">Driver:</span>
            <span class="info-value">Not Assigned</span>
        </div>
        @endif
        <div class="info-row">
            <span class="info-label">Vehicle:</span>
            <span class="info-value">{{ $booking->vehicle_name }}</span>
        </div>
        <div class="earnings">
            <strong>Your Earnings (80%): {{ number_format($booking->total_amount * 0.8, 2) }} SAR</strong>
        </div>
    </div>
    
    <div class="section">
        <h3>Customer Information</h3>
        <div class="info-row">
            <span class="info-label">Name:</span>
            <span class="info-value">{{ $booking->guest_name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Phone:</span>
            <span class="info-value">{{ $booking->guest_phone }}</span>
        </div>
        @if($booking->guest_whatsapp)
        <div class="info-row">
            <span class="info-label">WhatsApp:</span>
            <span class="info-value">{{ $booking->guest_whatsapp }}</span>
        </div>
        @endif
    </div>

    <div class="section">
        <h3>Booking Details</h3>
        <div class="info-row">
            <span class="info-label">Booking ID:</span>
            <span class="info-value">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Pickup Date:</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($booking->pickup_date)->format('d M Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Pickup Time:</span>
            <span class="info-value">{{ $booking->pickup_time }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Route:</span>
            <span class="info-value">{{ $booking->pickup_location_name }} to {{ $booking->dropoff_location_name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Passengers:</span>
            <span class="info-value">Adults: {{ $booking->no_of_adults }}, Children: {{ $booking->no_of_children }}, Infants: {{ $booking->no_of_infants }}</span>
        </div>
        @if($booking->pickup_hotel_name)
        <div class="info-row">
            <span class="info-label">Pickup Hotel:</span>
            <span class="info-value">{{ $booking->pickup_hotel_name }}</span>
        </div>
        @endif
        @if($booking->dropoff_hotel_name)
        <div class="info-row">
            <span class="info-label">Dropoff Hotel:</span>
            <span class="info-value">{{ $booking->dropoff_hotel_name }}</span>
        </div>
        @endif
    </div>

    <div class="section">
        <h3>Price Breakdown</h3>
        <table class="table">
            <tr>
                <th>Description</th>
                <th style="text-align: right; width: 120px;">Amount (SAR)</th>
            </tr>
            <tr>
                <td>Base Price</td>
                <td style="text-align: right;">{{ number_format($booking->price, 2) }}</td>
            </tr>
            @if($booking->discount_amount > 0)
            <tr>
                <td>Discount</td>
                <td style="text-align: right; color: #e74c3c;">-{{ number_format($booking->discount_amount, 2) }}</td>
            </tr>
            @endif
            @if($booking->additionalServices && $booking->additionalServices->count() > 0)
                @foreach($booking->additionalServices as $service)
                <tr>
                    <td>{{ $service->service_name }}</td>
                    <td style="text-align: right;">{{ number_format($service->pivot->amount ?? 0, 2) }}</td>
                </tr>
                @endforeach
            @endif
            <tr class="total-row">
                <td><strong>Total Amount</strong></td>
                <td style="text-align: right;"><strong>{{ number_format($booking->total_amount, 2) }}</strong></td>
            </tr>
            <tr style="background: #d4edda;">
                <td><strong>Your Earnings (80%)</strong></td>
                <td style="text-align: right; color: #155724;"><strong>{{ number_format($booking->total_amount * 0.8, 2) }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p><strong>Thank you for your service with Umrah Cab System</strong></p>
        <p>Please ensure safe and timely pickup of the customer</p>
        <p>For any issues, contact dispatch: +966 50 123 4567</p>
    </div>
</body>
</html>
