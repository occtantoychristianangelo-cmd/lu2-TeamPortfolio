<?php

namespace Pusher\Git;

use Exception;

class BitbucketAuthExchangeFailed extends Exception
{
    private $httpStatus;
    private $responseBody;
    private $attempts;

    public function __construct($message, $httpStatus = null, $responseBody = '', $attempts = 1)
    {
        parent::__construct($message);
        $this->httpStatus = $httpStatus;
        $this->responseBody = $responseBody;
        $this->attempts = $attempts;
    }

    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    public function getResponseBody()
    {
        return $this->responseBody;
    }

    public function getAttempts()
    {
        return $this->attempts;
    }

    public function getDetail()
    {
        $parts = array();
        if ($this->httpStatus !== null) {
            $parts[] = "HTTP {$this->httpStatus}";
        }
        $parts[] = "after {$this->attempts} attempt" . ($this->attempts === 1 ? '' : 's');
        $detail = implode(', ', $parts);

        $bodySnippet = trim((string) $this->responseBody);
        if ($bodySnippet !== '') {
            if (strlen($bodySnippet) > 200) {
                $bodySnippet = substr($bodySnippet, 0, 200) . '…';
            }
            $detail .= "; body: {$bodySnippet}";
        }

        return $detail;
    }
}
