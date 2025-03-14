<?php

namespace Nicepay\LaravelSnap\Common;

class HttpRequest
{
    public function __construct()
    {
        // No initialization required for cURL in constructor
    }

    /**
     * Wrapper of cURL to do API request to Nicepay API
     * @param array $headers The headers to send with the request
     * @param string $requestUrl The URL to send the request to
     * @param string $requestBody The body of the request
     * @param string $method The HTTP method to use for the request
     * @param bool $isRetryFlag Whether to retry if the request fails
     * @param int $retryLimit The number of times to retry if the request fails
     * @return mixed The response from the server
     */
    public function request($headers, $requestUrl, $requestBody, $method, $isRetryFlag, $retryLimit)
    {
        $attempt = 0;
        $timeoutErrorCodes = [CURLE_OPERATION_TIMEOUTED, CURLE_COULDNT_CONNECT];

        do {
            $ch = curl_init();

            // Set URL and request method
            curl_setopt($ch, CURLOPT_URL, $requestUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));

            // Add body for applicable methods
            if (in_array(strtoupper($method), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
            }

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            if (getenv('APP_ENV') === 'local') {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            }
            curl_setopt($ch, CURLOPT_TIMEOUT, 15); // Set timeout to 15 seconds

            // Execute request
            $response = curl_exec($ch);

            // Check if curl request failed (e.g., timeout)
            if (curl_errno($ch)) {
                $errorCode = curl_errno($ch);
                $errorMsg = curl_error($ch);
                curl_close($ch);

                // Check if it's a timeout or connection error and retry if applicable
                if ($isRetryFlag && in_array($errorCode, $timeoutErrorCodes) && $attempt < $retryLimit) {
                    $attempt++;
                    sleep(1); // Wait 1 second before retrying
                    continue;
                }

                // If not retryable, throw an exception
                throw new NicepayError($errorMsg);
            }

            // Get the HTTP response code
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // If the request was successful (HTTP 2xx), return the response as JSON
            if ($httpCode >= 200 && $httpCode < 300) {
                $jsonResponse = json_decode($response, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $jsonResponse;
                } else {
                    throw new NicepayError("Failed to parse response as JSON: " . json_last_error_msg() . "\nResponse: " . $response);
                }
            }

            // If HTTP 504 (Gateway Timeout), retry if applicable
            if ($isRetryFlag && $httpCode === 504 && $attempt < $retryLimit) {
                $attempt++;
                sleep(1); // Wait before retrying
                continue;
            }

            // Handle non-retryable HTTP errors (throwing exception with HTTP error and response body)
            $responseBody = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new NicepayError("Failed to parse response as JSON with message: " . json_last_error_msg() . "\nResponse: " . $response);
            }

            return $responseBody;
            // throw new NicepayError("HTTP Error $httpCode: " . print_r($responseBody, true));
        } while ($isRetryFlag && $attempt < $retryLimit);  // Ensure retry limit is correctly checked

        // If all retries are exhausted or no response is received
        throw new NicepayError("All retry attempts exhausted.");
    }



    /**
     * Sends a request to the given URL with the given body and headers and returns the response.
     * If the request fails due to a timeout or connection error, it will retry up to the given retry limit.
     * If the request receives a 504 Gateway Timeout, it will also retry up to the given retry limit.
     * If all retries are exhausted, it will throw a NicepayError exception.
     *
     * @param array $headers The headers to send with the request
     * @param string $requestUrl The URL to send the request to
     * @param string $requestBody The body of the request
     * @param string $method The HTTP method to use for the request
     * @param bool $isRetryFlag Whether to retry if the request fails
     * @param int $retryLimit The number of times to retry if the request fails
     * @return string The response from the server
     * @throws NicepayError If the request fails or all retries are exhausted
     */ 
    public function requestWithUrlEncodedBody($headers, $requestUrl, $requestBody, $method, $isRetryFlag, $retryLimit)
    {
        $attempt = 0;
        $timeoutErrorCodes = [CURLE_OPERATION_TIMEOUTED, CURLE_COULDNT_CONNECT];

        do {
            $ch = curl_init();

            // Set URL and request method
            curl_setopt($ch, CURLOPT_URL, $requestUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));

            // Add body for applicable methods
            if (in_array(strtoupper($method), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
            }

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            if (getenv('APP_ENV') === 'local') {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            }
            curl_setopt($ch, CURLOPT_TIMEOUT, 15); // Set timeout to 15 seconds
            // Execute request
            $response = curl_exec($ch);

            // Check if curl request failed (e.g., timeout)
            if (curl_errno($ch)) {
                $errorCode = curl_errno($ch);
                $errorMsg = curl_error($ch);
                curl_close($ch);

                // Check if it's a timeout or connection error and retry if applicable
                if ($isRetryFlag && in_array($errorCode, $timeoutErrorCodes) && $attempt < $retryLimit) {
                    $attempt++;
                    sleep(1); // Wait 1 second before retrying
                    continue;
                }

                // If not retryable, throw an exception
                throw new NicepayError($errorMsg);
            }

            // Get the HTTP response code
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // If the request was successful (HTTP 2xx), return the response as HTML
            if ($httpCode >= 200 && $httpCode < 300) {
                return $response; // Return HTML response directly
            }

            // If HTTP 504 (Gateway Timeout), retry if applicable
            if ($isRetryFlag && $httpCode === 504 && $attempt < $retryLimit) {
                $attempt++;
                sleep(1); // Wait before retrying
                continue;
            }

            // Throw an exception for non-retryable HTTP errors
            throw new NicepayError("HTTP Error $httpCode: " . $response);
        } while ($isRetryFlag && $attempt < $retryLimit);  // Ensure retry limit is correctly checked

        // If all retries are exhausted or no response is received
        throw new NicepayError("All retry attempts exhausted.");
    }
}