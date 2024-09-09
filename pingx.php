<?php
define("PAGE_TITLE", "PingX - Network Utility Tool");
require 'partials/head.inc.php';
require 'partials/nav.inc.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $host = htmlspecialchars($_POST['host']);
    $pingCount = htmlspecialchars($_POST['pingCount']);
} else {
    $host = "";
    $pingCount = "4";
}
?>

<div class="container mt-5">
    <h1 class="display-4 text-center mb-4">PingX - Advanced Ping Tool</h1>
    <p class="lead text-center mb-5">Get detailed ping results to manage and troubleshoot network configurations effectively. Use PingX to analyze connectivity with precision.</p>

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
                        <div class="mb-3">
                            <label for="pingCount" class="form-label">Ping Count</label>
                            <input value="<?php echo htmlspecialchars($pingCount); ?>" type="number" class="form-control" id="pingCount" name="pingCount" placeholder="4" min="1" required>
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
                        $host = htmlspecialchars($_POST['host']);
                        $pingCount = htmlspecialchars($_POST['pingCount']);

                        // Replace this with your actual ping logic
                        $response = shell_exec("ping -c $pingCount $host");

                        echo "<pre>" . htmlentities($response) . "</pre>";
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
        var promotionalText = "\n\n---\nData sourced from PingX, your comprehensive network utility tool. Explore more at https://development.grow10x.app/pingx/ for advanced network diagnostics.";

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
