<?php

class InputHandler
{
    public static function isDomain($input)
    {
        // Regular expression pattern for domain name validation
        $pattern = '/^(?:(?:[a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)+[a-zA-Z]{2,}$/';

        // Check if the input matches the domain name pattern
        if (preg_match($pattern, $input)) {
            return "domain";
        } elseif (filter_var($input, FILTER_VALIDATE_IP)) {
            return "ip";
        }
        return "unknown";
    }
}

class Scanners
{
    /**
     * Perform an A record DNS query for the given domain.
     *
     * @param string $domain The domain to query for A records.
     * @param string $server The DNS server to use for the query.
     * @return string The result of the A record query.
     */
    public static function aQuery($domain, $server)
    {
        return shell_exec("dig @$server A $domain +noall +answer");
    }

    /**
     * Perform an NS record DNS query for the given domain.
     *
     * @param string $domain The domain to query for NS records.
     * @param string $server The DNS server to use for the query.
     * @return string The result of the NS record query.
     */
    public static function nsQuery($domain, $server)
    {
        return shell_exec("dig @$server NS $domain +noall +answer");
    }

    /**
     * Perform an MX record DNS query for the given domain.
     *
     * @param string $domain The domain to query for MX records.
     * @param string $server The DNS server to use for the query.
     * @return string The result of the MX record query.
     */
    public static function mxQuery($domain, $server)
    {
        return shell_exec("dig @$server MX $domain +noall +answer");
    }

    /**
     * Perform an SOA record DNS query for the given domain.
     *
     * @param string $domain The domain to query for SOA records.
     * @param string $server The DNS server to use for the query.
     * @return string The result of the SOA record query.
     */
    public static function soaQuery($domain, $server)
    {
        return shell_exec("dig @$server SOA $domain +noall +answer");
    }

    /**
     * Perform a TXT record DNS query for the given domain.
     *
     * @param string $domain The domain to query for TXT records.
     * @param string $server The DNS server to use for the query.
     * @return string The result of the TXT record query.
     */
    public static function txtQuery($domain, $server)
    {
        return shell_exec("dig @$server TXT $domain +noall +answer");
    }

    /**
     * Perform a PTR record DNS query for the given IP address.
     *
     * @param string $ip The IP address to perform the PTR query for.
     * @return string The result of the PTR record query.
     */
    public static function ptrQuery($ip)
    {
        return shell_exec("dig -x $ip +noall +answer");
    }
}

class DnsScannerUtil
{
    /**
     * Parse the output of a DNS query.
     *
     * @param string $output The output of the DNS query.
     * @return array The parsed DNS query results.
     */
    public static function parseDnsRecord($output)
    {
        if($output == null) {
            return [];
        }
        // Split output by lines and remove empty lines
        $lines = array_filter(explode("\n", $output));

        $results = array();
        foreach ($lines as $line) {
            // Split each line by whitespace
            $parts = preg_split('/\s+/', $line);

            // Extract name, TTL, class, type, and data
            $name = $parts[0];
            $ttl = $parts[1];
            $class = $parts[2];
            $type = $parts[3];

            // Special handling for SOA records
            if ($type === 'SOA') {
                $data = array(
                    'primary_nameserver' => $parts[4],
                    'responsible_authority' => $parts[5],
                    'serial' => $parts[6],
                    'refresh' => $parts[7],
                    'retry' => $parts[8],
                    'expire' => $parts[9],
                    'min_ttl' => $parts[10]
                );
            } else {
                $data = implode(' ', array_slice($parts, 4));
            }

            // Add parsed data to results array
            $results[] = array(
                'name' => $name,
                'ttl' => $ttl,
                'class' => $class,
                'type' => $type,
                'data' => $data
            );
        }

        return $results;
    }

    /**
     * Parse a PTR record.
     *
     * @param string $ptrRecord The PTR record string.
     * @return array Parsed PTR record data.
     */
    public static function parsePtrRecord($ptrRecord)
    {
        // Split the PTR record by whitespace
        $parts = preg_split('/\s+/', $ptrRecord);

        // Extract the relevant information
        $name = $parts[0];
        $ttl = $parts[1];
        $type = $parts[2];
        $class = $parts[3];
        $data = $parts[4];

        // Return the parsed PTR record data
        return array(
            'name' => $name,
            'ttl' => $ttl,
            'type' => $type,
            'class' => $class,
            'data' => $data
        );
    }
}