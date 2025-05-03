<div>
    <div class="grid grid-cols-2 gap-4 bg-[#FFFFFF]">
        <!-- Left Column -->
        <div class="flex flex-col space-y-2">
            <x-modal-form-field
                :editable="false"
                value="{{ $report->plate_number }}"
                label="Kendaraan"
                name="plate_number"
            />
            
            <x-modal-form-field
            :editable="false"
            value="{{ $report->formatted_date }}"
            label="Waktu Laporan"
            name="created_at"
            />

            <x-modal-form-field
                :editable="false"
                type="textarea"
                rows="5"
                value="{{ $report->report_location }}"
                label="Lokasi Laporan"
                name="report_location"
            />

        </div>

        <!-- Right Column -->
        <div class="flex flex-col space-y-2">
            <x-modal-form-field
                :editable="false"
                value="{{ $report->problem_type }}"
                label="Tipe Kendala"
                name="problem_type"
            />

            <x-modal-form-field
                :editable="false"
                type="textarea"
                value="{{ $report->problem_description }}"
                label="Deskripsi"
                name="problem_description"
            />
        </div>
    </div>
</div>