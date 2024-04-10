<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessWord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

class WordController extends Controller
{
    /** 
     * Start our jobs!
     */
    public function start(Request $request)
    {
        $word1 = $request->input('word1');
        $word2 = $request->input('word2');

        ProcessWord::dispatch($word1);
        ProcessWord::dispatch($word2);

        return 'Dispatched';
    }

    public function startMany(Request $request)
    {
        $num = abs($request->input('num', 1000));

        while ($num-- > 0)
            ProcessWord::dispatch("str $num");
        
        return 'Dispatched';
    }

    public function startBatch(Request $request)
    {
        $num = abs($request->input('num', 1000));
        $jobs = [];
        while ($num-- > 0)
            $jobs[] = new ProcessWord("str $num");

        $start = microtime(true);

        Bus::batch($jobs)->then(function () use ($start) {
            $duration = microtime(true) - $start;
            Log::info("DONE in $duration seconds");
        })->dispatch();

        return 'Dispatched';
    }
}
