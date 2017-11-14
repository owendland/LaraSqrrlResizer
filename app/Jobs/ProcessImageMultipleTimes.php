<?php

namespace App\Jobs;

use App\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Faker\Generator;

class ProcessImageMultipleTimes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $source_url;

    /**
     * @var int
     */
    protected $num_times;

    /**
     * @var string
     */
    protected $name;

    /**
     * Create a new job instance.
     *
     * @param string      $source_url
     * @param int         $num_times
     * @param string|null $name
     */
    public function __construct(string $source_url, int $num_times, string $name = null)
    {
        $this->source_url = $source_url;
        $this->num_times  = $num_times;
        $this->name       = $name;
    }

    /**
     * Execute the job.
     *
     * @param \Faker\Generator $faker
     *
     * @return void
     */
    public function handle(Generator $faker)
    {
        for ($i = 0; $i < $this->num_times; $i++) {
            if (is_null($this->name)) {
                $this->name = $faker->name();
            }

            $image = Image::create(
                [
                    'name'       => $this->name,
                    'source_url' => $this->source_url,
                ]
            );

            ProcessImage::dispatch($image);
        }
    }
}
