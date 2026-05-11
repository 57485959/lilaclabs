<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama', 100);
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->enum('role', ['pemilik', 'admin'])->default('admin');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->string('nama_produk', 100);
            $table->enum('jenis_asal', ['Supplier', 'Ternak']);
            $table->string('ukuran_kemasan', 50);
            $table->decimal('harga_jual', 15, 2)->default(0);
            $table->decimal('harga_modal', 15, 2)->default(0);
            $table->integer('stok')->default(0);
            $table->integer('minimum_stok')->default(0);
        });

        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id('id_pelanggan');
            $table->string('nama_pelanggan', 100);
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->timestamp('create_at')->useCurrent();
        });

        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('id_transaksi', 30)->primary();
            $table->foreignId('id_pelanggan')->nullable()->constrained('pelanggan', 'id_pelanggan')->nullOnDelete();
            $table->foreignId('id_user')->constrained('user', 'id_user');
            $table->date('tanggal_transaksi');
            $table->decimal('ongkir', 15, 2)->default(0);
            $table->string('metode_bayar', 50);
            $table->string('status_bayar', 50);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('grandtotal', 15, 2)->default(0);
            $table->timestamp('create_at')->useCurrent();
        });

        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->foreignId('id_produk')->constrained('produk', 'id_produk');
            $table->string('id_transaksi', 30);
            $table->integer('qty');
            $table->decimal('harga_saat_transaksi', 15, 2);
            $table->decimal('subtotal', 15, 2);

            $table->primary(['id_transaksi', 'id_produk']);
            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->cascadeOnDelete();
        });

        Schema::create('pembelian_stok', function (Blueprint $table) {
            $table->id('id_pembelian');
            $table->foreignId('id_produk')->constrained('produk', 'id_produk');
            $table->foreignId('id_user')->constrained('user', 'id_user');
            $table->date('tanggal');
            $table->string('supplier', 100)->nullable();
            $table->integer('jumlah');
            $table->decimal('harga_beli', 15, 2);
            $table->decimal('total', 15, 2);
            $table->text('keterangan')->nullable();
            $table->timestamp('create_at')->useCurrent();
        });

        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id('id_pengeluaran');
            $table->foreignId('id_user')->constrained('user', 'id_user');
            $table->date('tanggal');
            $table->enum('kategori', ['Botol', 'Label', 'Segel', 'Madu']);
            $table->text('keterangan');
            $table->decimal('jumlah_pengeluaran', 15, 2);
            $table->timestamp('create_at')->useCurrent();
        });

        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bisnis', 100);
            $table->string('nama_pemilik', 100)->nullable();
            $table->string('nomor_telepon', 20)->nullable();
            $table->text('alamat')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
        Schema::dropIfExists('pengeluaran');
        Schema::dropIfExists('pembelian_stok');
        Schema::dropIfExists('detail_transaksi');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('pelanggan');
        Schema::dropIfExists('produk');
        Schema::dropIfExists('user');
    }
};
