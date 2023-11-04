<!DOCTYPE html>
<html lang="en">
<?php if (isset($_GET['p'])): ?>
  <style media="screen">
    #mainNav{
      background: black !important;
    }
    button > * {
      pointer-events: none;
    }
    a > * {
      pointer-events: none;
    }
  </style>
<?php endif; ?>
<body>
    <?php _pageContent(); ?>
    <?php _pageScript(); ?>
    <?php if ($lazy_load) { _lazyLoadScript(); } ?>
</body>
</html>
