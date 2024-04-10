<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Simple example job that will add some random text to the end of a given word
 */
class ProcessWord implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $word){ }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Ensure that the job is still relevant
        if ($this->batch()->cancelled())
            return;

        $string = $this->word . Str::random();
        Log::info("Job result: $string");
    }
}
