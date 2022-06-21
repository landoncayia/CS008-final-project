<!-- Navigation Bar -->
<nav>
    <ul>
        <?php
        print '<li class="';
        if ($path_parts['filename'] == "index") {
            print 'activePage';
        }
        print '">';
        print '<a href="../../sitemap.php">Site Map</a>';
        print '</li>';
        ?>
        
        <?php
        print '<li class="';
        if ($path_parts['filename'] == "about") {
            print 'activePage';
        }
        print '">';
        print '<a href="about.php">About</a>';
        print '</li>';
        ?>
        
        <?php
        print '<li class="';
        if ($path_parts['filename'] == "gallery") {
            print 'activePage';
        }
        print '">';
        print '<a href="gallery.php">Photo Gallery</a>';
        print '</li>';
        ?>
        
        <?php
        print '<li class="';
        if ($path_parts['filename'] == "submit-photo") {
            print 'activePage';
        }
        print '">';
        print '<a href="submit-photo.php">Submit a Photo</a>';
        print '</li>';
        ?>
        
        <?php
        print '<li class="';
        if ($path_parts['filename'] == "past-winners") {
            print 'activePage';
        }
        print '">';
        print '<a href="past-winners.php">Past Contest Winners</a>';
        print '</li>';
        ?>
        
        <?php
        print '<li class="';
        if ($path_parts['filename'] == "who-we-support") {
            print 'activePage';
        }
        print '">';
        print '<a href="who-we-support.php">Who We Support</a>';
        print '</li>';
        ?>
        
        <?php
        print '<li class="';
        if ($path_parts['filename'] == "pricing") {
            print 'activePage';
        }
        print '">';
        print '<a href="pricing.php">Pricing</a>';
        print '</li>';
        ?>
    </ul>
</nav>
<!-- End of Navigation Bar -->