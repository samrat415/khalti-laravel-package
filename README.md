
---

# Easy Khalti ePayment Integration Package for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/samrat415/khalti-laravel.svg?style=flat-square)](https://packagist.org/packages/samrat415/khalti-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/samrat415/khalti-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/samrat415/khalti-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/samrat415/khalti-laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/samrat415/khalti-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/samrat415/khalti-laravel.svg?style=flat-square)](https://packagist.org/packages/samrat415/khalti-laravel)

This Laravel package provides easy integration for Khalti ePayment services.

## Installation

To install the package, use Composer:

```bash
composer require samrat415/khalti-laravel
```

Once installed, run the package's installation command to publish the configuration file:

```bash
php artisan khalti-laravel:install
```

This will publish the configuration file `khalti-laravel.php` to the `config` folder. Modify the configuration file as needed, and then run:

```bash
php artisan config:cache
```

## Usage

You can initiate a payment request using the `ePaymentInitiateRequest` method provided by the package. Here's an example of how you can use it in your controller:

```php
use Illuminate\Http\Request;
use Khalti\KhaltiLaravel\Khalti;

public function initiatePaymentRequest(Request $request) {
    $requestArray = [
        'purchase_order_id' => 1, // Your Purchase ID
        'purchase_order_name' => "test", // Your Order Name
        'amount' => $request->input('amount',100)
    ];

    $request = new Request($requestArray);
    $response = Khalti::ePaymentInitiateRequest($request); // Must be of Illuminate\Http\Request 
    return $response;
}
```

## Frontend Implementation

To initiate a payment request from the frontend, you can create a form with a single field for the amount and a submit button. Here's an example:

```html
<form id="paymentForm" onsubmit="submitForm(event)">
    <label for="amount">Amount:</label><br>
    {{ csrf_field() }}
    <input type="text" id="amount" name="amount" required><br><br>
    <input type="submit" value="Submit">
</form>

<script>
    function submitForm(event) {
        event.preventDefault(); // Prevent the default form submission

        var form = document.getElementById("paymentForm");
        var formData = new FormData(form);

        // Convert formData to JSON
        var formDataJson = {};
        formData.forEach(function(value, key){
            formDataJson[key] = value;
        });

        // Make a POST request to the external service
        fetch("{{ route('khalti.ePayment-initiate') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(formDataJson)
        })
            .then(response => response.json())
            .then(data => {
                if (data.error_key === "validation_error") {
                    // Handle validation error
                    alert(data.detail);
                } else if (data.payment_url) {
                    // Redirect to the payment_url if available
                    window.location.href = data.payment_url;
                } else {
                    console.log("Unexpected response from server:", data);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
    }
</script>
```

Replace the JavaScript code with the provided code to handle form submission and response.

## Validation Example

To complete the payment and validate it, you can use the following method:

```php
public function completePayment(Request $request){
    $response =  Khalti::ePaymentValidationRequest($request);
    return $response;
}
```

Here's an example of the expected request payload:

```
<your_config_url>/?pidx=pUmazJyRT2F8a5Fz7xXSiK&transaction_id=XdcQ5qwWUfscAKbrGbKD9F&tidx=XdcQ5qwWUfscAKbrGbKD9F&amount=31500&total_amount=31500&mobile=98XXXXX005&status=Completed&purchase_order_id=1&purchase_order_name=test
```


Please note that `Khalti::ePaymentValidationRequest($request)` expects the `$request` object to have a `pidx` field and `$request` to be of type `Illuminate\Http\Request`.

--- 
## Security Vulnerabilities

If you discover a security vulnerability within this package, please send an email to the maintainer at support@khalti.com.

## Credits

- [Samrat Thapa](https://github.com/samrat415)


## License

This package is open-sourced software licensed under the [MIT license](LICENSE.md).

