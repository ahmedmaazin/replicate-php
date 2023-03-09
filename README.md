# Replicate PHP client

This is a simple PHP client for the [Replicate](https://replicate.com/). It covers the main prediction functionalities
of the [Replicate HTTP API](https://replicate.com/docs/reference/http).

## Requirements

- PHP 8.1

## Installation

Install the package with composer:

```bash
composer require replicate/replicate-php
```

## Usage

### Initialize the replicate client with your API token

Get your API token from your [Replicate account](https://replicate.com/account).

```php
$replicate = new Replicate('token');
```

### Create a prediction

```php
try {
    $prediction = $replicate->createPrediction(
        version: 'v1',
        input: ['text' => 'foo'],
    );

    echo $prediction->id; // take a look at Prediction data class for available fields
} catch (ReplicateException|ReplicateWebhookInputException|ResponseException $e) {
    echo $e->getMessage();
}
```

### Get a prediction

```php
try {
    $prediction = $this->replicate->prediction(predictionId: 'prediction-id');

    echo $prediction->id;
} catch (ReplicateException|ResponseException $e) {
    // log error
}
```

### Get a list of predictions

```php
try {
    $predictions = $this->replicate->predictions();

    // if you would like to paginate.
    if ($predictions->next) {
        
        // extract the cursor from the next url
        $nextUrl = $predictions->next;
        $query = parse_url($nextUrl, PHP_URL_QUERY);
        parse_str($query, $params);
        $cursor = $params['cursor'];
        
        $predictions = $this->replicate->predictions(cursor: $cursor);
        // $predictions->results;
    }
    
    // take a look at the Predictions data class for available fields.
} catch (ReplicateException|ResponseException $e) {
    // log error
}
```

### Cancel a prediction

```php
try {
    $response = $this->replicate->cancelPrediction(predictionId: 'prediction-id');

    echo $response->status;
} catch (ReplicateException|ResponseException $e) {
    // log error
}
```

## Development

### Install dependencies

```bash
composer install
```

### Run tests

```bash
composer test
```

## License

MIT