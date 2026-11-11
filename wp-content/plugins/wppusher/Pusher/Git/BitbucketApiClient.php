<?php

namespace Pusher\Git;

class BitbucketApiClient
{
    public function setUpWebhookForRepository($webhook, BitbucketRepository $repository) {
        $token = get_option('bb_token');

        try {
            $accessToken = $repository->getAccessTokenFromRefreshToken($token);
        } catch (BitbucketAuthExchangeFailed $e) {
            throw new \Exception('Webhook was not updated on Bitbucket. Bitbucket authentication failed (' . $e->getDetail() . ').');
        }

        $authArgs = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $accessToken,
            ),
        );

        $url = "https://api.bitbucket.org/2.0/repositories/{$repository->__toString()}/hooks";

        $hookName = 'WP Pusher: ' . get_site_url();

        // Check if webhook already exists
        $response = wp_remote_get($url, $authArgs);

        if ($response instanceof \WP_Error) {
            throw new \Exception('Webhook was not updated on Bitbucket. Make sure a valid Bitbucket token is stored.');
        }

        $payload = json_decode(wp_remote_retrieve_body($response), true);

        // Check if hook is already set up
        if (isset($payload['values']) && is_array($payload['values'])) {
            foreach ($payload['values'] as $webhookPayload) {
                if ($webhookPayload['description'] === $hookName) {
                    // Hook already exists
                    return null;
                }
            }
        }

        // Proceed to set up a new webhook
        $body = json_encode(array(
            'description' => $hookName,
            'url' => html_entity_decode($webhook),
            'active' => true,
            'events' => array(
                'repo:push',
            ),
        ));

        $response = wp_remote_post($url, array(
            'body' => $body,
            'headers' => array(
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ),
        ));

        $responseCode = wp_remote_retrieve_response_code($response);

        if ($responseCode === 400) {
            throw new \Exception('Webhook was not updated on Bitbucket. Make sure a valid Bitbucket token is stored. (400 bad request)');
        }

        if ($response instanceof \WP_Error) {
            throw new \Exception('Webhook was not updated on Bitbucket. Make sure a valid Bitbucket token is stored.');
        }
    }
}
