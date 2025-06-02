
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\NullableType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');

            $table->foreignUuid('truck_id')
                    ->nullable()
                    ->constrained()
                    ->onDelete('set null');

            $table->string('plate_number')->nullable();
            $table->integer('delivery_order_price')->nullable();
            $table->string('client')->nullable();
            $table->string('load_type')->nullable();
            $table->string('departure_waybill_number')->nullable();
            $table->string('return_waybill_number')->nullable();
            $table->decimal('departure_latitude', 10, 8);
            $table->decimal('departure_longitude', 11, 8);
            $table->string('departure_location');
            $table->string('final_location')->nullable();
            $table->float('distance_traveled')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->enum('status', ['perjalanan', 'selesai'])->default('perjalanan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};