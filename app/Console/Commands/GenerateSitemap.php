<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'app:generate-sitemap';

    protected $description = 'Génère le sitemap.xml public à partir des pages réelles du site';

    public function handle(): void
    {
        Sitemap::create()
            ->add(Url::create(route('home'))->setPriority(1.0))
            ->add(Url::create(route('mentions-legales'))->setPriority(0.3))
            ->writeToFile(public_path('sitemap.xml'));

        file_put_contents(public_path('robots.txt'), implode("\n", [
            'User-agent: *',
            'Disallow: /admin',
            '',
            'Sitemap: '.url('/sitemap.xml'),
            '',
        ]));

        $this->info('Sitemap et robots.txt générés dans '.public_path());
    }
}
