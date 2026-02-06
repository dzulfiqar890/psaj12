<?php

namespace App\Console\Commands;

use App\Mail\WeeklyNewsletterMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Command untuk mengirim newsletter mingguan ke semua customer.
 * 
 * Dijalankan setiap hari Senin jam 09:00 via scheduler.
 */
class SendWeeklyNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send-weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email newsletter mingguan ke semua customer';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Memulai pengiriman newsletter mingguan...');

        $customers = User::customers()->get();
        $sentCount = 0;
        $failedCount = 0;

        foreach ($customers as $customer) {
            try {
                Mail::to($customer->email)->send(new WeeklyNewsletterMail($customer));
                $sentCount++;

                Log::info("Newsletter sent to: {$customer->email}");
            } catch (\Exception $e) {
                $failedCount++;
                Log::error("Failed to send newsletter to {$customer->email}: " . $e->getMessage());
            }
        }

        $this->info("Newsletter terkirim: {$sentCount} customer");
        if ($failedCount > 0) {
            $this->warn("Gagal kirim: {$failedCount} customer");
        }

        Log::info("Weekly newsletter completed", [
            'sent' => $sentCount,
            'failed' => $failedCount,
        ]);

        return Command::SUCCESS;
    }
}
