<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddAwaitingPaymentStatusToOrdersTable extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('awaiting_payment', 'pending', 'confirmed', 'processing', 'shipped', 'delivered', 'completed', 'canceled') NOT NULL DEFAULT 'awaiting_payment'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'confirmed', 'processing', 'shipped', 'delivered', 'completed', 'canceled') NOT NULL DEFAULT 'pending'");
    }
}
