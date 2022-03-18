<?php

namespace App\Console\Commands;


use App\Managers\FeedUpdater;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateFeeds extends Command {
    
    protected $signature = "UpdateFeeds";

    protected $description = "Updates Feeds";

    public function handle() {
        FeedUpdater::update();
    }
}