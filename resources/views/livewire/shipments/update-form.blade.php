@php
    $status = $shipment->status;
    $statusClass = $status === 'perjalanan' 
        ? 'bg-orange-100 text-orange-600' 
        : 'bg-green-100 text-green-600';
@endphp
<form wire:submit="updateShipment">
    <div class="grid grid-cols-2 gap-4 bg-[#FFFFFF]">
        <!-- Left Column -->
        <div class="flex flex-col space-y-2">
            <x-modal-form-field
                :editable="false"
                value="{{ $shipment->truck->plate_number }}"
                label="Nomor Plat"
                name="plate_number"
            />

            <x-modal-form-field
                wire:model="departure_waybill_number"
                label="Nomor Surat Jalan (Pergi)"
                name="departure_waybill_number"
                placeholder="Lengkapi kolom"
            />

            <x-modal-form-field
                wire:model="client"
                label="Klien"
                name="client"
                placeholder="Lengkapi kolom"
            />

            <x-modal-form-field
                :editable="false"
                value="{{ $shipment->formatted_date }}"
                label="Waktu Keberangkatan"
                name='created_at'
            />

            <x-modal-form-field
                :editable="false"
                type="textarea"
                value="{{ $shipment->departure_location }}"
                label="Lokasi Berangkat"
                name="departure_location"
            />

            <x-modal-form-field
                :editable="false"
                value="{{ isset($shipment->distance_traveled) ? $shipment->distance_traveled . ' Km' : '' }}"
                label="Jarak Tempuh"
                name="total_distance"
            />
        </div>

        <!-- Right Column -->
        <div class="flex flex-col space-y-2">
            <x-modal-form-field
                wire:model="load_type"
                label="Muatan"
                name="load_type"
                placeholder="Lengkapi kolom"
            />

            <x-modal-form-field
                wire:model="return_waybill_number"
                label="Nomor Surat Jalan (Pulang)"
                name="return_waybill_number"
                placeholder="Lengkapi kolom"
            />

            <x-modal-form-field
                wire:model="delivery_order_price"
                label="Biaya Pengiriman"
                name="delivery_order_price"
                placeholder="Lengkapi kolom"
            />

            <x-modal-form-field
                :editable="false"
                value="{{ $shipment->formatted_completed_at ?? '' }}"
                label="Waktu Sampai"
                name="arrival_time"
            />

            <x-modal-form-field
                :editable="false"
                type='textarea'
                value="{{ $shipment->final_location ?? '' }}"
                label="Lokasi Tujuan"
                name="final_location"
            />

            <span class="block text-xs font-regular text-black">Status</span>
            <span class="p-2 mb-4 text-xs font-medium rounded-lg {{ $statusClass }}">
                {{ $shipment->status }}
            </span>
        </div>
    </div>

    <div class="mt-2 flex justify-end">
        <input type="submit" class="text-xs bg-[var(--color-primary)] text-white font-regular py-2 px-4 rounded-lg" value="Simpan">
    </div>
</form>