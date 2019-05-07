<?php

namespace PantheonSystems\CDNBehatHelpers;

final class AgeTracker
{

    public function trackHeaders($path, $headers)
    {
        $this->headers[$path][] = array_filter($headers, function ($v, $k) {
            // Filter out headers that won't help with debugging.
            $tracked_headers = [
              'Age',
              'Cache-Control',
              'X-Timer'
            ];
            return in_array($k, $tracked_headers);
        }, ARRAY_FILTER_USE_BOTH);
    }

    public function getTrackedHeaders($path)
    {
        return $this->headers[$path];
    }

    public function wasCacheClearedBetweenLastTwoRequests($path)
    {
         // Assign the headers to a new variable so that $this->headers is not modified by array_pop().
         $headers = $this->headers[$path];
         $most_recent = array_pop($headers);
         $second_most_recent = array_pop($headers);
         // If the Age header on the most recent request is smaller than the age header on the second most recent
         // Then the cache was cleared (@todo, or it expired (account for max age))
         $return = (integer) $most_recent['Age'][0] < (integer) $second_most_recent['Age'][0];
         return $return;
    }

    public function ageIncreasedBetweenLastTwoRequests($path)
    {
        // Assign the headers to a new variable so that $this->headers is not modified by array_pop().
        $headers = $this->headers[$path];
        $most_recent = array_pop($headers);
        $second_most_recent = array_pop($headers);
        $return = (integer) $most_recent['Age'][0] > (integer) $second_most_recent['Age'][0];
        return $return;
    }
}
