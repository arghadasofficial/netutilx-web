<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Advanced DNS tool for network management and troubleshooting.">
  <meta name="keywords" content="DNS, Network Utility, DNS Tool, IP Lookup, Domain Lookup">
  <meta property="og:title" content="<?php echo PAGE_TITLE; ?>">
  <meta property="og:description" content="Advanced DNS tool for network management and troubleshooting.">
  <!-- <meta property="og:image" content="path/to/your/image.jpg">
  <meta property="og:url" content="https://www.yourwebsite.com">
  <meta property="og:type" content="website"> -->
  <title><?php echo PAGE_TITLE; ?></title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Add custom styles to give a tech-based feel */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .navbar-brand {
      letter-spacing: 1px;
    }

    .nav-link {
      transition: color 0.2s ease-in-out;
    }

    .nav-link:hover {
      color: #ffc107 !important;
    }

    footer ul {
      padding-left: 0;
    }

    footer ul li {
      display: inline;
      margin-right: 15px;
    }

    .tech-card {
      background-color: #f8f9fa;
      border-radius: 10px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .tech-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    a.text-decoration-none {
      text-decoration: none;
    }

    .console-output {
      font-family: 'Courier New', Courier, monospace;
      /* Monospaced font for code */
      background-color: #f5f5f5;
      /* Light background for readability */
      color: #333;
      /* Dark text for contrast */
      border: 1px solid #ccc;
      /* Light grey border */
      padding: 10px;
      /* Padding for readability */
      white-space: pre-line;
      /* Preserves whitespace and formatting */
      overflow: auto;
      font-size: 0.9rem;
      /* Slightly smaller font size */
      line-height: 1.4;
      /* Improve line spacing */
    }

    .console-output p {
      margin: 0;
      padding: 0;
    }

    .console-output h4 {
      font-size: 1.1rem;
      /* Slightly larger heading size for clarity */
      margin-bottom: 10px;
      /* More space below headings */
    }

    .console-output hr {
      border: 0;
      border-top: 1px solid #ccc;
      /* Light grey line */
      margin: 10px 0;
      /* Space around the line */
    }

  </style>
</head>

<body>