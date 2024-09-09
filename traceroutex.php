<?php
define("PAGE_TITLE", "TracrouteX - Network Utility Tool");
require 'partials/head.inc.php';
require 'partials/nav.inc.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $host = htmlspecialchars($_POST['host']);

    if (!empty($host)) {
        // Escape shell arguments to avoid injection vulnerabilities
        $hostEscaped = escapeshellarg($host);

        // Execute the traceroute command
        $command = "traceroute $hostEscaped 2>&1";
        $output = shell_exec($command);
    }
} else {
    $host = "";
    $output = "";
}
?>

<div class="container mt-5">
    <h1 class="display-4 text-center mb-4">TracerouteX - Traceroute Tool</h1>
    <p class="lead text-center mb-5">Get detailed traceroute information to manage and troubleshoot network paths effectively. Use TracerouteX to analyze the path of packets with precision.</p>

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
                            <label for="host" class="form-label">Host</label>
                            <input value="<?php echo htmlspecialchars($host); ?>" type="text" class="form-control" id="host" name="host" placeholder="example.com" required>
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
                    if (!empty($output)) {
                        echo "<pre>" . htmlentities($output) . "</pre>";
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
        var promotionalText = "\n\n---\nData sourced from TracerouteX, your comprehensive network utility tool. Explore more at https://development.grow10x.app/traceroutex/ for advanced network diagnostics.";

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
