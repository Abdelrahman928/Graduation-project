<?php

namespace App\Console\Commands;

use App\Models\Partners;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class AddPartnerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Vendor:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new vendor';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('enter vendors name');
        $description = $this->ask('enter the description');
        $pointsRequired = $this->ask('enter points required to redeem this vendors promo');

        $validator = Validator::make([
            'name' => $name,
            'description' => $description,
            'points_required' => $pointsRequired
        ],
        [
            'name' => ['required', 'unique:partners,name'],
            'description' => ['required'],
            'points_required' => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            $this->error('Input validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return;
        }

        $partner = new Partners();
        $partner->name = $name;
        $partner->description = $description;
        $partner->points_required = $pointsRequired;
        $partner->save();

        $this->info('Partner added successfully!');
    }
    }

