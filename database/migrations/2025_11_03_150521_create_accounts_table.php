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
    Schema::create('accounts', function (Blueprint $table) {
        $table->id(); // العمود الأساسي (1, 2, 3, ...)

        // --- الأعمدة الجديدة ---

        // 1. لربط هذا الحساب بجدول المستخدمين (users)
        // constrained() -> يتأكد من أن user_id موجود في جدول users
        // onDelete('cascade') -> إذا تم حذف المستخدم، احذف جميع حساباته المرتبطة
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        // 2. لتخزين اسم المنصة (نص)
        $table->string('platform');

        // 3. لتخزين اسم المستخدم في المنصة (نص)
        $table->string('username');

        // --------------------

        $table->timestamps(); // أعمدة created_at و updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
