<!-- Footer -->
<footer class="bg-dark text-white text-center py-4 mt-5 shadow-sm">
  <div class="container">
    <p>&copy; 2024 NetUtil-X. All rights reserved.</p>
    <p class="small">Built with PHP, Network Precision & ❤️️ in India</p>
    <!-- <ul class="list-inline">
      <li class="list-inline-item"><a href="policy.php" class="text-white">Privacy Policy</a></li>
      <li class="list-inline-item"><a href="termsofuse.php" class="text-white">Terms of Service</a></li>
      <li class="list-inline-item"><a href="api_docs.php" class="text-white">API Docs</a></li>
    </ul> -->
  </div>
</footer>

<!-- Bootstrap Bundle with Popper -->
<script src="assets/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Copy Button Functionality
    document.getElementById('copyButton').addEventListener('click', function() {
      var outputText = document.getElementById('console-output').innerText;

      // Copy the output content to the clipboard
      navigator.clipboard.writeText(outputText).then(function() {
        console.log('Copied to clipboard!');
      }).catch(function(error) {
        console.error('Error copying to clipboard: ', error);
      });
    });
  });
</script>

</body>

</html>