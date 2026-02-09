<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\RekapTimbangan;
use App\Models\Penjualan;
use App\Models\RekapLebur;
use App\Models\LaporanKas;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class SimulationSeeder extends Seeder
{
    public function run()
    {
        // 1. Simulate Login as 'Super Admin' (Abi)
        $user = User::where('email', 'abi@lagoibay.com')->first();
        if (!$user) {
            $this->command->error("User 'abi@lagoibay.com' not found. Please run DatabaseSeeder first.");
            return;
        }
        Auth::login($user);
        $this->command->info("Logged in as: " . $user->name);

        // 2. Simulate Input Rekap Timbangan (Truck Entry)
        $timbangan = RekapTimbangan::create([
            'tanggal' => now(),
            'nomor_kendaraan' => 'BP 9999 TEST',
            'jenis_material' => 'Bauksit',
            'berat_masuk' => 10000,
            'berat_keluar' => 2000,
            'berat_bersih' => 8000, // 10000 - 2000
            'keterangan' => 'Simulated Input via Seeder',
            'created_by' => $user->id,
        ]);
        $this->command->info("Created Timbangan: BP 9999 TEST (8000 kg)");

        // 3. Simulate Sales (Penjualan)
        $penjualan = Penjualan::create([
            'nomor_invoice' => 'INV-TEST-' . uniqid(),
            'tanggal' => now(),
            'customer' => 'PT Test Sejahtera',
            'jenis_material' => 'Bauksit Premium',
            'jumlah' => 1000,
            'satuan' => 'kg',
            'harga_satuan' => 50000, // Expensive!
            'total_harga' => 50000000, // 50jt
            'status_bayar' => 'paid',
            'keterangan' => 'Direct Sales Simulation',
            'created_by' => $user->id,
        ]);
        $this->command->info("Created Sales: INV-TEST-001 (Rp 50.000.000)");

        // 4. Simulate Production with ANOMALY (Shrinkage > 10%)
        // Berat Awal: 1000, Hasil: 800. Susut: 200. Persentase: 20% (Anomaly!)
        $lebur = RekapLebur::create([
            'tanggal' => now(),
            'jenis_material' => 'Bauksit',
            'berat_awal' => 1000,
            'berat_hasil' => 800,
            'susut' => 200,
            'persentase_susut' => 20.00,
            'keterangan' => 'Test Anomaly Detection',
            'created_by' => $user->id,
        ]);
        $this->command->info("Created Production Anomaly: 20% Shrinkage Detected.");

        // 5. Simulate Cash Flow (Laporan Kas)
        $kas = LaporanKas::create([
            'tanggal' => now(),
            'jenis' => 'in',
            'kategori' => 'Penjualan',
            'keterangan' => 'Payment from PT Test Sejahtera',
            'jumlah' => 50000000,
            'saldo' => 50000000, // Initial balance + this
            'created_by' => $user->id,
        ]);
        $this->command->info("Created Cash Entry: Masuk Rp 50.000.000");

        // 6. Check Audit Logs
        $logCount = ActivityLog::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subMinute())
            ->count();

        if ($logCount > 0) {
            $this->command->info("SUCCESS: Audit Trails generated ($logCount logs found).");
        } else {
            $this->command->error("FAILURE: No Audit Logs generated! Check LogsActivity trait.");
        }
    }
}
