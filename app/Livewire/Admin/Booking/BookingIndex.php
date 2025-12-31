<?php

namespace App\Livewire\Admin\Booking;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bookings;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Log;

class BookingIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $dateFilter = 'today';
    public $startDate = '';
    public $endDate = '';
    protected $paginationTheme = 'bootstrap';

    public $type;
    public $copyText;


    public function prepareCopyText($bookingId, $type)
    {
        try {
            $booking = Bookings::with([
                'pickupLocation',
                'dropoffLocation',
                'vehicle.assignedDriver'
            ])->findOrFail($bookingId);

            $amount = number_format($booking->total_amount - ($booking->total_amount * 0.20), 2);
            $price = $booking->total_amount -= $amount;
            $vehicle = $booking->vehicle;
            $capacity = $vehicle?->seating_capacity ?? 'N/A';
            $bags = $vehicle?->bag_capacity ?? 'N/A';
            $driver = $vehicle?->assignedDriver;
            $driverName = $driver?->name ?? 'N/A';
            $driverPhone = $driver?->phone ?? 'N/A';
            $pickupHotel = $booking->pickup_hotel_name ? "🏨 {$booking->pickup_hotel_name}" : "";
            $dropoffHotel = $booking->dropoff_hotel_name ? "🏨 {$booking->dropoff_hotel_name}" : "";
            $pickupDate = \Carbon\Carbon::parse($booking->pickup_date)->format('d M Y');

            if ($type === 'driver') {
                $lines = [
                    "🚗 *New Ride Details*",
                    "",
                    "👤 Guest: {$booking->guest_name}",
                    "📞 Contact: {$booking->guest_phone}",
                    "💬 WhatsApp: {$booking->guest_whatsapp}",
                    "",
                    "📅 Date: {$pickupDate}",
                    "⏰ Time: {$booking->pickup_time}",
                    "",
                    "💰 Price: {$amount} SAR",
                    "👥 Capacity: {$capacity}",
                    "🧳 Bags: {$bags}",
                    "",
                    "📍 Route:",
                    "FROM: {$booking->pickup_location_name}",
                ];
                if ($pickupHotel) $lines[] = $pickupHotel;
                $lines[] = "TO: {$booking->dropoff_location_name}";
                if ($dropoffHotel) $lines[] = $dropoffHotel;

                $text = implode("\n", $lines);
            } else {
                $lines = [
                    "🚘 *Your Booking Confirmation*",
                    "",
                    "👤 Name: {$booking->guest_name}",
                    "📞 Contact: {$booking->guest_phone}",
                    "",
                    "💰 Balance Price: {$amount} SAR",
                    "💰 Advance Price: {$price} SAR",

                    "",
                    "📅 Pickup Date: {$pickupDate}",
                    "⏰ Pickup Time: {$booking->pickup_time}",
                    "",
                    "📍 Journey:",
                    "FROM: {$booking->pickup_location_name}",
                ];
                if ($pickupHotel) $lines[] = $pickupHotel;
                $lines[] = "TO: {$booking->dropoff_location_name}";
                if ($dropoffHotel) $lines[] = $dropoffHotel;
                $lines[] = "";
                $lines[] = "🚗 Driver Details:";
                $lines[] = "Name: {$driverName}";
                $lines[] = "Contact: {$driverPhone}";
                $lines[] = "";
                $lines[] = "🙏 Thank you for choosing us!";

                $text = implode("\n", $lines);
            }

            // Store in session temporarily
            cache()->put('clipboard_' . auth()->id(), $text, now()->addMinutes(5));

            // Dispatch event with simple flag
            $this->dispatch('do-copy-now');
        } catch (\Exception $e) {

            $this->dispatch('copy-error');
        }
    }

    public function generateInvoicePDF($id, $type)
    {
        $booking = Bookings::with([
            'pickupLocation',
            'dropoffLocation',
            'vehicle.assignedDriver',
            'additionalServices'
        ])->findOrFail($id);

        $view = $type === 'customer'
            ? 'admin.booking.pdf.customer'
            : 'admin.booking.pdf.driver';

        $pdf = Pdf::loadView($view, [
            'booking' => $booking
        ])->setPaper('A4');

        return $pdf->download(
            strtoupper($type) . '_INVOICE_' . $booking->id . '.pdf'
        );
    }

    // Add this new method to retrieve text
    public function getClipboardText()
    {
        return session('clipboard_text', '');
    }

    // Ye zaruri hai taake search update hone par page reset ho jaye
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Date filter update par bhi page reset karna zaruri hai
    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    // Date range update par bhi page reset karna zaruri hai
    public function updatingStartDate()
    {
        $this->resetPage();
    }

    public function updatingEndDate()
    {
        $this->resetPage();
    }

    public function applyDateRange()
    {
        $this->resetPage();
        // Clear existing date filter when applying custom range
        $this->dateFilter = '';
    }

    public function clearDateRange()
    {
        $this->startDate = '';
        $this->endDate = '';
        $this->dateFilter = 'today';
        $this->resetPage();
    }

    public function render()
    {
        $filters = [
            'search' => $this->search,
            'date_filter' => $this->dateFilter,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ];

        $bookings = Bookings::with(['pickupLocation', 'dropoffLocation', 'vehicle'])
            ->filter($filters)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.booking.booking-index', compact('bookings'));
    }

    public function delete($id)
    {
        $booking = Bookings::findOrFail($id);
        $booking->delete();
        $this->dispatch('show-toast', type: 'success', message: 'Booking deleted successfully.');
    }
}
