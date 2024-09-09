<?php
define("PAGE_TITLE", "DNS X - Network Utility Tool");
require 'partials/head.inc.php';
require 'partials/nav.inc.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $inputQuery = htmlspecialchars($_POST['searchBox']);
    $typeQuery = htmlspecialchars($_POST['typeSelector']);
    $serverQuery = htmlspecialchars($_POST['serverSelector']);
} else {
    $inputQuery = "";
    $typeQuery = "a";
    $serverQuery = "8.8.8.8";
}
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
                                <option value="all" <?php echo $typeQuery == "all" ? "selected" : ""; ?>>ALL</option>
                                <option value="a" <?php echo $typeQuery == "a" ? "selected" : ""; ?>>A</option>
                                <option value="ns" <?php echo $typeQuery == "ns" ? "selected" : ""; ?>>NS</option>
                                <option value="mx" <?php echo $typeQuery == "mx" ? "selected" : ""; ?>>MX</option>
                                <option value="soa" <?php echo $typeQuery == "soa" ? "selected" : ""; ?>>SOA</option>
                                <option value="txt" <?php echo $typeQuery == "txt" ? "selected" : ""; ?>>TXT</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="serverSelector" class="form-label">Query Server</label>
                            <select class="form-select" id="serverSelector" name="serverSelector" required>
                                <option value="8.8.8.8" <?php echo $serverQuery == "8.8.8.8" ? "selected" : ""; ?>>Google Public DNS</option>
                                <option value="1.1.1.1" <?php echo $serverQuery == "1.1.1.1" ? "selected" : ""; ?>>Cloudflare DNS</option>
                                <option value="9.9.9.9" <?php echo $serverQuery == "9.9.9.9" ? "selected" : ""; ?>>Quad9 DNS</option>
                                <option value="208.67.222.222" <?php echo $serverQuery == "208.67.222.222" ? "selected" : ""; ?>>OpenDNS</option>
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
                    <button id="copyButton" class="btn btn-success">Copy </button>
                </div>
                <div id="console-output" class="card-body console-output overflow-auto" style="max-height: 328px;">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $searchBox = htmlspecialchars($_POST['searchBox']);
                        $typeSelector = htmlspecialchars($_POST['typeSelector']);
                        $serverSelector = htmlspecialchars($_POST['serverSelector']);

                        require 'utils/DnsUtil.php';

                        $response = "";

                        if (InputHandler::isDomain($searchBox) == "ip") {
                            $response = DnsScannerUtil::parsePtrRecord(Scanners::ptrQuery($searchBox));
                            echo "<div class='alert alert-info'><h4 class='alert-heading'>PTR Record:</h4>";
                            echo "<p><strong>IP:</strong> " . $searchBox . "</p>";
                            echo "<p><strong>Domain:</strong> " . $response['data'] . "</p>";
                            echo "<p><strong>TTL:</strong> " . $response['ttl'] . " seconds</p></div>";
                        }

                        if (InputHandler::isDomain($searchBox) == "domain") {
                            switch ($typeSelector) {
                                case 'a':
                                    $output = Scanners::aQuery($searchBox, $serverSelector);
                                    $parsedOutput = DnsScannerUtil::parseDnsRecord($output);
                                    $response = ["a_record" => $parsedOutput];
                                    break;
                                case 'ns':
                                    $output = Scanners::nsQuery($searchBox, $serverSelector);
                                    $parsedOutput = DnsScannerUtil::parseDnsRecord($output);
                                    $response = ["ns_record" => $parsedOutput];
                                    break;
                                case 'mx':
                                    $output = Scanners::mxQuery($searchBox, $serverSelector);
                                    $parsedOutput = DnsScannerUtil::parseDnsRecord($output);
                                    $response = ["mx_record" => $parsedOutput];
                                    break;
                                case 'txt':
                                    $output = Scanners::txtQuery($searchBox, $serverSelector);
                                    $parsedOutput = DnsScannerUtil::parseDnsRecord($output);
                                    $response = ["txt_record" => $parsedOutput];
                                    break;
                                case 'soa':
                                    $output = Scanners::soaQuery($searchBox, $serverSelector);
                                    $parsedOutput = DnsScannerUtil::parseDnsRecord($output);
                                    $response = ["soa_record" => $parsedOutput];
                                    break;
                                case 'all':
                                    $aRecord = Scanners::aQuery($searchBox, $serverSelector);
                                    $nsRecord = Scanners::nsQuery($searchBox, $serverSelector);
                                    $mxRecord = Scanners::mxQuery($searchBox, $serverSelector);
                                    $txtRecord = Scanners::txtQuery($searchBox, $serverSelector);
                                    $soaRecord = Scanners::soaQuery($searchBox, $serverSelector);
                                    $data = [
                                        'a_record' => DnsScannerUtil::parseDnsRecord($aRecord),
                                        'ns_record' => DnsScannerUtil::parseDnsRecord($nsRecord),
                                        'mx_record' => DnsScannerUtil::parseDnsRecord($mxRecord),
                                        'txt_record' => DnsScannerUtil::parseDnsRecord($txtRecord),
                                        'soa_record' => DnsScannerUtil::parseDnsRecord($soaRecord)
                                    ];
                                    $response = $data;
                                    break;
                            }
                        }

                        if (InputHandler::isDomain($searchBox) == "unknown") {
                            $response = "<div class='alert alert-danger'>Invalid Domain / IP</div>";
                        }
                        function displayRecord($recordType, $records)
                        {
                            echo "<div class='console-output'><h4>" . strtoupper($recordType) . " Record:</h4>";
                            foreach ($records as $record) {
                                echo "<p><strong>Domain:</strong> {$record['name']}</p>";
                                echo "<p><strong>TTL:</strong> {$record['ttl']} seconds</p>";
                                echo "<p><strong>Class:</strong> {$record['class']}</p>";
                                echo "<p><strong>Type:</strong> {$record['type']}</p>";
                                echo "<p><strong>Data:</strong> {$record['data']}</p>";
                                echo "<hr>"; // To separate multiple records
                            }
                            echo "</div>";
                        }

                        // Display Records Based on Query Type
                        if (isset($response['a_record'])) {
                            displayRecord('A', $response['a_record']);
                        }
                        if (isset($response['ns_record'])) {
                            displayRecord('NS', $response['ns_record']);
                        }
                        if (isset($response['mx_record'])) {
                            displayRecord('MX', $response['mx_record']);
                        }
                        if (isset($response['txt_record'])) {
                            displayRecord('TXT', $response['txt_record']);
                        }
                        if (isset($response['soa_record'])) {
                            echo "<div class='console-output'><h4>SOA Record:</h4>";
                            $soa = $response['soa_record'][0];
                            echo "<p><strong>Primary Nameserver:</strong> {$soa['data']['primary_nameserver']}</p>";
                            echo "<p><strong>Responsible Authority:</strong> {$soa['data']['responsible_authority']}</p>";
                            echo "<p><strong>Serial:</strong> {$soa['data']['serial']}</p>";
                            echo "<p><strong>Refresh:</strong> {$soa['data']['refresh']} seconds</p>";
                            echo "<p><strong>Retry:</strong> {$soa['data']['retry']} seconds</p>";
                            echo "<p><strong>Expire:</strong> {$soa['data']['expire']} seconds</p>";
                            echo "<p><strong>Minimum TTL:</strong> {$soa['data']['min_ttl']} seconds</p></div>";
                        }

                        // Display PTR Record if the query type is 'all' or 'ptr'
                        if (isset($response['ptr_record'])) {
                            echo "<div class='console-output'><h4>PTR Record:</h4>";
                            $ptr = $response['ptr_record'][0];
                            echo "<p><strong>Domain:</strong> {$ptr['name']}</p>";
                            echo "<p><strong>TTL:</strong> {$ptr['ttl']} seconds</p>";
                            echo "<p><strong>Class:</strong> {$ptr['class']}</p>";
                            echo "<p><strong>Type:</strong> {$ptr['type']}</p>";
                            echo "<p><strong>Data:</strong> {$ptr['data']}</p></div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('copyButton').addEventListener('click', function() {
        var outputText = document.getElementById('console-output').innerText;

        // Define the professional and tech enthusiast promotional text
        var promotionalText = "\n\n---\nData sourced from NetUtilX, your comprehensive network utility tool. Explore more at https://development.grow10x.app/netutil/ for advanced DNS analysis and network diagnostics.";

        // Combine the output content with the promotional text
        var textToCopy = outputText + promotionalText;

        // Copy the combined text to the clipboard
        navigator.clipboard.writeText(textToCopy).then(function() {
            console.log('Copied to clipboard!');
        }).catch(function(error) {
            console.error('Error copying to clipboard: ', error);
        });
    });
});
</script>



<?php require 'partials/foot.inc.php'; ?>