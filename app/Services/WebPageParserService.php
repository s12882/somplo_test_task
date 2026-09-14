<?php

namespace App\Services;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Facades\Cache;
use Laravel\Dusk\Browser;

class WebPageParserService
{
    /**
     * Visit the configured URL and collect image URLs from it, caching the
     * result for a app.parse_cache_ttl so every request will not run headless browser
     *
     * @return array<int, string>
     */
    public function readHtml(): array
    {
        return Cache::remember(
            $this->cacheKey(),
            (int) config('app.parse_cache_ttl'),
            $this->parseHtml(...),
        );
    }

    /**
     * @return array<int, string>
     */
    protected function parseHtml(): array
    {
        $driver = $this->createWebDriver();
        $browser = new Browser($driver);

        try {
            $browser->resize(1920, 1080);
            $browser->visit(config('app.parse_url'));
            $browser->pause(6000);
            $browser->waitUntilMissingText('Just a moment...', 10);

            return $this->collectImageUrls($browser);

        } finally {
            $browser->quit();
        }
    }

    protected function cacheKey(): string
    {
        return 'parser.image_urls.'.md5((string) config('app.parse_url'));
    }

    /**
     * @return array<int, string>
     */
    protected function collectImageUrls(Browser $browser): array
    {
        $imageClass = config('app.parse_image_selector');

        $script = 'return Array.from(document.getElementsByClassName('.json_encode($imageClass).')).map((el) => {'
            .'const image = el.tagName === "IMG" ? el : el.querySelector("img");'
            .'return image ? image.src : null;'
            .'}).filter(Boolean);';

        [$urls] = $browser->script($script);

        return array_slice($urls ?? [], 0, 8);
    }

    protected function createWebDriver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments([
            '--headless',
            '--disable-gpu',
            '--no-sandbox',
            '--disable-dev-shm-usage',
            '--disable-blink-features=AutomationControlled',
            '--user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36',
            '--disable-extensions',
        ]);

        $options->setExperimentalOption('excludeSwitches', ['enable-automation']);
        $options->setExperimentalOption('useAutomationExtension', false);

        $chromeDriverUrl = env('DUSK_DRIVER_URL', 'http://localhost:9515');

        return RemoteWebDriver::create(
            $chromeDriverUrl,
            DesiredCapabilities::chrome()->setCapability(ChromeOptions::CAPABILITY, $options)
        );
    }
}
