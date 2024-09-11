<?php
define("PAGE_TITLE", "NetUtilX - Network Utility Tool");
require 'partials/head.inc.php';
require 'partials/nav.inc.php';
?>

<div class="container mt-5">
    <h1 class="display-4 text-center">NetUtilX - Precision Network Tools</h1>
    <p class="lead text-center">Advanced tools designed to help you diagnose and resolve network issues effectively. Leverage the power of DNS Scanner, Ping, Traceroute, & Whois to maintain seamless connectivity.</p>

    <!-- Tools Section -->
    <div class="row mt-4 text-start">
        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <a href="dnsx.php" class="text-decoration-none">
                    <div class="card h-100 tech-card">
                        <div class="card-body">
                            <h3 class="card-title text-dark">DNS X</h3>
                            <p class="card-text text-dark">Accurately retrieve and analyze DNS records. Ideal for network administrators and developers who need detailed domain information to manage configurations and troubleshoot issues.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="pingx.php" class="text-decoration-none">
                    <div class="card h-100 tech-card">
                        <div class="card-body">
                            <h3 class="card-title text-dark">Ping X</h3>
                            <p class="card-text text-dark">Efficiently test network reachability and latency. Monitor server availability and troubleshoot connectivity issues with reliable results.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="traceroutex.php" class="text-decoration-none">
                    <div class="card h-100 tech-card">
                        <div class="card-body">
                            <h3 class="card-title text-dark">Traceroute X</h3>
                            <p class="card-text text-dark">Trace the route data packets take across the network. Identify network bottlenecks and optimize performance with detailed route analysis.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="whoisx.php" class="text-decoration-none">
                    <div class="card h-100 tech-card">
                        <div class="card-body">
                            <h3 class="card-title text-dark">Whois X</h3>
                            <p class="card-text text-dark">Retrieve detailed information about domain registrations. Ideal for checking domain ownership, registration dates, and contact information.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<?php require 'partials/foot.inc.php'; ?>
