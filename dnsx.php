<?php
define("PAGE_TITLE", "DNS X - Network Utility Tool");
require 'partials/head.inc.php';
require 'partials/nav.inc.php';

// Add your API key here
$apiKey = '7de71c8035945809ef7ba64cd9264570498dc1186f8dcf78663c1fa4a2d423de';
$apiBaseUrl = 'https://development.grow10x.app/api/netutil/dnsx/';

function parseDnsResponse($response)
{
    // Check if response is successful and contains data
    if (isset($response['success']) && $response['success'] && !empty($response['data'])) {
        $parsedRecords = [];

        // Loop through each DNS record
        foreach ($response['data'] as $record) {
            $name = $record['name'];
            $ttl = $record['ttl'];
            $class = $record['class'];
            $type = $record['type'];

            // Check if the type is SOA, which contains a nested array
            if ($type == 'SOA') {
                $soaData = $record['data'];
                $parsedRecords[] = [
                    'Name' => $name,
                    'TTL' => $ttl,
                    'Class' => $class,
                    'Type' => $type,
                    'Primary Nameserver' => $soaData['primary_nameserver'],
                    'Responsible Authority' => $soaData['responsible_authority'],
                    'Serial' => $soaData['serial'],
                    'Refresh' => $soaData['refresh'],
                    'Retry' => $soaData['retry'],
                    'Expire' => $soaData['expire'],
                    'Minimum TTL' => $soaData['min_ttl'],
                ];
            } else {
                // For other record types, data is a simple value
                $parsedRecords[] = [
                    'Name' => $name,
                    'TTL' => $ttl,
                    'Class' => $class,
                    'Type' => $type,
                    'Data' => $record['data'],
                ];
            }
        }

        // Return the parsed records
        return $parsedRecords;
    } else {
        // If no data or unsuccessful response
        return "No result";
    }
}


// Function to fetch data from the API
function fetchInputDataFromAPI($endpoint, $apiKey)
{
    $url = $endpoint . '?api_key=' . urlencode($apiKey);
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function fetchFromApi($endpoint, $apiKey, $params = [])
{
    // Add the API key to the parameters array
    $params['api_key'] = $apiKey;

    // Build the query string from the parameters array
    $queryString = http_build_query($params);

    // Create the full URL with the query string
    $url = $endpoint . '?' . $queryString;

    // Fetch the response from the API
    $response = file_get_contents($url);

    // Return the decoded JSON response
    return json_decode($response, true);
}


// Fetch DNS Servers
$serversResponse = fetchInputDataFromAPI($apiBaseUrl . 'get_servers.php', $apiKey);
$servers = $serversResponse['success'] ? $serversResponse['data'] : [];

// Fetch DNS Query Types
$typesResponse = fetchInputDataFromAPI($apiBaseUrl . 'get_types.php', $apiKey);
$types = $typesResponse['success'] ? $typesResponse['data'] : [];

// Default values
$inputQuery = isset($_POST['searchBox']) ? htmlspecialchars($_POST['searchBox']) : "";
$typeQuery = isset($_POST['typeSelector']) ? htmlspecialchars($_POST['typeSelector']) : "a";
$serverQuery = isset($_POST['serverSelector']) ? htmlspecialchars($_POST['serverSelector']) : "8.8.8.8";
?>

<div class="container mt-5">
    <h1 class="display-4 text-center mb-4">DNS X - Advanced DNS Tool</h1>
    <p class="lead text-center mb-5">Get detailed DNS information to manage and troubleshoot network configurations effectively. Use DNS X to analyze domain records with precision.</p>

    <!-- Input and Output Section -->
    <div class="row">
        <!-- Input Pane -->
        <div class="col-md-6">
            <div class="card border-0 shadow tech-card">
                <div class="card-header bg-dark text-light">
                    <h5 class="mb-0">Input Pane</h5>
                </div>
                <div class="card-body">
                    <form id="inputForm" method="POST">
                        <div class="mb-3">
                            <label for="searchBox" class="form-label">IP / Domain</label>
                            <input value="<?php echo htmlspecialchars($inputQuery); ?>" type="text" class="form-control" id="searchBox" name="searchBox" placeholder="8.8.8.8 / google.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="typeSelector" class="form-label">Query Type</label>
                            <select class="form-select" id="typeSelector" name="typeSelector" required>
                                <?php foreach ($types as $type): ?>
                                    <option value="<?php echo htmlspecialchars(strtolower($type)); ?>" <?php echo $typeQuery == strtolower($type) ? "selected" : ""; ?>>
                                        <?php echo htmlspecialchars(strtoupper($type)); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="serverSelector" class="form-label">Query Server</label>
                            <select class="form-select" id="serverSelector" name="serverSelector" required>
                                <?php foreach ($servers as $server): ?>
                                    <option value="<?php echo htmlspecialchars($server['id']); ?>" <?php echo $serverQuery == $server['id'] ? "selected" : ""; ?>>
                                        <?php echo htmlspecialchars($server['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Output Pane -->
        <div class="col-md-6">
            <div class="card border-0 shadow tech-card">
                <div class="card-header bg-dark text-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Output Pane</h5>
                    <button id="copyButton" class="btn btn-success">Copy</button>
                </div>
                <div id="console-output" class="card-body console-output overflow-auto" style="max-height: 328px;">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $searchBox = htmlspecialchars($_POST['searchBox']);
                        $typeSelector = htmlspecialchars($_POST['typeSelector']);
                        $serverSelector = htmlspecialchars($_POST['serverSelector']);

                        // Add your API request and output processing here
                        // This will be similar to the form handling you did earlier

                        // Example for output (replace with your own implementation):

                        // Additional parameters (e.g., for DNS info)
                        $params = [
                            'query' => $searchBox,
                            'type' => $typeSelector,
                            'server' => $serverSelector
                        ];;

                        // Fetch data from the API
                        $response = fetchFromApi($apiBaseUrl . 'get_dns_info.php', $apiKey, $params);

                        $parsedRecords = parseDnsResponse($response);

                        // Display parsed records
                        if (is_array($parsedRecords)) {
                            foreach ($parsedRecords as $record) {
                                foreach ($record as $key => $value) {
                                    echo $key . ": " . $value . "\n";
                                }
                                echo "\n";
                            }
                        } else {
                            echo $parsedRecords; // "No result" message
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'partials/foot.inc.php'; ?>