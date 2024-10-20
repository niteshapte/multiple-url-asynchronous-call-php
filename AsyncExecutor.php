<?php
require_once 'GenericExecutorService.php';

class AsyncExecutor {
    private GenericExecutorService $executorService;
    private array $urls = [];

    public function __construct(int $maxConcurrency = 5) {
        $this->executorService = new GenericExecutorService($maxConcurrency);
    }

    public function addUrl(string $url) {
        // Add a URL to the list of URLs to fetch
        $this->urls[] = $url;
    }

    public function fetchAllUrls() {
        // Loop through each URL and submit the task to the executor service
        foreach ($this->urls as $url) {
            $this->executorService->submit(function() use ($url) {
                $this->fetchUrl($url); // Fetch URL using internal method
            });
        }

        // After all tasks are submitted, shut down to ensure all processes complete
        $this->executorService->shutdown();
    }

    private function fetchUrl(string $url) {
        echo "Fetching $url...\n";
        // Simulate a cURL operation to fetch the URL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set a timeout

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo "Error fetching URL: $url - " . curl_error($ch) . "\n";
        } else {
            echo "Successfully fetched URL: $url\n";
        }

        curl_close($ch); // Close the cURL session
    }
}
?>

