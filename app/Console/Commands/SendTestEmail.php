<?php

namespace App\Console\Commands;

use App\Mail\TestEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email : The email address to send the test to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to verify SMTP configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $this->info("Attempting to send test email to: {$email}");
        $this->info("Current Mailer: " . config('mail.default'));
        $this->info("Current Host: " . config('mail.mailers.smtp.host'));

        try {
            Mail::to($email)->send(new TestEmail());
            $this->info('✅ Test email sent successfully!');
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Failed to send email.');
            $this->error('Error: ' . $e->getMessage());
            
            if (config('mail.default') === 'log') {
                $this->warn('💡 You are currently using the "log" driver. Check storage/logs/laravel.log to see the email content.');
            } else {
                $this->warn('💡 Check your .env file for correct SMTP credentials.');
            }
            
            return 1;
        }
    }
}
