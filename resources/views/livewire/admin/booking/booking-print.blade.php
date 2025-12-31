<div>
    <!-- Print Button -->
    <div class="no-print text-center">
        <button onclick="window.print()" class="print-button">
            🖨️ Print Bookings
        </button>
    </div>

    <!-- Table -->
    <table class="print-table">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Guest Name</th>
                <th>Contact</th>
                <th>Vehicle</th>
                <th>Pickup Location</th>
                <th>Dropoff Location</th>
                <th class="text-center">Pickup Date</th>
                <th class="text-center">Pickup Time</th>
                <th class="text-center">Price</th>
                <th class="text-center">Discount</th>
                <th class="text-center">Additional Services</th>
                <th class="text-right">Total Amount (SAR)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $index => $booking)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $booking->guest_name ?? 'N/A' }}</td>
                    <td>{{ $booking->guest_phone ?? 'N/A' }}</td>
                    <td>{{ $booking->vehicle_name ?? 'N/A' }}</td>
                    <td>{{ $booking->pickup_location_name ?? 'N/A' }}</td>
                    <td>{{ $booking->dropoff_location_name ?? 'N/A' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($booking->pickup_date)->format('d M Y') }}</td>
                    <td class="text-center">{{ $booking->pickup_time ?? 'N/A' }}</td>
                    <td class="text-center">{{ $booking->price ?? 'N/A' }}</td>
                    <td class="text-center">{{ $booking->discount_amount ?? 'N/A' }}</td>
                    <td class="text-center">{{ $booking->additionalServices->sum('charge_value') ?? 'N/A' }}</td>
                    <td class="text-right price">{{ number_format($booking->total_amount, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="no-data">No bookings found</td>
                </tr>
            @endforelse
        </tbody>
        @if($bookings->count() > 0)
        <tfoot>
            <tr>
                <th colspan="11" class="text-right">Total Amount:</th>
                <th class="text-right price">
                    {{ number_format($bookings->sum('total_amount'), 2) }} SAR
                </th>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- Footer -->
    <div class="print-footer">
        <div>
            <strong>Total Bookings:</strong> {{ $bookings->count() }}
        </div>
        <div>
            <strong>Total Revenue:</strong> {{ number_format($bookings->sum('total_amount'), 2) }} SAR
        </div>
    </div>

    <div class="footer">
        <span>Generated on: {{ now()->format('d M Y, h:i A') }}</span>
        <span>© 2026 Umrah Cab System</span>
    </div>

</div>
