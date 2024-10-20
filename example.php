<?php
include 'AsyncExecutor.php';

// Example usage:

// Create an instance of AsyncUrlFetcher with max concurrency of 3
$asyncExecutor = new AsyncExecutor(3);

// Add multiple URLs to be fetched
$asyncExecutor->addUrl('https://jsonplaceholder.typicode.com/posts');
$asyncExecutor->addUrl('https://jsonplaceholder.typicode.com/comments');
$asyncExecutor->addUrl('https://jsonplaceholder.typicode.com/albums');
$asyncExecutor->addUrl('https://jsonplaceholder.typicode.com/photos');
$asyncExecutor->addUrl('https://jsonplaceholder.typicode.com/todos');

// Fetch all URLs asynchronously
$asyncExecutor->fetchAllUrls();
?>
