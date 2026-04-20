<?php

namespace Proglab\PrintSmarterApiClient\Service;

use Proglab\PrintSmarterApiClient\Dto\Order;
use Proglab\PrintSmarterApiClient\Error\PrintSmarterApiException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PrintSmarterApiClient
{
    public function __construct(
        private readonly string $apiKey,
        private readonly string $apiUrl,
        private readonly string $customerId,
        private HttpClientInterface $client,
    ) {
    }

    public function addOrder(Order $order)
    {
        $order = (array) $order;
        $order['shipping_address'] = (array) $order['shipping_address'];
        $order['return_address'] = (array) $order['return_address'];
        foreach ($order['products'] as $key => $product) {
            $order['products'][$key] = (array) $product;
        }
        return $this->request('POST', 'add_order', (array) $order);
    }

    public function getOrderStatusByClientId(string $orderIdClient)
    {
        return $this->request('POST', 'add_order', [
            'order_id_client' => $orderIdClient,
        ]);
    }

    public function getOrderStatusByPrintSmarterId(string $orderIdClient)
    {
        return $this->request('POST','get_order_status', [
                'order_id_printsmarter' => $orderIdClient,
            ]
        );

    }

    public function cancelOrderByPrintSmarterId(string $orderPrintSmarterId)
    {
        return $this->request('POST', 'cancel_order', [
                'order_id' => $orderPrintSmarterId,
            ]
        );
    }

    public function cancelOrderByClientId(string $orderId)
    {
        return $this->request('POST', 'cancel_order', [
                'order_id_client' => $orderId,
            ]
        );
    }

    private function request(string $method, string $endpoint, array $json = [], array $headers = []): mixed
    {
        $headers = array_merge([
            'Access-Token' => $this->apiKey,
            'Content-Type' => 'application/json',
        ], $headers);

        $json = array_merge([
            'customer_id' => $this->customerId,
        ], $json);

        $options = [
            'headers' => $headers,
            'json' => $json,
        ];

        $response = $this->client->request($method, $this->apiUrl . $endpoint, $options);
        return $this->handleResponse($response);
    }

    private function handleResponse(ResponseInterface $response): mixed
    {
        $rawContent = $response->getContent(false);
        $content = json_decode($rawContent);

        if (isset($content->error->message)) {
            $message = $content->error->message;
            $error = match(true) {
                str_contains($message, 'Access denied') => ['message' => 'Access denied', 'code' => 403],
                str_contains($message, 'Order not found') => ['message' => 'Order not found', 'code' => 404],
                default => ['message' => $message, 'code' => 500],
            };

            throw new PrintSmarterApiException($error['message'], $error['code'], $rawContent);
        }

        return $content;
    }

}
