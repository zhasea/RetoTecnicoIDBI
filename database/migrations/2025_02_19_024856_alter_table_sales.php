<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['document_type_id']);

            $table->dropColumn(['customer_name', 'customer_id_number', 'document_type_id']);

            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade')->after('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');

            $table->string('customer_name');
            $table->foreignId('document_type_id')->constrained('document_types')->onDelete('restrict')->after('customer_name');
            $table->string('customer_id_number');
        });
    }
};
