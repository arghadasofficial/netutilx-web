<?php
// Get the current file name from the URL
$current_file = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/netutil-x">NetUtil X</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link fw-semibold <?php echo $current_file == "index.php" ? "active" : ""; ?>" href="/netutil-x">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-semibold <?php echo $current_file == "dnsx.php" ? "active" : ""; ?>" href="dnsx.php">DnsX</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-semibold <?php echo $current_file == "pingx.php" ? "active" : ""; ?>" href="pingx.php">PingX</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-semibold <?php echo $current_file == "traceroutex.php" ? "active" : ""; ?>" href="traceroutex.php">TracerouteX</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-semibold <?php echo $current_file == "whoisx.php" ? "active" : ""; ?>" href="whoisx.php">WhoisX</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
